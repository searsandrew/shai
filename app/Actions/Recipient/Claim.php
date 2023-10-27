<?php

namespace App\Actions\Recipient;

use App\Mail\SendDonorEmail;
use App\Models\Donor;
use App\Models\Group;
use App\Models\Recipient;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class Claim
{
    use AsAction;

    public function handle(Recipient $recipient, mixed $donor = false)
    {
        if(!$donor)
        {
            $donor = Donor::where('public_key', Cookie::get('shai_public_key'))->first();
        }

        $donor->recipients()->attach($recipient, ['status' => 'claimed']);
        $collection = $donor->recipients()->where('status', 'claimed')->get();
        $mail = Mail::to($donor->email)->send(new SendDonorEmail($collection, 'selection'));
        foreach($collection as $notify)
        {
            $notify->communications()->create([
                'type' => 'selection',
                'payload' => json_encode($mail)
            ]);
        }
    }

    public function asController(ActionRequest $request)
    {
        $donor = Donor::where('public_key', Cookie::get('shai_public_key'))->first();

        if($request->type == 'group')
        {
            $group = Group::find($request->ulid);
            foreach($group->recipients as $recipient)
            {
                $this->handle($recipient, $donor);
            }
        } else {
            $recipient = Recipient::find($request->only('recipient'));
            $this->handle($recipient, $donor);
        }

        return redirect(route('donor.dashboard'));
    }
}
