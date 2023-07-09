<?php

namespace App\Http\Livewire\Campaign;

use App\Models\Campaign;
use App\Models\Donor;
use App\Models\Group;
use App\Models\Recipient;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cookie;
use Livewire\Component;

class Landing extends Component
{
    public Campaign $campaign;
    public Collection $collection;
    public Donor $donor;
    public array $meta;
    public bool $toggleGroups = false;
    public int $countSelection = 0;

    public function mount(mixed $donor = false)
    {
        if(!$donor)
        {
            $this->donor = Donor::where('public_key', Cookie::get('shai_public_key'))->first();
        }

        $this->toggleGroups = $this->campaign->toggle_group ?: false;
        if($this->toggleGroups)
        {
            $this->collection = $this->campaign->groups;
        } else {
            $this->collection = $this->campaign->available;
        }
    }

    public function pollingData()
    {
        if($this->toggleGroups)
        {
            $this->collection = $this->campaign->groups;
            $this->count = $this->donor->recipients()->count();
        } else {
            $this->collection = $this->campaign->available;
            $this->count = $this->donor->recipients()->count();
        }
    }

    public function changeFilter()
    {
        $this->collection = $this->campaign->recipients()->meta()->where(function($query){
            $query->where('recipients_meta.key', '=', array_keys($this->meta))
                  ->where('recipients_meta.value', '=', array_values($this->meta));
        })->get();
    }

    public function addRecipientToCard($ulid)
    {
        if($this->toggleGroups)
        {
            $group = Group::find($ulid);
            $group->update([
                'held_at' => Carbon::now()
            ]);

            foreach($group->recipients as $recipient)
            {
                $recipient->donors()->attach($this->donor->id);
            }

            $this->collection = $this->campaign->groups;
            $this->count = $this->donor->recipients()->count();
        } else {
            $recipient = Recipient::find($ulid);
            $recipient->update([
                'held_at' => Carbon::now()
            ]);

            $recipient->donors()->attach($this->donor->id);
            $this->collection = $this->campaign->available;
            $this->count = $this->donor->recipients()->count();
        }
    }

    public function render()
    {
        return view('livewire.campaign.landing', [
            'count' => $this->donor->recipients()->count(),
        ]);
    }
}
