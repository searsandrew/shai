<?php

namespace App\Actions\Recipient;

use App\Models\Donor;
use App\Models\Recipient;
use Illuminate\Support\Facades\Cookie;
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

        return $donor->recipients()->attach($recipient);
    }

    public function asController(ActionRequest $request)
    {
        $recipient = Recipient::find($request->only('recipient'));
        $donor = Donor::where('public_key', $request->cookie('shai_public_key'))->first();

        $handler = $this->handle($recipient, $donor);
        return redirect(route('donor.dashboard'));
    }
}
