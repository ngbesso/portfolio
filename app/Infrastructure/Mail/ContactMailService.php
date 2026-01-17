<?php

namespace App\Infrastructure\Mail;

use App\Core\Entities\Contact;
use App\Mail\AdminContactNotificationMail;
use App\Mail\ContactConfirmationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;

/**
 * Service : Envoi d'emails pour les messages de contact
 *
 * Responsabilités :
 * - Envoyer une notification à l'admin lors d'un nouveau message
 * - Envoyer un email de confirmation à l'expéditeur
 *
 * @package App\Infrastructure\Mail
 */
class ContactMailService
{
    /**
     * Email de l'administrateur (destinataire des notifications)
     */
    private string $adminEmail;

    /**
     * Nom du site (pour l'expéditeur)
     */
    private string $siteName;

    public function __construct()
    {
        // Récupérer depuis la config
        $this->adminEmail = config('mail.admin_email', 'admin@example.com');
        $this->siteName = config('app.name', 'Portfolio');
    }

    /**
     * Envoyer une notification à l'admin
     *
     * Email envoyé à l'admin quand un nouveau message est reçu
     *
     * @param Contact $contact
     * @return bool True si envoyé, false sinon
     */
    public function sendAdminNotification(Contact $contact): bool
    {
        try {

            Mail::send(new AdminContactNotificationMail($contact, $this->siteName, $this->adminEmail));

            return true;
        } catch (\Exception $e) {
            // Logger l'erreur
            logger()->error('Failed to send admin notification email', [
                'contact_id' => $contact->getId(),
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Envoyer un email de confirmation à l'expéditeur
     *
     * Email automatique pour remercier et confirmer la réception
     *
     * @param Contact $contact
     * @return bool True si envoyé, false sinon
     */
    public function sendConfirmationToSender(Contact $contact): bool
    {
        try {

            Mail::send(new ContactConfirmationMail($contact, $this->siteName));

            return true;
        } catch (\Exception $e) {
            logger()->error('Failed to send confirmation email', [
                'contact_id' => $contact->getId(),
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Construire le HTML de l'email admin
     *
     * @param Contact $contact
     * @return string
     */
    private function buildAdminEmailHtml(Contact $contact): string
    {
        $name = htmlspecialchars($contact->getName());
        $email = htmlspecialchars($contact->getEmail()->getValue());
        $subject = htmlspecialchars($contact->getSubject());
        $message = nl2br(htmlspecialchars($contact->getMessage()));
        $date = $contact->getCreatedAt()->format('d/m/Y à H:i');

        return <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #4F46E5; color: white; padding: 20px; text-align: center; }
        .content { background: #f9f9f9; padding: 20px; margin-top: 20px; }
        .field { margin-bottom: 15px; }
        .label { font-weight: bold; color: #4F46E5; }
        .footer { text-align: center; margin-top: 30px; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📧 Nouveau Message de Contact</h1>
        </div>

        <div class="content">
            <div class="field">
                <span class="label">De :</span> {$name}
            </div>

            <div class="field">
                <span class="label">Email :</span>
                <a href="mailto:{$email}">{$email}</a>
            </div>

            <div class="field">
                <span class="label">Sujet :</span> {$subject}
            </div>

            <div class="field">
                <span class="label">Date :</span> {$date}
            </div>

            <div class="field">
                <span class="label">Message :</span>
                <div style="background: white; padding: 15px; margin-top: 10px; border-left: 4px solid #4F46E5;">
                    {$message}
                </div>
            </div>
        </div>

        <div class="footer">
            <p>Cet email a été envoyé automatiquement depuis votre portfolio.</p>
        </div>
    </div>
</body>
</html>
HTML;
    }

    /**
     * Construire le HTML de l'email de confirmation
     *
     * @param Contact $contact
     * @return string
     */
    private function buildConfirmationEmailHtml(Contact $contact): string
    {
        $name = htmlspecialchars($contact->getName());

        return <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #10B981; color: white; padding: 20px; text-align: center; }
        .content { background: #f9f9f9; padding: 20px; margin-top: 20px; }
        .button { display: inline-block; background: #10B981; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin-top: 20px; }
        .footer { text-align: center; margin-top: 30px; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✅ Message bien reçu !</h1>
        </div>

        <div class="content">
            <p>Bonjour {$name},</p>

            <p>Merci d'avoir pris le temps de me contacter via mon portfolio.</p>

            <p>J'ai bien reçu votre message et je m'engage à vous répondre dans les plus brefs délais, généralement sous 24-48 heures.</p>

            <p>Si votre demande est urgente, n'hésitez pas à me recontacter directement par email.</p>

            <p style="margin-top: 30px;">Cordialement,<br>
            <strong>{$this->siteName}</strong></p>
        </div>

        <div class="footer">
            <p>Cet email est une confirmation automatique. Merci de ne pas y répondre.</p>
        </div>
    </div>
</body>
</html>
HTML;
    }
}
