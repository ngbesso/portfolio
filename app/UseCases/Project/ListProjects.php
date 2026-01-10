<?php

namespace App\UseCases\Project;

use App\Core\Repositories\ProjectRepositoryInterface;
use App\Core\ValueObjects\ProjectStatus;

/**
 * Use Case : Lister les projets
 *
 * Supporte différents modes de listage :
 * - Tous les projets (admin)
 * - Projets publiés uniquement (frontend)
 * - Projets par statut
 * - Projets featured
 *
 * @package App\UseCases\Project
 */
class ListProjects
{
    public function __construct(
        private readonly ProjectRepositoryInterface $projectRepository
    ) {}

    /**
     * Lister tous les projets (pour l'admin)
     *
     * @return array
     */
    public function all(): array
    {
        return $this->projectRepository->findAll();
    }

    /**
     * Lister uniquement les projets publiés (pour le frontend)
     * Triés par ordre d'affichage
     *
     * @return array
     */
    public function published(): array
    {
        return $this->projectRepository->findPublished();
    }

    /**
     * Lister les projets par statut
     *
     * @param ProjectStatus $status
     * @return array
     */
    public function byStatus(ProjectStatus $status): array
    {
        return $this->projectRepository->findByStatus($status);
    }

    /**
     * Lister les projets mis en avant (featured)
     * Pour la page d'accueil
     *
     * @param int $limit Nombre maximum de projets
     * @return array
     */
    public function featured(int $limit = 3): array
    {
        return $this->projectRepository->findFeatured($limit);
    }
}
