<?php

namespace App\UseCases\Project;

use App\Core\Repositories\ProjectRepositoryInterface;
use App\Core\Exceptions\ProjectNotFoundException;

/**
 * Use Case : Supprimer un projet
 *
 * @package App\UseCases\Project
 */
class DeleteProject
{
    public function __construct(
        private readonly ProjectRepositoryInterface $projectRepository
    ) {}

    /**
     * Exécuter la suppression
     *
     * @param int $projectId
     * @return bool
     * @throws ProjectNotFoundException
     */
    public function execute(int $projectId): bool
    {
        // 1. Vérifier que le projet existe
        $project = $this->projectRepository->findById($projectId);

        if ($project === null) {
            throw ProjectNotFoundException::withId($projectId);
        }

        // NOTE : Le controller ou un service devrait supprimer l'image
        // associée avant d'appeler ce use case
        // Ex: if ($project->getImage()) { Storage::delete($project->getImage()); }

        // 2. Supprimer le projet
        $deleted = $this->projectRepository->delete($projectId);

        return $deleted;
    }
}

