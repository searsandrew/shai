<?php

namespace App\Http\Livewire\Recipient;

use App\Actions\Recipient\Claim as RecipientClaim;
use App\Mail\SendDonorEmail;
use App\Models\Campaign;
use App\Models\Donor;
use App\Models\DonorRecipient;
use App\Models\Group;
use App\Models\Recipient;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public Campaign $campaign;
    public Group $group;
    public Recipient $recipient;
    public bool $toggleRecipient = false, $toggleEditRecipient = false, $toggleGroups, $modal = false;
    public array $keys, $meta, $setRules = [];
    public string $claimCode = '', $name = '', $email = '', $emailType = 'selection';

    protected $rules = [];
//    protected $queryString = [
//        'recipient', 'group'
//    ];

    public function mount()
    {
        $this->toggleGroups = $this->campaign->toggle_group ?: false;
        $this->recipient = new Recipient();
        $this->group = new Group();
    }

    public function activateItem(string $ulid)
    {
        // dd($ulid);
        if($this->toggleGroups)
        {
            $this->group = Group::find($ulid);
            // dd($this->group);
            $ulid = $this->group->id;
            $type = 'group';
        } else {
            $this->recipient = Recipient::find($ulid);
            $this->meta = $this->recipient->getMeta()->toArray();
            $this->keys = array_keys($this->meta);

            foreach($this->keys as $key)
            {
                $this->rules['recipient.' . $key] = 'required';
            }

            $ulid = $this->recipient->id;
            $type = 'recipient';
        }

        $this->claimCode = route('recipient.claim', [$type, $ulid]);

        $this->toggleRecipient = true;
    }

    public function manuallySendEmail()
    {
        $this->sendEmailToDonor($this->emailType, $this->recipient->donors->first(), false, false);
        $this->reset('emailType');
        $this->emit('manualEmailSent');
    }

    public function manuallyRemoveDonor()
    {
       $this->recipient->donors()->detach();
    }

    public function manuallyAddRecipient()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email:rfc,dns'
        ]);

        try {
            $donor = Donor::where('email', $this->email)->firstOrFail();
        } catch (\Throwable $th) {
            $donor = Donor::create([
                'name' => $this->name,
                'email' => $this->email,
            ]);
        }

        if($this->toggleGroups)
        {
            foreach($this->group->recipients as $recipient)
            {
                RecipientClaim::run($recipient, $donor);
            }
        } else {
            RecipientClaim::run($this->recipient, $donor);
        }

        $this->sendEmailToDonor('selection', $donor);

        $this->reset(['name', 'email']);

        return ['status' => 'success', 'message' => 'Donor Confirmation Sent'];

    }

    public function sendEmailToDonor(string $type, Donor $donor, Collection|bool $collection = false, $update = true)
    {
        switch ($type) {
            case 'reminder':
                $status = 'notified';
                $newStatus = 'notified';
                break;

            case 'completion':
                $status = 'notified';
                $newStatus = 'recieved';
                break;

            default:
                $status = 'claimed';
                $newStatus = 'notified';
                break;
        }

        if(!$collection)
        {
            $collection = $donor->recipients()->where('status', $status)->get();
        }

        $mail = Mail::to($donor->email)->send(new SendDonorEmail($collection, $type));
        foreach($collection as $recipient)
        {
            $donorRecipient = DonorRecipient::where('donor_id', $donor->id)->where('recipient_id', $recipient->id)->first();
            $donorRecipient->communications()->create([
                'type' => $type,
                'payload' => 'Payload logging is unavailable'
            ]);

            if($update)
            {
                $donorRecipient->update([
                    'status' => $newStatus,
                ]);
            }
        }
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.recipient.index', [
            'list' => $this->toggleGroups ? $this->campaign->groups()->paginate(25) : $this->campaign->recipients()->paginate(25)
        ]);
    }
}
