<?php

namespace App\Http\Livewire\Donor;

use Livewire\Component;

class Register extends Component
{
    public function render()
    {
        return view('livewire.donor.register')->layout('layouts.guest');
    }
}
