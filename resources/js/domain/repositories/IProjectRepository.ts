import { Project } from '../entities/Project';

/**
 * Interface : Project Repository
 * Définit le contrat pour la persistance des projets
 *
 * Principe : Dependency Inversion (SOLID)
 * Le Domain définit l'interface, l'Infrastructure l'implémente
 */
export interface IProjectRepository {
    /**
     * Récupérer tous les projets publiés
     */
    findAll(): Promise<Project[]>;

    /**
     * Récupérer les projets featured
     */
    findFeatured(limit?: number): Promise<Project[]>;

    /**
     * Récupérer un projet par son slug
     */
    findBySlug(slug: string): Promise<Project>;
}
