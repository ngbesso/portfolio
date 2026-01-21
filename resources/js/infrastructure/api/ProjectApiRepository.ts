import { IProjectRepository } from '@/domain/repositories/IProjectRepository';
import { Project } from '@/domain/entities/Project';
import { httpClient } from './httpClient';
import { ProjectMapper } from '../mappers/ProjectMapper';

/**
 * Repository : Implémentation API pour les projets
 *
 * Implémente IProjectRepository défini dans le Domain
 */
export class ProjectApiRepository implements IProjectRepository {
    async findAll(): Promise<Project[]> {
        const response = await httpClient.get<{ data: any[] }>('/api/projects');
        return ProjectMapper.toDomainArray(response.data.data);
    }

    async findFeatured(limit = 6): Promise<Project[]> {
        const response = await httpClient.get<{ data: any[] }>('/api/projects/featured', {
            params: { limit },
        });
        return ProjectMapper.toDomainArray(response.data.data);
    }

    async findBySlug(slug: string): Promise<Project> {
        const response = await httpClient.get<{ data: any }>(`/api/projects/${slug}`);
        return ProjectMapper.toDomain(response.data.data);
    }
}
