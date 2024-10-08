<?php

namespace App\Mail;

use URL;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailVerification extends Mailable
{
    use Queueable, SerializesModels;

    public $url;

    /**
     * Create a new message instance.
     */
    public function __construct($user)
    {
        $generate = URL::temporarySignedRoute('email.verify', now()->addMinute(30), ["email"=>$user->email]);
        $front_end_url_withHashed = env('FRONTEND_URL') . '#';
        $this->url = str_replace(env('APP_URL'), $front_end_url_withHashed, $generate);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Email Verification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.email_verification',
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
