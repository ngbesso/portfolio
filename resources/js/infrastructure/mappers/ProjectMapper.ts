import { Project } from '@/domain/entities/Project';
import { ProjectStatus } from '@/domain/valueObjects/ProjectStatus';

/**
 * Mapper : API Response → Domain Entity
 *
 * Responsabilité : Convertir les données de l'API en entités Domain
 */
export class ProjectMapper {
    static toDomain(data: any): Project {
        return new Project(
            data.id,
            data.title,
            data.slug,
            data.description,
            data.image,
            data.technologies || [],
            data.url,
            data.github_url,
            data.status as ProjectStatus,
            data.featured,
            new Date(data.created_at),
            data.updated_at ? new Date(data.updated_at) : null
        );
    }

    static toDomainArray(dataArray: any[]): Project[] {
        return dataArray.map((data) => this.toDomain(data));
    }
}
