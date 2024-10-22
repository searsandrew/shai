<?php

namespace App\Http\Livewire\Organization;

use Livewire\Component;

class Select extends Component
{
    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.organization.select');
    }
}
