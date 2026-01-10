<?php

namespace App\Infrastructure\Repositories;

use App\Core\Entities\Skill;
use App\Core\Repositories\SkillRepositoryInterface;
use App\Models\SkillModel;

/**
 * Repository Eloquent pour les compétences
 *
 * @package App\Infrastructure\Repositories
 */
class EloquentSkillRepository implements SkillRepositoryInterface
{
    /**
     * Récupérer toutes les compétences
     *
     * @return Skill[]
     */
    public function findAll(): array
    {
        $models = SkillModel::ordered()->get();

        return $models->map(function ($model) {
            return $this->toDomainEntity($model);
        })->toArray();
    }

    /**
     * Récupérer une compétence par ID
     *
     * @param int $id
     * @return Skill|null
     */
    public function findById(int $id): ?Skill
    {
        $model = SkillModel::find($id);

        return $model ? $this->toDomainEntity($model) : null;
    }

    /**
     * Récupérer les compétences par catégorie
     *
     * @param string $category
     * @return Skill[]
     */
    public function findByCategory(string $category): array
    {
        $models = SkillModel::byCategory($category)
            ->ordered()
            ->get();

        return $models->map(function ($model) {
            return $this->toDomainEntity($model);
        })->toArray();
    }

    /**
     * Récupérer toutes les catégories distinctes
     *
     * @return string[]
     */
    public function getAllCategories(): array
    {
        return SkillModel::distinct()
            ->pluck('category')
            ->toArray();
    }

    /**
     * Créer une nouvelle compétence
     *
     * @param Skill $skill
     * @return Skill
     */
    public function create(Skill $skill): Skill
    {
        $data = $skill->toArray();
        unset($data['id']);

        $model = SkillModel::create($data);

        return $this->toDomainEntity($model);
    }

    /**
     * Mettre à jour une compétence
     *
     * @param Skill $skill
     * @return Skill
     */
    public function update(Skill $skill): Skill
    {
        $model = SkillModel::findOrFail($skill->getId());

        $data = $skill->toArray();
        unset($data['id']);

        $model->update($data);

        return $this->toDomainEntity($model->fresh());
    }

    /**
     * Supprimer une compétence
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $model = SkillModel::find($id);

        if (!$model) {
            return false;
        }

        return (bool) $model->delete();
    }

    // ========================================================================
    // CONVERSION
    // ========================================================================

    /**
     * Convertir un Model en Entité
     *
     * @param SkillModel $model
     * @return Skill
     */
    private function toDomainEntity(SkillModel $model): Skill
    {
        return Skill::fromArray([
            'id' => $model->id,
            'name' => $model->name,
            'slug' => $model->slug,
            'category' => $model->category,
            'level' => $model->level,
            'icon' => $model->icon,
            'order' => $model->order,
            'created_at' => $model->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $model->updated_at?->format('Y-m-d H:i:s'),
        ]);
    }
}

