<?php

namespace App\Mail;

use App\Models\Campaign;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendDonorEmail extends Mailable
{
    use Queueable, SerializesModels;

    public Campaign $campaign;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public Collection $collection,
        public string $type,
    ){
        $this->campaign = $collection->first()->campaign;
    }

    /**
     * Get the message envelope.
     */
    public function envelope() : Envelope
    {
        return new Envelope(
            from: new Address($this->campaign->email, $this->campaign->name),
            subject: $this->campaign->name . ' Donation ' . ucwords($this->type),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content() : Content
    {
        return new Content(
            view: 'emails.donor.' . $this->type,
            with: [
                'campaign' => $this->campaign,
                'recipients' => $this->collection,
            ],
        );
    }
}
