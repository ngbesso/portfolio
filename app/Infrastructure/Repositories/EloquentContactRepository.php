<?php

namespace App\Infrastructure\Repositories;
use App\Core\Entities\Contact;
use App\Core\Repositories\ContactRepositoryInterface;
use App\Models\ContactModel;

/**
 * Repository Eloquent pour les messages de contact
 *
 * @package App\Infrastructure\Repositories
 */
class EloquentContactRepository implements ContactRepositoryInterface
{
    /**
     * Récupérer tous les messages
     *
     * @return Contact[]
     */
    public function findAll(): array
    {
        $models = ContactModel::latest()->get();

        return $models->map(function ($model) {
            return $this->toDomainEntity($model);
        })->toArray();
    }

    /**
     * Récupérer un message par ID
     *
     * @param int $id
     * @return Contact|null
     */
    public function findById(int $id): ?Contact
    {
        $model = ContactModel::find($id);

        return $model ? $this->toDomainEntity($model) : null;
    }

    /**
     * Récupérer les messages non lus
     *
     * @return Contact[]
     */
    public function findUnread(): array
    {
        $models = ContactModel::unread()->latest()->get();

        return $models->map(function ($model) {
            return $this->toDomainEntity($model);
        })->toArray();
    }

    /**
     * Récupérer les messages récents (dernières 24h)
     *
     * @return Contact[]
     */
    public function findRecent(): array
    {
        $models = ContactModel::recent()->latest()->get();

        return $models->map(function ($model) {
            return $this->toDomainEntity($model);
        })->toArray();
    }

    /**
     * Créer un nouveau message
     *
     * @param Contact $contact
     * @return Contact
     */
    public function create(Contact $contact): Contact
    {
        $data = $contact->toArray();
        unset($data['id']);

        $model = ContactModel::create($data);

        return $this->toDomainEntity($model);
    }

    /**
     * Mettre à jour un message
     *
     * @param Contact $contact
     * @return Contact
     */
    public function update(Contact $contact): Contact
    {
        $model = ContactModel::findOrFail($contact->getId());

        $data = $contact->toArray();
        unset($data['id']);

        $model->update($data);

        return $this->toDomainEntity($model->fresh());
    }

    /**
     * Supprimer un message
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $model = ContactModel::find($id);

        if (!$model) {
            return false;
        }

        return (bool) $model->delete();
    }
    /**
     * Compter les messages non lus
     *
     * @return int
     */
    public function countUnread(): int
    {
        return ContactModel::unread()->count();
    }

    // ========================================================================
    // CONVERSION
    // ========================================================================

    /**
     * Convertir un Model en Entité
     *
     * @param ContactModel $model
     * @return Contact
     */
    private function toDomainEntity(ContactModel $model): Contact
    {
        return Contact::fromArray([
            'id' => $model->id,
            'name' => $model->name,
            'email' => $model->email,
            'subject' => $model->subject,
            'message' => $model->message,
            'read_at' => $model->read_at?->format('Y-m-d H:i:s'),
            'created_at' => $model->created_at->format('Y-m-d H:i:s'),
        ]);
    }
}
