<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Core\Entities\Contact;
class AdminContactNotificationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public readonly Contact $contact,
        public readonly string $siteName,
        public readonly string $adminEmail,
    )
    {

    }

    /**
     * Get the message envelope.
     * Définition de l’enveloppe (headers, sujet, destinataires)
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: config('mail.from.address'),
            to: [$this->adminEmail],
            replyTo:[
                $this->contact->getEmail()->getValue() => $this->contact->getName(),
            ],
            subject:"Nouveau message de contact - {$this->siteName}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.contact.admin-notification',
            with: [
                'contact' => $this->contact,
                'siteName' => $this->siteName,
            ]
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
