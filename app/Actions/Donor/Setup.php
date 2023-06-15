<?php

namespace App\Actions\Donor;

use App\Models\Donor;
use Illuminate\Support\Facades\Cookie;
use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\ActionRequest;

class Setup
{
    use AsAction;

    public function handle($request)
    {
        $donor = Donor::create($request->only('name', 'email'));
        $donor->recipients()->attach($request->only('recipient'));
        Cookie::queue('shai_public_key', $donor->public_key, 43200);
    }

    public function asController(ActionRequest $request)
    {
        $handler = $this->handle($request);
        return redirect(route('donor.dashboard'));
    }
}
