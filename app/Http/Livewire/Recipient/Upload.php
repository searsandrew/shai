<?php

namespace App\Http\Livewire\Recipient;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

use Auth;

class Upload extends Component
{
    use WithFileUploads;

    public $file;

    public function save()
    {
        $this->validate([
            'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048',
        ]);

        $fileName = Carbon::now()->toDateString() . '-' . Str::slug($this->file->getClientOriginalName(), '-');
        $this->file->user_id = Auth::user()->id;
        $this->file->name = $fileName;
        $this->file->storeAs('recipients', $fileName);
    }

    public function render()
    {
        return view('livewire.recipient.upload');
    }
}
