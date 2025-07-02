<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Lang;

class AdminMessageToFreelancer extends Mailable
{
    use Queueable, SerializesModels;

    public $messageContent;
    public $locale;
    public $userName;

    public function __construct($messageContent, $user)
    {
        $this->messageContent = $messageContent;
        $this->locale = $user->lang ?? 'ar';
        $this->userName = $user->name;
    }

    public function envelope(): Envelope
    {
        $subject = Lang::get('messages.admin_message_subject', [], $this->locale);

        return new Envelope(
            subject: $subject
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin_message_to_freelancer',
            with: [
                'replyText' => $this->messageContent,
                'locale' => $this->locale,
                'userName' => $this->userName,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
