<?php

namespace App\Http\Livewire\Campaign;

use App\Models\Campaign;
use App\Models\Donor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;

    public Campaign $campaign;
    // public LengthAwarePaginator $donors;
    public bool $editImage = false, $editFamily = false, $editPrivacy = false, $toggleSelectionContent = false, $toggleReminderContent = false, $toggleCompletionContent = false;
    public bool $toggleImage = false;
    public int $recipientCount = 0, $donorCount = 0;
    public mixed $selectionContent, $reminderContent, $completionContent;

    protected $listeners = ['recipientsAdded' => 'refreshCampaign'];

    public function mount()
    {}

    public function saveMeta(string $meta)
    {
        $camelCased = Str::camel($meta);
        $this->campaign->setMeta($meta, $this->$camelCased);
        $this->campaign->saveMeta();
        $this->reset(['editImage', 'editFamily', 'editPrivacy', 'toggleSelectionContent', 'toggleReminderContent', 'toggleCompletionContent']);
    }

    public function setEdit(string $property, bool $active)
    {
        $camelCased = Str::camel($property);
        $toggleName = 'toggle' . $camelCased;
        $this->$toggleName = $active;
        $this->$camelCased = $this->campaign->$property;
    }

    public function toggle(string $action, bool $true = false)
    {
        $camelCased = Str::camel('toggle-' . $action);
        $this->campaign->setMeta('toggle_' . $action, $this->$camelCased);
        $this->campaign->saveMeta();
        $this->$camelCased = true;
    }

    public function loadData()
    {
        $this->recipientCount = $this->campaign->recipients->count();
        $this->donorCount = $this->campaign->recipients()->has('donors')->count();
    }

    public function refreshCampaign()
    {
        $this->campaign->refresh();
    }

    public function render()
    {
        return view('livewire.campaign.show', [
            'donors' => Donor::whereHas('recipients', function(Builder $query) {
                $query->where('campaign_id', $this->campaign->id);
            })->paginate(10)
        ]);
    }
}
