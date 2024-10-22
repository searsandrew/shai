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
    public array $options = [];
    public int $count;
    public string $filter = '';

    public $listeners = [
        'remove-donor' => 'getCollection',
    ];

    public function mount()
    {
        $this->donor = Donor::where('public_key', Cookie::get('shai_public_key'))->first();
        $this->count = $this->donor->recipients()->count();

        $keys = $this->campaign->recipients()->meta()->select('recipients_meta.key')->groupBy('recipients_meta.key')->get()->pluck('key');
        foreach($keys as $key)
        {
            $this->options[$key] = $this->campaign->recipients()->meta()->select('recipients_meta.value')->groupBy('recipients_meta.value')->orderBy('recipients_meta.value', 'asc')->where('recipients_meta.key', $key)->get()->pluck('value');
        }
    }

    public function setFilter(string $key)
    {
        dd($key . $this->filter);
    }

    public function getCollection()
    {
        if($this->campaign->toggle_group)
        {
            return $this->campaign->availableGroups()->paginate();
        } else {
            return $this->campaign->available;
        }
    }

    public function render()
    {
        return view('livewire.campaign.landing', [
            'collection' => $this->getCollection(),
        ])->layout('layouts.landing');
    }
}
