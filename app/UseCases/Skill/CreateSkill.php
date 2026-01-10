<?php

namespace App\UseCases\Skill;

use App\Core\Entities\Skill;
use App\Core\Repositories\SkillRepositoryInterface;
use App\Core\ValueObjects\SkillLevel;

/**
 * Use Case : Créer une nouvelle compétence
 *
 * @package App\UseCases\Skill
 */
class CreateSkill
{
    public function __construct(
        private readonly SkillRepositoryInterface $skillRepository
    ) {}

    /**
     * Exécuter la création
     *
     * @param array $data
     * @return Skill
     */
    public function execute(array $data): Skill
    {
        // 1. Créer l'entité (validation automatique)
        $skill = Skill::create(
            name: $data['name'],
            category: $data['category'],
            level: SkillLevel::from($data['level'])
        );

        // 2. Ajouter l'icône si présente
        if (!empty($data['icon'])) {
            $skill->setIcon($data['icon']);
        }

        // 3. Définir l'ordre si spécifié
        if (isset($data['order'])) {
            $skill->reorder((int) $data['order']);
        }

        // 4. Persister
        return $this->skillRepository->create($skill);
    }
}
