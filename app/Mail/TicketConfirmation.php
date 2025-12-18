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
    protected $qrCodePng;
    protected $pdfContent;

    public function __construct($booking, string $qrCodePng, string $pdfContent)
    {
        $this->booking = $booking;
        $this->qrCodePng = $qrCodePng;
        $this->pdfContent = $pdfContent;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🎫 Ticket Confirmed – ' . $this->booking->event->title
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.ticket-confirmation',
            with: [
                'booking' => $this->booking,
                // Keep small for email clients
                'qrCodeBase64' => base64_encode($this->qrCodePng),
            ]
        );
    }

    public function attachments(): array
    {
        return [
            Attachment::fromData(
                fn () => $this->pdfContent,
                'EventHUB-Ticket-' . $this->booking->ticket_token . '.pdf'
            )->withMime('application/pdf'),

            Attachment::fromData(
                fn () => $this->qrCodePng,
                'EventHUB-QR-' . $this->booking->ticket_token . '.png'
            )->withMime('image/png'),
        ];
    }
}
