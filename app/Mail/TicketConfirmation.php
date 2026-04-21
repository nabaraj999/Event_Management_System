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
    protected $qrCodeSvg;
    protected $pdfContent;

    public function __construct($booking, string $qrCodeSvg, string $pdfContent)
    {
        $this->booking = $booking;
        $this->qrCodeSvg = $qrCodeSvg;
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
                'qrCodeBase64' => base64_encode($this->qrCodeSvg),
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
                fn () => $this->qrCodeSvg,
                'EventHUB-QR-' . $this->booking->ticket_token . '.svg'
            )->withMime('image/svg+xml'),
        ];
    }
}
