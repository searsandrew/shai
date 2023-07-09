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
    // public LengthAwarePaginator $donors;
    public bool $editImage = false, $editFamily = false, $editPrivacy = false, $toggleSelectionContent = false, $toggleReminderContent = false, $toggleCompletionContent = false, $toggleUploadAttachment = false;
    public bool $toggleImage = false, $toggleGroup = false, $togglePrivacy = false;
    public int $recipientCount = 0, $donorCount = 0;
    public mixed $selectionContent, $reminderContent, $completionContent;
    public $attachment, $activeAttachment;

    protected $listeners = ['recipientsAdded' => 'refreshCampaign'];

    public function mount()
    {
        $activeAttachment = DB::table('files')->where([
            'campaign_id' => $this->campaign->id,
            'type' => 'attachment',
        ])->first();

        $this->toggleImage = $this->campaign->toggle_image;
        $this->toggleGroup = $this->campaign->toggle_group;
        $this->togglePrivacy = $this->campaign->toggle_privacy;

        // dd($activeAttachment->name);
    }

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
        $this->$camelCased = $true;
        $this->campaign->setMeta(Str::snake($camelCased), $true);
        $this->campaign->save();
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

    public function uploadAttachment()
    {
        $this->validate([
            'attachment' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048',
        ]);
        
        $attachmentName = Carbon::now()->toDateString() . '-' . Str::slug($this->attachment->getClientOriginalName(), '-');
        $this->attachment->storeAs('attachments', $attachmentName . '.' . $this->attachment->getClientOriginalExtension());
        
        $this->campaign->files()->create([
            'name' => $attachmentName,
            'type' => 'attachment',
            'file_path' => $attachmentName . '.' . $this->attachment->getClientOriginalExtension()
        ]);
        
        $this->reset('attachment');
        session()->flash('livewire-toast', 'Attachment Uploaded Sucessfully');
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
