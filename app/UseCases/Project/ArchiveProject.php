<?php

namespace App\UseCases\Project;

use App\Core\Entities\Project;
use App\Core\Repositories\ProjectRepositoryInterface;
use App\Core\Exceptions\ProjectNotFoundException;

/**
 * Use Case : Archiver un projet
 *
 * Permet de retirer un projet de la vue publique sans le supprimer
 *
 * @package App\UseCases\Project
 */
class ArchiveProject
{
    public function __construct(
        private readonly ProjectRepositoryInterface $projectRepository
    ) {}

    /**
     * Archiver un projet
     *
     * @param int $projectId
     * @return Project
     * @throws ProjectNotFoundException
     */
    public function execute(int $projectId): Project
    {
        $project = $this->projectRepository->findById($projectId);

        if ($project === null) {
            throw ProjectNotFoundException::withId($projectId);
        }

        $project->archive();

        return $this->projectRepository->update($project);
    }
}
