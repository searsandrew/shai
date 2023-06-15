<?php

namespace App\Http\Livewire\Recipient;

use App\Models\Campaign;
use App\Models\Recipient;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public Campaign $campaign;
    public Recipient $recipient;
    public bool $toggleRecipient = false, $toggleEditRecipient = false;
    public array $keys, $meta, $setRules = [];
    public string $claimCode = '';

    protected $rules = [];

    public function activateRecipient(string $ulid)
    {
        $this->recipient = Recipient::find($ulid);
        $this->meta = $this->recipient->getMeta()->toArray();
        $this->keys = array_keys($this->meta);

        foreach($this->keys as $key)
        {
            $this->rules['recipient.' . $key] = 'required';
        }

        $this->claimCode = route('recipient.claim', $this->recipient->id);

        $this->toggleRecipient = true;
    }

    public function render()
    {
        return view('livewire.recipient.index', [
            'recipients' => $this->campaign->recipients()->paginate(25)
        ]);
    }
}
