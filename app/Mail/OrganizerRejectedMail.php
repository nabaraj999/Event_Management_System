<?php

namespace App\Mail;

use App\Models\OrganizerApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrganizerRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $application;

    public function __construct(OrganizerApplication $application)
    {
        $this->application = $application;
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Your Organizer Application Was Rejected');
    }

    public function content(): Content
    {
        return new Content(markdown: 'emails.organizer.rejected');
    }
}

