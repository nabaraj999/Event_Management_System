<?php

namespace App\Mail;

use App\Models\SupportTicket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketReplyMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $ticket;
    public $replyMessage;

    /**
     * Create a new message instance.
     */
    public function __construct(SupportTicket $ticket, string $replyMessage)
    {
        $this->ticket = $ticket->load(['organizer', 'replies.attachments']);
        $this->replyMessage = $replyMessage;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Re: #' . $this->ticket->ticket_id . ' - ' . $this->ticket->subject,
            replyTo: config('mail.from.address'), // or a dedicated support email
            tags: ['support-ticket', 'reply'],
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
            markdown: 'emails.support.reply',
            with: [
                'ticket'       => $this->ticket,
                'organizer'    => $this->ticket->organizer,
                'replyMessage' => $this->replyMessage,
                'url'          => route('org.support.show', $this->ticket),
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
