<?php

namespace App\Http\Livewire\Donor;

use App\Models\Donor;
use Illuminate\Support\Facades\Cookie;
use Livewire\Component;

class Dashboard extends Component
{
    public Donor $donor;
    public $recipients;

    public function mount()
    {
        $cookie = Cookie::get('shai_public_key');
        $this->donor = Donor::where('public_key', $cookie)->first();
        $this->recipients = $this->donor->recipients;
    }

    public function render()
    {
        return view('livewire.donor.dashboard')->layout('layouts.guest');
    }
}
