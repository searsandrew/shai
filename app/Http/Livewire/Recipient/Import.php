<?php

namespace App\Http\Livewire\Recipient;

use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Spatie\SimpleExcel\SimpleExcelReader;

class Import extends Component
{
    public File $file;
    public array $header = [];

    protected $rules = [
        'header.*' => 'required'
    ];

    public function mount()
    {
        // $getFile = SimpleExcelReader::create(Storage::path('recipients/' . $this->file->file_path));
        // $this->header = array_keys($getFile->getHeaders());
    }

    public function assignHeaders()
    {
        $this->validate();

        foreach ($this->header as $header) {
            dd($header);
        }

        dd($this->header);

        // $organization = $this->organization->save();
        // if($organization)
        // {
        //     $this->address->addressable_id = $this->organization->id;
        //     $this->address->addressable_type = 'App\Models\Organization';
        //     $address = $this->address->save();
        // }

        // if($organization && $address)
        // {
        //     Auth::user()->organizations()->attach($this->organization->id);
        //     Auth::user()->organization = $this->organization->id;
        //     Auth::user()->save();
        //     return redirect(route('dashboard'));
        // }

        // $this->emit('error');
    }

    public function render()
    {
        return view('livewire.recipient.import', [
            'csv' => SimpleExcelReader::create(Storage::path('recipients/' . $this->file->file_path)),
        ]);
    }
}