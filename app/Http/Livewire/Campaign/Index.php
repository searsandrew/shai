<?php

namespace App\Http\Livewire\Campaign;

use Livewire\Component;

use Auth;

class Index extends Component
{
    public function mount()
    {
        dd(Auth::user()->organizations);
    }

    public function render()
    {
        return view('livewire.campaign.index');
    }
}
