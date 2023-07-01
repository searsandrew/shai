<?php

namespace App\Actions\Donor;

use App\Mail\SendDonorEmail;
use App\Models\Donor;
use App\Models\DonorRecipient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;
use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\ActionRequest;

class Claim
{
    use AsAction;

    public function handle(Donor $donor) : array
    {
        $recipients = DonorRecipient::where([
            'donor_id' => $donor->id,
            'status' => 'holding'
        ])->get();
        $collection = $donor->recipients()->where('status', 'holding')->get();

        $mail = Mail::to($donor->email)->send(new SendDonorEmail($collection, 'selection'));
        
        foreach($collection as $recipient)
        {
            $recipient->donors()->updateExistingPivot($donor->id, [
                'status' => 'claimed',
            ]);
        }

        return ['status' => 'success', 'message' => 'Recipients set and Email sent.'];
    }

    public function asController(ActionRequest $request, Donor $donor) : RedirectResponse
    {
        $this->handle($donor);
        Cookie::queue(Cookie::forget('shai_public_key'));

        return back();
    }
}
