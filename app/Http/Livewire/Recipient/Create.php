<?php

namespace App\Http\Livewire\Recipient;

use App\Models\Campaign;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Create extends Component
{
    public Campaign $campaign;
    public Collection $groups;

    public function mount()
    {
        $this->groups = $this->campaign->groups;
    }

    public function render()
    {
        return view('livewire.recipient.create');
    }
}
