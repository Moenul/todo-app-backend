<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\URL;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPasswordLink extends Mailable
{
    use Queueable, SerializesModels;
    public $url;
    /**
     * Create a new message instance.
     */
    public function __construct($email)
    {
        $generate = URL::temporarySignedRoute('password.reset', now()->addMinute(30), ["email"=>$email]);
        $front_end_url_withHashed = env('FRONTEND_URL') . '#';
        $this->url = str_replace(env('APP_URL'), $front_end_url_withHashed, $generate);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reset Password Link',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.reset_password_link',
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
