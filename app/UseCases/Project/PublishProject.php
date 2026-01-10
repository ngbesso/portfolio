<?php

namespace App\UseCases\Project;

use App\Core\Entities\Project;
use App\Core\Repositories\ProjectRepositoryInterface;
use App\Core\Exceptions\ProjectNotFoundException;
use App\Core\Exceptions\InvalidProjectDataException;

/**
 * Use Case : Publier un projet
 *
 * Transition d'état : draft → published
 *
 * @package App\UseCases\Project
 */
class PublishProject
{
    public function __construct(
        private readonly ProjectRepositoryInterface $projectRepository
    ) {}

    /**
     * Publier un projet
     *
     * @param int $projectId
     * @return Project
     * @throws ProjectNotFoundException
     * @throws InvalidProjectDataException Si le projet ne peut pas être publié
     */
    public function execute(int $projectId): Project
    {
        // 1. Récupérer le projet
        $project = $this->projectRepository->findById($projectId);

        if ($project === null) {
            throw ProjectNotFoundException::withId($projectId);
        }

        // 2. Publier (la validation métier est dans l'entité)
        // Si le projet n'a pas d'image, une exception sera levée
        $project->publish();

        // 3. Persister le changement de statut
        $publishedProject = $this->projectRepository->update($project);

        return $publishedProject;
    }
}
