import React from 'react';
import { ProjectCard } from './ProjectCard';
import { Project } from '@/domain/entities/Project';

interface ProjectListProps {
    projects: Project[];
}

export function ProjectList({ projects }: ProjectListProps) {
    if (projects.length === 0) {
        return (
            <div className="text-center py-12">
                <p className="text-gray-600 text-lg">Aucun projet disponible pour le moment.</p>
            </div>
        );
    }

    return (
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            {projects.map((project) => (
                <ProjectCard key={project.id} project={project} />
            ))}
        </div>
    );
}
