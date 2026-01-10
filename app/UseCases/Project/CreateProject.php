<?php

namespace App\UseCases\Project;

use App\Core\Entities\Project;
use App\Core\Repositories\ProjectRepositoryInterface;
use App\Core\ValueObjects\Url;
use App\Core\Exceptions\InvalidProjectDataException;

/**
 * Use Case : Créer un nouveau projet
 *
 * Responsabilités :
 * - Orchestrer la création d'un projet
 * - Valider les données via l'entité
 * - Gérer l'upload d'image (délégué au service)
 * - Persister via le repository
 *
 * Principe :
 * Un Use Case représente UNE action utilisateur ou système.
 * Il coordonne les entités et services pour accomplir cette action.
 *
 * Flow :
 * 1. Recevoir les données
 * 2. Créer l'entité Project (validation automatique)
 * 3. Traiter l'image si présente
 * 4. Sauvegarder via le repository
 * 5. Retourner le projet créé
 *
 * @package App\UseCases\Project
 */
class CreateProject
{
    /**
     * Injection de dépendances via le constructeur
     *
     * @param ProjectRepositoryInterface $projectRepository
     */
    public function __construct(
        private readonly ProjectRepositoryInterface $projectRepository
    ) {}

    /**
     * Exécuter le use case
     *
     * @param array $data Données du projet
     * @return Project Le projet créé
     * @throws InvalidProjectDataException Si les données sont invalides
     */
    public function execute(array $data): Project
    {
        // 1. Valider que le slug n'existe pas déjà
        $slug = $this->generateSlug($data['title']);
        if ($this->projectRepository->slugExists($slug)) {
            throw InvalidProjectDataException::invalidTitle(
                'A project with this title already exists'
            );
        }

        // 2. Créer l'entité Project (validation automatique dans l'entité)
        $project = Project::create(
            title: $data['title'],
            description: $data['description'],
            technologies: $data['technologies'] ?? []
        );

        // 3. Ajouter les URLs si présentes
        if (!empty($data['url'])) {
            $project->setUrl(Url::tryCreate($data['url']));
        }

        if (!empty($data['github_url'])) {
            $project->setGithubUrl(Url::tryCreate($data['github_url']));
        }

        // 4. Définir l'ordre si spécifié
        if (isset($data['order'])) {
            $project->reorder((int) $data['order']);
        }

        // 5. Définir si featured
        if (!empty($data['featured'])) {
            $project->feature();
        }

        // NOTE : Le traitement de l'image sera fait par le controller
        // qui utilisera un service dédié (ImageStorageService)
        // Le chemin de l'image sera ensuite défini avec $project->setImage()

        // 6. Persister le projet
        $createdProject = $this->projectRepository->create($project);

        return $createdProject;
    }

    /**
     * Générer un slug unique depuis un titre
     *
     * @param string $title
     * @return string
     */
    private function generateSlug(string $title): string
    {
        $slug = mb_strtolower($title);
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
        return trim($slug, '-');
    }
}
