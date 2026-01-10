<?php

namespace App\UseCases\Contact;

use App\Core\Entities\Contact;
use App\Core\Repositories\ContactRepositoryInterface;
use App\Core\Exceptions\ContactNotFoundException;

/**
 * Use Case : Marquer un message comme lu
 *
 * @package App\UseCases\Contact
 */
class MarkMessageAsRead
{
    public function __construct(
        private readonly ContactRepositoryInterface $contactRepository
    ) {}

    /**
     * Marquer comme lu
     *
     * @param int $contactId
     * @return Contact
     * @throws ContactNotFoundException
     */
    public function execute(int $contactId): Contact
    {
        $contact = $this->contactRepository->findById($contactId);

        if ($contact === null) {
            throw ContactNotFoundException::withId($contactId);
        }

        $contact->markAsRead();

        return $this->contactRepository->update($contact);
    }
}
