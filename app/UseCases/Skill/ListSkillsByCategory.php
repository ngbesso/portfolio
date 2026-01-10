<?php

namespace App\UseCases\Skill;

use App\Core\Repositories\SkillRepositoryInterface;

/**
 * Use Case : Lister les compétences par catégorie
 *
 * Retourne un tableau groupé par catégorie pour l'affichage
 *
 * @package App\UseCases\Skill
 */
class ListSkillsByCategory
{
    public function __construct(
        private readonly SkillRepositoryInterface $skillRepository
    ) {}

    /**
     * Exécuter le listage groupé
     *
     * @return array Format: ['Frontend' => [Skill, ...], 'Backend' => [...]]
     */
    public function execute(): array
    {
        $allSkills = $this->skillRepository->findAll();

        // Grouper par catégorie
        $grouped = [];
        foreach ($allSkills as $skill) {
            $category = $skill->getCategory();
            if (!isset($grouped[$category])) {
                $grouped[$category] = [];
            }
            $grouped[$category][] = $skill;
        }

        // Trier chaque catégorie par ordre
        foreach ($grouped as $category => $skills) {
            usort($skills, fn($a, $b) => $a->getOrder() <=> $b->getOrder());
            $grouped[$category] = $skills;
        }

        return $grouped;
    }
}
