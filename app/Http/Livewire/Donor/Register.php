<?php

namespace App\Http\Livewire\Donor;

use Livewire\Component;
use Illuminate\Http\Request;

class Register extends Component
{
    public string|bool $ref;

    public function mount(Request $request)
    {
        $this->ref = $request->ref ?? false;
    }

    public function render()
    {
        return view('livewire.donor.register')->layout('layouts.guest');
    }
}
