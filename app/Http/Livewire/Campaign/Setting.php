<?php

namespace App\Http\Livewire\Campaign;

use App\Models\Campaign;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\Component;

class Setting extends Component
{
    public Campaign $campaign;
    public bool $modal, $toggleImage = false, $toggleGroup = false, $togglePrivacy = false, $toggleSelectionContent = false, $toggleReminderContent = false, $toggleCompletionContent = false, $toggleUploadAttachment = false;
    public $activeAttachment;

    public function mount() : void
    {
        $activeAttachment = DB::table('files')->where([
            'campaign_id' => $this->campaign->id,
            'type' => 'attachment',
        ])->first();

        $this->toggleImage = $this->campaign->toggle_image;
        $this->toggleGroup = $this->campaign->toggle_group;
        $this->togglePrivacy = $this->campaign->toggle_privacy;
    }

    public function toggle(string $action, bool $true = false) : void
    {
        $camelCased = Str::camel('toggle-' . $action);
        $this->$camelCased = $true;
        $this->campaign->setMeta(Str::snake($camelCased), $true);
        $this->campaign->save();
    }

    public function saveMeta(string $meta)
    {
        $camelCased = Str::camel($meta);
        $this->campaign->setMeta($meta, $this->$camelCased);
        $this->campaign->saveMeta();
        $this->reset(['editImage', 'editFamily', 'editPrivacy', 'toggleSelectionContent', 'toggleReminderContent', 'toggleCompletionContent']);
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

    public function render() : View
    {
        return view('livewire.campaign.setting');
    }
}
