<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class TicketConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $qrCodePng;  // This is binary string data

    public function __construct($booking, $qrCodePng)
    {
        $this->booking = $booking;
        $this->qrCodePng = $qrCodePng;  // Already cast to string in controller
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Ticket - ' . $this->booking->event->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.ticket-confirmation',
        );
    }

   public function attachments(): array
{
    return [
        Attachment::fromData(fn () => $this->qrCodePng, 'Ticket-QR-Code.png')
            ->withMime('image/png'),
    ];
}
}
