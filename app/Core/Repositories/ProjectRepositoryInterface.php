<?php

namespace App\Core\Repositories;

use App\Core\Entities\Project;
use App\Core\ValueObjects\ProjectStatus;

/**
 * Interface ProjectRepository
 *
 * Définit le contrat pour la persistance des projets.
 * Cette interface fait partie de la couche Domain.
 *
 * Principe de l'Inversion de Dépendance (SOLID) :
 * - Le Domain définit l'interface
 * - L'Infrastructure implémente l'interface
 * - Le Domain ne dépend PAS de l'Infrastructure
 *
 * Avantages :
 * - Testabilité : On peut créer des mocks/fakes
 * - Flexibilité : On peut changer d'implémentation (Eloquent, API, etc.)
 * - Indépendance du framework
 *
 * @package App\Core\Repositories
 */
interface ProjectRepositoryInterface
{
    /**
     * Récupérer tous les projets
     *
     * @return Project[]
     */
    public function findAll(): array;

    /**
     * Récupérer un projet par son ID
     *
     * @param int $id
     * @return Project|null
     */
    public function findById(int $id): ?Project;

    /**
     * Récupérer un projet par son slug
     * Utilisé pour les URLs SEO-friendly
     *
     * @param string $slug
     * @return Project|null
     */
    public function findBySlug(string $slug): ?Project;

    /**
     * Récupérer les projets par statut
     *
     * @param ProjectStatus $status
     * @return Project[]
     */
    public function findByStatus(ProjectStatus $status): array;

    /**
     * Récupérer les projets mis en avant (featured)
     * Pour la page d'accueil
     *
     * @param int $limit Nombre maximum de projets
     * @return Project[]
     */
    public function findFeatured(int $limit = 3): array;

    /**
     * Récupérer les projets publiés, triés par ordre
     * Pour la page "Projets"
     *
     * @return Project[]
     */
    public function findPublished(): array;

    /**
     * Créer un nouveau projet
     *
     * @param Project $project
     * @return Project Le projet créé avec son ID
     */
    public function create(Project $project): Project;

    /**
     * Mettre à jour un projet existant
     *
     * @param Project $project
     * @return Project Le projet mis à jour
     */
    public function update(Project $project): Project;

    /**
     * Supprimer un projet
     *
     * @param int $id
     * @return bool True si supprimé, false sinon
     */
    public function delete(int $id): bool;

    /**
     * Vérifier si un slug existe déjà
     * Pour éviter les doublons
     *
     * @param string $slug
     * @param int|null $excludeId ID à exclure (lors d'une mise à jour)
     * @return bool
     */
    public function slugExists(string $slug, ?int $excludeId = null): bool;
}


