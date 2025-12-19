<?php

namespace App\Mail;

use App\Models\OrganizerApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
class OrganizerApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $organizer;
    public $plainPassword;

    public function __construct(OrganizerApplication $organizer, string $plainPassword)
    {
        $this->organizer = $organizer;
        $this->plainPassword = $plainPassword;
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Congratulations! Your Organizer Account is Approved');
    }

    public function content(): Content
    {
        return new Content(markdown: 'emails.organizer.approved');
    }
}
