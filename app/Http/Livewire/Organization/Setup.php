<?php

namespace App\Http\Livewire\Organization;

use App\Models\Address;
use App\Models\Organization;
use Livewire\Component;

use Auth;

class Setup extends Component
{
    public Address $address;
    public Organization $organization;

    public $rules = [
        'organization.name' => 'required',
        'organization.tax_id' => 'nullable',
        'address.street' => 'required',
        'address.unit' => 'nullable',
        'address.city' => 'required',
        'address.state' => 'required',
        'address.zip' => 'required',
    ];

    public function mount()
    {
        $this->address = new Address();
        $this->organization = new Organization();
    }

    public function createOrganization()
    {
        $organization = $this->organization->save();
        if($organization)
        {
            $this->address->addressable_id = $this->organization->id;
            $this->address->addressable_type = 'App\Models\Organization';
            $address = $this->address->save();
        }

        if($organization && $address)
        {
            Auth::user()->organizations()->attach($this->organization->id);
            return redirect(route('dashboard'));
        }

        $this->emit('error');
    }

    public function render()
    {
        return view('livewire.organization.setup');
    }
}