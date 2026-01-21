import { IProjectRepository } from '@/domain/repositories/IProjectRepository';
import { Project } from '@/domain/entities/Project';

/**
 * Use Case : Récupérer tous les projets
 *
 * Principe : Orchestration de la logique applicative
 */
export class GetProjects {
    constructor(private repository: IProjectRepository) {}

    async execute(): Promise<Project[]> {
        return await this.repository.findAll();
    }
}
