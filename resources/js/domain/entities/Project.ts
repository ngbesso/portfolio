import { ProjectStatus } from '../valueObjects/ProjectStatus';

/**
 * Entity : Project
 * Représente un projet du portfolio
 *
 * Principe : L'entité contient la logique métier pure
 */
export class Project {
    constructor(
        public readonly id: number,
        public readonly title: string,
        public readonly slug: string,
        public readonly description: string,
        public readonly image: string | null,
        public readonly technologies: string[],
        public readonly url: string | null,
        public readonly githubUrl: string | null,
        public readonly status: ProjectStatus,
        public readonly featured: boolean,
        public readonly createdAt: Date,
        public readonly updatedAt: Date | null
    ) {}

    /**
     * Vérifier si le projet est publié
     */
    isPublished(): boolean {
        return this.status === ProjectStatus.PUBLISHED;
    }

    /**
     * Vérifier si le projet est featured
     */
    isFeatured(): boolean {
        return this.featured && this.isPublished();
    }

    /**
     * Vérifier si le projet est archivé
     */
    isArchived(): boolean {
        return this.status === ProjectStatus.ARCHIVED;
    }

    /**
     * Obtenir les 3 premières technologies
     */
    getMainTechnologies(limit = 3): string[] {
        return this.technologies.slice(0, limit);
    }

    /**
     * Vérifier si le projet a une image
     */
    hasImage(): boolean {
        return this.image !== null;
    }

    /**
     * Vérifier si le projet a une URL de démo
     */
    hasDemoUrl(): boolean {
        return this.url !== null;
    }

    /**
     * Vérifier si le projet a un repository GitHub
     */
    hasGithubUrl(): boolean {
        return this.githubUrl !== null;
    }
}
