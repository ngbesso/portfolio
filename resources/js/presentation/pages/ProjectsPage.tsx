import React from 'react';
import { Layout } from '../components/layout/Layout';
import { ProjectList } from '../components/projects/ProjectList';
import { Loader } from '../components/common/Loader';
import { useProjects } from '@/application/hooks/useProjects';

export function ProjectsPage() {
    const { data: projects, isLoading, error } = useProjects();

    if (isLoading) {
        return <Loader />;
    }

    if (error) {
        return (
            <Layout>
                <div className="container mx-auto px-4 py-16">
                    <p className="text-red-600">Erreur lors du chargement des projets.</p>
                </div>
            </Layout>
        );
    }

    return (
        <Layout>
            <div className="container mx-auto px-4 py-16">
                <h1 className="text-4xl font-bold text-gray-900 mb-8">Mes Projets</h1>
                <ProjectList projects={projects || []} />
            </div>
        </Layout>
    );
}
