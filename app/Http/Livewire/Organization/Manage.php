<?php

namespace App\Http\Livewire\Organization;

use App\Mail\SendInviteCode;
use App\Models\Address;
use App\Models\Organization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Manage extends Component
{
    public Address $address;
    public Organization $organization;
    public bool $inviteSuccess = false;
    public string $invite = '';

    public $rules = [
        'organization.name' => 'required',
        'organization.tax_id' => 'nullable',
        'address.street' => 'required',
        'address.unit' => 'nullable',
        'address.city' => 'required',
        'address.state' => 'required',
        'address.zip' => 'required',
    ];

    public function sendInviteCode(): void
    {
        $this->validate([
            'invite' => ['required', 'email:rfc,dns'],
        ]);

        $sendInvite = Auth::user()->invites()->create([
            'organization_id' => $this->organization->id,
            'email' => $this->invite,
        ]);

        Mail::to($sendInvite->email)->send(new SendInviteCode($sendInvite));

        $this->reset('invite');
        $this->inviteSuccess = true;
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.organization.manage');
    }
}
