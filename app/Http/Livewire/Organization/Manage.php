<?php

namespace App\Http\Livewire\Organization;

use App\Mail\SendInviteCode;
use App\Models\Address;
use App\Models\Invite;
use App\Models\Organization;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Manage extends Component
{
    public Address $address;
    public Organization $organization;
    public string $invite;

    public $rules = [
        'organization.name' => 'required',
        'organization.tax_id' => 'nullable',
        'address.street' => 'required',
        'address.unit' => 'nullable',
        'address.city' => 'required',
        'address.state' => 'required',
        'address.zip' => 'required',
    ];

    public function sendInviteCode()
    {
        $sendInvite = Auth::user()->invites()->create([
            'email' => $this->invite,
        ]);

        Mail::to($sendInvite->email)->send(new SendInviteCode($sendInvite));

        $invite = '';
    }

    public function render()
    {
        return view('livewire.organization.manage');
    }
}
