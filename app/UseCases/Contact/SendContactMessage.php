<?php

namespace App\UseCases\Contact;

use App\Core\Entities\Contact;
use App\Core\Repositories\ContactRepositoryInterface;
use App\Core\ValueObjects\Email;
use App\Core\Exceptions\InvalidContactDataException;
use App\Core\Exceptions\InvalidEmailException;

/**
 * Use Case : Envoyer un message de contact
 *
 * Flow :
 * 1. Valider les données
 * 2. Créer l'entité Contact
 * 3. Persister le message
 * 4. (Optionnel) Envoyer un email de notification
 *
 * @package App\UseCases\Contact
 */
class SendContactMessage
{
    public function __construct(
        private readonly ContactRepositoryInterface $contactRepository
    ) {}

    /**
     * Exécuter l'envoi du message
     *
     * @param array $data
     * @return Contact
     * @throws InvalidContactDataException
     * @throws InvalidEmailException
     */
    public function execute(array $data): Contact
    {
        // 1. Créer le Value Object Email (validation automatique)
        $email = new Email($data['email']);

        // 2. Créer l'entité Contact (validation automatique)
        $contact = Contact::create(
            name: $data['name'],
            email: $email,
            subject: $data['subject'],
            message: $data['message']
        );

        // 3. Persister le message
        $savedContact = $this->contactRepository->create($contact);

        // NOTE : L'envoi d'email de notification sera géré par :
        // - Un Event Listener (ContactMessageReceived event)
        // - Ou directement dans le Controller
        // Pour respecter la séparation des responsabilités

        return $savedContact;
    }
}
