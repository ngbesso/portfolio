import { IProjectRepository } from '@/domain/repositories/IProjectRepository';
import { Project } from '@/domain/entities/Project';

/**
 * Use Case : Récupérer les projets featured
 */
export class GetFeaturedProjects {
    constructor(private repository: IProjectRepository) {}

    async execute(limit = 6): Promise<Project[]> {
        return await this.repository.findFeatured(limit);
    }
}
