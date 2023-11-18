<?php

namespace App\Http\Livewire\Donor;

use App\Models\Campaign;
use App\Models\Donor;
use App\Models\Recipient;
use Livewire\Component;

class Selection extends Component
{
    public Campaign $campaign;
    public Donor $donor;
    public bool $modal;
    public int $count;

    public function remove(string $id)
    {
        $recipient = Recipient::find($id);

        if($this->campaign->toggle_group)
        {
            $group = $recipient->group()->first();
            foreach($group->recipients as $recipient)
            {
                $recipient->donors()->detach($this->donor);
            }
            $group->update(['held_at', '']);

            dd('done');
        } else {
            dd('not grouped');

        }
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.donor.selection', [
            'selections' => $this->donor->recipients()->get(),
        ]);
    }
}
