<?php

namespace App\Core\Repositories;

use App\Core\Entities\Skill;

/**
 * Interface SkillRepository
 *
 * @package App\Core\Repositories
 */
interface SkillRepositoryInterface
{
    /**
     * @return Skill[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     * @return Skill|null
     */
    public function findById(int $id): ?Skill;

    /**
     * Récupérer les compétences par catégorie
     *
     * @param string $category
     * @return Skill[]
     */
    public function findByCategory(string $category): array;

    /**
     * Récupérer toutes les catégories distinctes
     *
     * @return string[]
     */
    public function getAllCategories(): array;

    /**
     * @param Skill $skill
     * @return Skill
     */
    public function create(Skill $skill): Skill;

    /**
     * @param Skill $skill
     * @return Skill
     */
    public function update(Skill $skill): Skill;

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}
