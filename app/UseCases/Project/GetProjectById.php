<?php

namespace App\UseCases\Project;

use App\Core\Entities\Project;
use App\Core\Repositories\ProjectRepositoryInterface;
use App\Core\Exceptions\ProjectNotFoundException;

/**
 * Use Case : Récupérer un projet par son ID
 *
 * @package App\UseCases\Project
 */
class GetProjectById
{
    public function __construct(
        private readonly ProjectRepositoryInterface $projectRepository
    ) {}

    /**
     * Exécuter la récupération
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

        return $project;
    }
}

