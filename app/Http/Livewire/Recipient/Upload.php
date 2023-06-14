<?php

namespace App\Http\Livewire\Recipient;

use App\Models\Campaign;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

use Auth;

class Upload extends Component
{
    use WithFileUploads;

    public Campaign $campaign;
    public $file;

    public function save()
    {
        $this->validate([
            'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048',
        ]);

        $fileName = Carbon::now()->toDateString() . '-' . Str::slug($this->file->getClientOriginalName(), '-');
        $this->file->storeAs('recipients', $fileName . '.' . $this->file->getClientOriginalExtension());

        $this->campaign->files()->create([
            'name' => $fileName,
            'file_path' => $fileName . '.' . $this->file->getClientOriginalExtension()
        ]);

        $this->reset('file');
        $this->emitUp('recipientsAdded');
        session()->flash('livewire-toast', 'File Uploaded Sucessfully');
    }

    public function render()
    {
        return view('livewire.recipient.upload');
    }
}
