<?php

namespace App\UseCases\Contact;

use App\Core\Repositories\ContactRepositoryInterface;

/**
 * Use Case : Lister les messages de contact
 *
 * @package App\UseCases\Contact
 */
class ListContactMessages
{
    public function __construct(
        private readonly ContactRepositoryInterface $contactRepository
    ) {}

    /**
     * Lister tous les messages
     *
     * @return array
     */
    public function all(): array
    {
        return $this->contactRepository->findAll();
    }

    /**
     * Lister uniquement les messages non lus
     *
     * @return array
     */
    public function unread(): array
    {
        return $this->contactRepository->findUnread();
    }

    /**
     * Lister les messages récents (dernières 24h)
     *
     * @return array
     */
    public function recent(): array
    {
        return $this->contactRepository->findRecent();
    }

    /**
     * Compter les messages non lus
     * Pour le badge de notification dans l'admin
     *
     * @return int
     */
    public function countUnread(): int
    {
        return $this->contactRepository->countUnread();
    }
}
