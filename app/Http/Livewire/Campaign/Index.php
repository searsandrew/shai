<?php

namespace App\Http\Livewire\Campaign;

use App\Models\Campaign;
use App\Models\Organization;
use Livewire\Component;

use Auth;

class Index extends Component
{
    public Campaign $campaign;
    public Organization $organization;
    public bool $modal = false;

    protected $rules = [
        'campaign.name' => 'required',
        'campaign.started_at' => 'required',
        'campaign.ended_at' => 'required',
        'campaign.toggle_image' => 'boolean',
        'campaign.toggle_family' => 'boolean',
        'campaign.toggle_privacy' => 'boolean',
    ];

    public function mount()
    {
        $this->campaign = new Campaign();
        $this->organization = Auth::user()->selectedOrganization();
    }

    public function createCampaign()
    {
        $this->validate();
        $this->campaign->organization()->associate($this->organization);    
        $this->campaign->save();
    }

    public function render()
    {
        return view('livewire.campaign.index');
    }
}
