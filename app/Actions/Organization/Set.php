<?php

namespace App\Actions\Organization;

use App\Models\Organization;
use Lorisleiva\Actions\Concerns\AsAction;

use Auth;

class Set
{
    use AsAction;

    public function handle(Organization $organization)
    {
        Auth::user()->organization = $organization->id;
        return Auth::user()->save();
    }

    public function asController(Organization $organization)
    {
        $this->handle($organization);
        return back();
    }
}
