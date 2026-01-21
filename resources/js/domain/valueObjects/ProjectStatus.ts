/**
 * Value Object : ProjectStatus
 * Énumération des statuts possibles d'un projet
 */
export enum ProjectStatus {
    DRAFT = 'draft',
    PUBLISHED = 'published',
    ARCHIVED = 'archived',
}

export function getProjectStatusLabel(status: ProjectStatus): string {
    switch (status) {
        case ProjectStatus.DRAFT:
            return 'Brouillon';
        case ProjectStatus.PUBLISHED:
            return 'Publié';
        case ProjectStatus.ARCHIVED:
            return 'Archivé';
        default:
            return 'Inconnu';
    }
}
