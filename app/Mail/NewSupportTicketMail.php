<?php

namespace App\Mail;

use App\Models\SupportTicket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewSupportTicketMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;

    /**
     * Create a new message instance.
     */
    public function __construct(SupportTicket $ticket)
    {
        $this->ticket = $ticket->load(['organizer', 'replies.attachments']);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[New Support Ticket] #' . $this->ticket->ticket_id . ' - ' . $this->ticket->subject,
            from: config('mail.from.address'),
            tags: ['support-ticket', 'new'],
            metadata: [
                'ticket_id' => $this->ticket->ticket_id,
            ],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.support.new-ticket',
            with: [
                'ticket' => $this->ticket,
                'organizer' => $this->ticket->organizer,
                'priority' => $this->ticket->priority,
                'url' => route('admin.dashboard', $this->ticket->id), // Adjust to your admin route
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
