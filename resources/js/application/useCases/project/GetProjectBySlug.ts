import { IProjectRepository } from '@/domain/repositories/IProjectRepository';
import { Project } from '@/domain/entities/Project';

/**
 * Use Case : Récupérer un projet par son slug
 */
export class GetProjectBySlug {
    constructor(private repository: IProjectRepository) {}

    async execute(slug: string): Promise<Project> {
        return await this.repository.findBySlug(slug);
    }
}
