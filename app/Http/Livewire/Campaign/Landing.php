<?php

namespace App\Http\Livewire\Campaign;

use App\Models\Campaign;
use App\Models\Donor;
use App\Models\Group;
use App\Models\Recipient;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cookie;
use Livewire\Component;

class Landing extends Component
{
    public Campaign $campaign;
    public Donor $donor;
    public int $count;

    public function mount()
    {
        $this->donor = Donor::where('public_key', Cookie::get('shai_public_key'))->first();
        $this->count = $this->donor->recipients()->count();
    }

    public function getCollection()
    {
        if($this->campaign->toggle_group)
        {
            return $this->campaign->availableGroups;
        } else {
            return $this->campaign->available;
        }
    }

    public function render()
    {
        return view('livewire.campaign.landing', [
            'collection' => $this->getCollection(),
        ]);
    }
}
