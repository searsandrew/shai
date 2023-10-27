<?php

namespace App\Http\Livewire\Campaign;

use App\Models\Campaign;
use App\Models\Donor;
use App\Models\File;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination, WithFileUploads;

    public Campaign $campaign;
    public Donor $selectedDonor;
    // public LengthAwarePaginator $donors;
    public bool $editImage = false, $editFamily = false, $editPrivacy = false, $toggleSelectionContent = false, $toggleReminderContent = false, $toggleCompletionContent = false, $toggleUploadAttachment = false;
    public bool $toggleImage = false, $toggleGroup = false, $togglePrivacy = false, $toggleDonorModal = false;
    public int $recipientCount = 0, $donorCount = 0;
    public mixed $selectionContent, $reminderContent, $completionContent;
    public $attachment, $activeAttachment;

    protected $listeners = [
        'recipientsAdded' => 'refreshCampaign',
        'open-modal' => 'selectDonor'
    ];

    public function mount()
    {

    }

    public function selectDonor(string $id)
    {
        $this->toggleDonorModal = true;
        $this->selectedDonor = Donor::find($id);
    }

    public function setEdit(string $property, bool $active)
    {
        $camelCased = Str::camel($property);
        $toggleName = 'toggle' . $camelCased;
        $this->$toggleName = $active;
        $this->$camelCased = $this->campaign->$property;
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
