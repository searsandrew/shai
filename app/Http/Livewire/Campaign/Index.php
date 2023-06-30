<?php

namespace App\Http\Livewire\Campaign;

use App\Models\Campaign;
use App\Models\Organization;
use Illuminate\Support\Str;
use Livewire\Component;

use Auth;

class Index extends Component
{
    public Campaign $campaign;
    public Organization $organization;
    public string $name, $started_at, $ended_at;
    public bool $modal = false, $toggleImage = false, $toggleGroup = false, $togglePrivacy = false;

    protected $rules = [
        'campaign.name' => 'required',
        'campaign.started_at' => 'required',
        'campaign.ended_at' => 'required',
    ];

    public function mount()
    {
        $this->campaign = new Campaign();
        $this->organization = Auth::user()->selectedOrganization();
    }

    public function toggle(string $action, bool $true = false)
    {
        $camelCased = Str::camel('toggle-' . $action);
        $this->$camelCased = $true;
    }

    public function createCampaign()
    {
        $this->validate();
        $this->campaign->organization()->associate($this->organization);
        $this->campaign->setMeta([
            'toggle_image' => $this->toggleImage,
            'toggle_group' => $this->toggleGroup,
            'toggle_privacy' => $this->togglePrivacy,
        ]);
        $this->campaign->save();
    }

    public function render()
    {
        return view('livewire.campaign.index');
    }
}
