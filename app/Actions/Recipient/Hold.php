<?php

namespace App\Actions\Recipient;

use App\Models\Campaign;
use App\Models\Donor;
use App\Models\Group;
use App\Models\Recipient;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;
use Lorisleiva\Actions\Concerns\AsAction;

class Hold
{
    use AsAction;

    public function handle(Campaign $campaign, Donor $donor, string $ulid)
    {
        if($campaign->toggle_group)
        {
            $group = Group::find($ulid);
            $group->update([
                'held_at' => Carbon::now()
            ]);

            foreach($group->recipients as $recipient)
            {
                $recipient->donors()->attach($donor->id);
            }
        } else {
            $recipient = Recipient::find($ulid);
            $recipient->update([
                'held_at' => Carbon::now()
            ]);

            $recipient->donors()->attach($donor->id);
        }
    }

    public function asController(Campaign $campaign, string $ulid)
    {
        $donor = Donor::where('public_key', Cookie::get('shai_public_key'))->first();
        $this->handle($campaign, $donor, $ulid);

        return redirect(route('campaign.landing', $campaign));
    }
}
