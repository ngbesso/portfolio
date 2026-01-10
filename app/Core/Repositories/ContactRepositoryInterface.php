<?php

namespace App\Core\Repositories;

use App\Core\Entities\Contact;

/**
 * Interface ContactRepository
 *
 * @package App\Core\Repositories
 */
interface ContactRepositoryInterface
{
    /**
     * Récupérer tous les messages de contact
     *
     * @return Contact[]
     */
    public function findAll(): array;

    /**
     * Récupérer un message par ID
     *
     * @param int $id
     * @return Contact|null
     */
    public function findById(int $id): ?Contact;

    /**
     * Récupérer les messages non lus
     *
     * @return Contact[]
     */
    public function findUnread(): array;

    /**
     * Récupérer les messages récents (dernières 24h)
     *
     * @return Contact[]
     */
    public function findRecent(): array;

    /**
     * Créer un nouveau message de contact
     *
     * @param Contact $contact
     * @return Contact
     */
    public function create(Contact $contact): Contact;

    /**
     * Mettre à jour un message (pour marquer comme lu)
     *
     * @param Contact $contact
     * @return Contact
     */
    public function update(Contact $contact): Contact;

    /**
     * Supprimer un message
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Compter les messages non lus
     *
     * @return int
     */
    public function countUnread(): int;
}


