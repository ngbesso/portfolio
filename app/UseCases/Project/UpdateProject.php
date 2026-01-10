<?php

namespace App\UseCases\Project;


use App\Core\Entities\Project;
use App\Core\Repositories\ProjectRepositoryInterface;
use App\Core\ValueObjects\Url;
use App\Core\Exceptions\ProjectNotFoundException;
use App\Core\Exceptions\InvalidProjectDataException;

/**
 * Use Case : Mettre à jour un projet existant
 *
 * @package App\UseCases\Project
 */
class UpdateProject
{
    public function __construct(
        private readonly ProjectRepositoryInterface $projectRepository
    ) {}

    /**
     * Exécuter la mise à jour
     *
     * @param int $projectId
     * @param array $data
     * @return Project
     * @throws ProjectNotFoundException
     * @throws InvalidProjectDataException
     */
    public function execute(int $projectId, array $data): Project
    {
        // 1. Récupérer le projet existant
        $project = $this->projectRepository->findById($projectId);

        if ($project === null) {
            throw ProjectNotFoundException::withId($projectId);
        }

        // 2. Mettre à jour le titre si fourni
        if (isset($data['title']) && $data['title'] !== $project->getTitle()) {
            // Vérifier que le nouveau slug n'existe pas
            $newSlug = $this->generateSlug($data['title']);
            if ($this->projectRepository->slugExists($newSlug, $projectId)) {
                throw InvalidProjectDataException::invalidTitle(
                    'A project with this title already exists'
                );
            }
            $project->updateTitle($data['title']);
        }

        // 3. Mettre à jour la description si fournie
        if (isset($data['description'])) {
            $project->updateDescription($data['description']);
        }

        // 4. Mettre à jour les technologies si fournies
        if (isset($data['technologies'])) {
            $project->updateTechnologies($data['technologies']);
        }

        // 5. Mettre à jour les URLs
        if (isset($data['url'])) {
            $project->setUrl(Url::tryCreate($data['url']));
        }

        if (isset($data['github_url'])) {
            $project->setGithubUrl(Url::tryCreate($data['github_url']));
        }

        // 6. Mettre à jour l'ordre si spécifié
        if (isset($data['order'])) {
            $project->reorder((int) $data['order']);
        }

        // 7. Gérer le statut featured
        if (isset($data['featured'])) {
            $data['featured'] ? $project->feature() : $project->unfeature();
        }

        // 8. Persister les modifications
        $updatedProject = $this->projectRepository->update($project);

        return $updatedProject;
    }

    private function generateSlug(string $title): string
    {
        $slug = mb_strtolower($title);
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
        return trim($slug, '-');
    }
}
