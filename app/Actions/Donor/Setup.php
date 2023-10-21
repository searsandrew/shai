<?php

namespace App\Actions\Donor;

use App\Models\Donor;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\ActionRequest;

class Setup
{
    use AsAction;

    public function handle(string $name, string $email): Donor
    {
        return Donor::firstOrCreate(
            [ 'email' => $email ],
            [ 'name' => $name ]
        );
    }

    public function asController(ActionRequest $request)
    {
        $request->validated();
        $donor = $this->handle($request->name, $request->email);

        if(!is_null($request->recipient))
        {
            $donor->recipients()->attach($request->only('recipient'));
        }

        Cookie::queue('shai_public_key', $donor->public_key, 43200);

        if(!is_null($request->ref))
        {
            return redirect(Crypt::decryptString($request->ref));
        }
        return redirect(route('donor.dashboard'));
    }

    public function rules(): array
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'email:rfc,dns'],
        ];
    }
}
