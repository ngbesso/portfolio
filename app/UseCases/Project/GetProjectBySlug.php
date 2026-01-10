<?php

namespace App\UseCases\Project;

use App\Core\Entities\Project;
use App\Core\Repositories\ProjectRepositoryInterface;
use App\Core\Exceptions\ProjectNotFoundException;

/**
 * Use Case : Récupérer un projet par son slug
 * Utilisé pour les pages publiques avec URLs SEO-friendly
 *
 * @package App\UseCases\Project
 */
class GetProjectBySlug
{
    public function __construct(
        private readonly ProjectRepositoryInterface $projectRepository
    ) {}

    /**
     * Exécuter la récupération
     *
     * @param string $slug
     * @return Project
     * @throws ProjectNotFoundException
     */
    public function execute(string $slug): Project
    {
        $project = $this->projectRepository->findBySlug($slug);

        if ($project === null) {
            throw ProjectNotFoundException::withSlug($slug);
        }

        // Règle métier : Seuls les projets publiés sont accessibles par slug
        // Les brouillons et archivés ne doivent pas être visibles
        if (!$project->isPublished()) {
            throw ProjectNotFoundException::withSlug($slug);
        }

        return $project;
    }
}
