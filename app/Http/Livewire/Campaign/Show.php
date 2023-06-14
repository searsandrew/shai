<?php

namespace App\Http\Livewire\Campaign;

use App\Models\Campaign;
use Illuminate\Support\Str;
use Livewire\Component;

class Show extends Component
{
    public Campaign $campaign;
    public bool $editImage = false, $editFamily = false, $editPrivacy = false, $toggleTransactionalContent = false, $toggleInstructionalContent = false, $togglePrivacyContent = false;
    public mixed $transactionalContent, $instructionalContent, $privacyContent;

    protected $listeners = ['recipientsAdded' => 'refreshCampaign'];

    public function saveMeta(string $meta)
    {
        $camelCased = Str::camel($meta);
        $this->campaign->setMeta($meta, $this->$camelCased);
        $this->campaign->saveMeta();
        $this->reset(['editImage', 'editFamily', 'editPrivacy', 'toggleTransactionalContent', 'toggleInstructionalContent', 'togglePrivacyContent']);
    }

    public function setEdit(string $property, bool $active)
    {
        $camelCased = Str::camel($property);
        $toggleName = 'toggle' . $camelCased;
        $this->$toggleName = $active;
        $this->$camelCased = $this->campaign->$property;
    }

    public function refreshCampaign()
    {
        $this->campaign->refresh();
    }

    public function render()
    {
        return view('livewire.campaign.show');
    }
}
