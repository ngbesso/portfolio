<?php

namespace App\Infrastructure\Repositories;

use App\Core\Entities\Project;
use App\Core\Repositories\ProjectRepositoryInterface;
use App\Core\ValueObjects\ProjectStatus;
use App\Models\ProjectModel;

/**
 * Repository Eloquent pour les projets
 *
 * Implémente l'interface ProjectRepositoryInterface définie dans le Core.
 *
 * Responsabilités :
 * - Convertir les entités Domain en Models Eloquent (et vice-versa)
 * - Effectuer les opérations de persistance
 * - Gérer les requêtes à la base de données
 *
 * Principe : Adapter Pattern
 * Ce repository adapte Eloquent pour l'interface du Domain
 *
 * @package App\Infrastructure\Repositories
 */
class EloquentProjectRepository implements ProjectRepositoryInterface
{
    /**
     * Récupérer tous les projets
     *
     * @return Project[]
     */
    public function findAll(): array
    {
        $models = ProjectModel::ordered()->get();

        return $models->map(function ($model) {
            return $this->toDomainEntity($model);
        })->toArray();
    }

    /**
     * Récupérer un projet par ID
     *
     * @param int $id
     * @return Project|null
     */
    public function findById(int $id): ?Project
    {
        $model = ProjectModel::find($id);

        return $model ? $this->toDomainEntity($model) : null;
    }

    /**
     * Récupérer un projet par slug
     *
     * @param string $slug
     * @return Project|null
     */
    public function findBySlug(string $slug): ?Project
    {
        $model = ProjectModel::where('slug', $slug)->first();

        return $model ? $this->toDomainEntity($model) : null;
    }

    /**
     * Récupérer les projets par statut
     *
     * @param ProjectStatus $status
     * @return Project[]
     */
    public function findByStatus(ProjectStatus $status): array
    {
        $models = ProjectModel::byStatus($status->value)
            ->ordered()
            ->get();

        return $models->map(function ($model) {
            return $this->toDomainEntity($model);
        })->toArray();
    }

    /**
     * Récupérer les projets featured
     *
     * @param int $limit
     * @return Project[]
     */
    public function findFeatured(int $limit = 3): array
    {
        $models = ProjectModel::featured()
            ->ordered()
            ->limit($limit)
            ->get();

        return $models->map(function ($model) {
            return $this->toDomainEntity($model);
        })->toArray();
    }

    /**
     * Récupérer les projets publiés
     *
     * @return Project[]
     */
    public function findPublished(): array
    {
        $models = ProjectModel::published()
            ->ordered()
            ->get();

        return $models->map(function ($model) {
            return $this->toDomainEntity($model);
        })->toArray();
    }

    /**
     * Créer un nouveau projet
     *
     * @param Project $project
     * @return Project Le projet créé avec son ID
     */
    public function create(Project $project): Project
    {
        // Convertir l'entité Domain en tableau pour Eloquent
        $data = $project->toArray();
        unset($data['id']); // Pas d'ID pour une création

        // Créer le model Eloquent
        $model = ProjectModel::create($data);

        // Retourner l'entité avec son nouvel ID
        return $this->toDomainEntity($model);
    }

    /**
     * Mettre à jour un projet existant
     *
     * @param Project $project
     * @return Project
     */
    public function update(Project $project): Project
    {
        $model = ProjectModel::findOrFail($project->getId());

        // Convertir l'entité en tableau
        $data = $project->toArray();
        unset($data['id']); // Ne pas mettre à jour l'ID

        // Mettre à jour le model
        $model->update($data);

        // Retourner l'entité mise à jour
        return $this->toDomainEntity($model->fresh());
    }

    /**
     * Supprimer un projet
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $model = ProjectModel::find($id);

        if (!$model) {
            return false;
        }

        return (bool) $model->delete();
    }

    /**
     * Vérifier si un slug existe
     *
     * @param string $slug
     * @param int|null $excludeId ID à exclure (pour les mises à jour)
     * @return bool
     */
    public function slugExists(string $slug, ?int $excludeId = null): bool
    {
        $query = ProjectModel::where('slug', $slug);

        if ($excludeId !== null) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

    // ========================================================================
    // MÉTHODES PRIVÉES - CONVERSION
    // ========================================================================

    /**
     * Convertir un Model Eloquent en Entité Domain
     *
     * Pattern : Mapper / Hydrator
     *
     * @param ProjectModel $model
     * @return Project
     */
    private function toDomainEntity(ProjectModel $model): Project
    {
        return Project::fromArray([
            'id' => $model->id,
            'title' => $model->title,
            'slug' => $model->slug,
            'description' => $model->description,
            'image' => $model->image,
            'technologies' => $model->technologies ?? [],
            'url' => $model->url,
            'github_url' => $model->github_url,
            'status' => $model->status,
            'featured' => $model->featured,
            'order' => $model->order,
            'created_at' => $model->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $model->updated_at?->format('Y-m-d H:i:s'),
        ]);
    }
}
