<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $message;
    public $attachment;

    public function __construct($subject, $message, $attachment = null)
    {
        $this->subject = $subject;
        $this->message = $message;
        $this->attachment = $attachment;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject
        );
    }


    public function attachments(): array
    {
        $attachments = [];

        if ($this->attachment) {
            $attachments[] = Attachment::fromPath($this->attachment)
                ->as('image.png')
                ->withMime('image/png');
        }

        return $attachments;
    }

    public function build()
    {
        return $this->subject($this->subject)->view('dashboard.emails.send', ['emailMessage' => $this->message]);
    }
}
