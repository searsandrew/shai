<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Family;
use App\Models\Wishlist;
use App\Mail\DoneeSelected;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

use Auth;

class FamilyCard extends Component
{
    public array $wishlists;
    public bool $image;
    public $wishlist;
    public Family $family;
    public bool $deselectingFamily = false;
    public bool $infoModal = false;

    // public function selectFamily()
    // {
    //     foreach($this->wishlists as $wishlist)
    //     {
    //         $current = Wishlist::find($wishlist['id']);
    //         $current->addSelection();
    //     }
    // }

    public function deselectFamily()
    {
        foreach($this->wishlists as $wishlist)
        {
            $current = Wishlist::find($wishlist['id']);
            $current->removeSelection();
        }

        $this->deselectingFamily = false;
    }

    public function mount(bool $image, array $wishlist)
    {
        $pluck = $wishlist[0];
        $this->image = $image;
        $this->wishlists = $wishlist;
        $this->wishlist = $pluck;
        $this->family = Family::find($wishlist[0]->family);
    }

    public function selectFamily()
    {
        
        foreach($this->wishlists as $wishlist)
        {
            $wishlistObj = Wishlist::find($wishlist['id']);
            $wishlistObj->status = 'selected';
            $wishlistObj->user_id = Auth::user()->id;
            $wishlistObj->emailed_at = Carbon::now();
            $wishlistObj->save();
            $campaign = $wishlistObj->campaign;
        }

        Mail::to(Auth::user())->send(new DoneeSelected($campaign));

        return redirect()->to('/dashboard');
    }

    public function email()
    {
        // dd(Wishlist::find($this->wishlists[0]['id']));
        $wishlist = Wishlist::find($this->wishlists[0]['id']);
        Mail::to($wishlist->user)->send(new DoneeSelected($wishlist->campaign, $wishlist->user));
        $this->emit('sent');
    }

    public function render()
    {
        return view('livewire.family-card');
    }
}
