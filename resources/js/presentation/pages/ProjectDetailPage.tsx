import React from 'react';
import { useParams, Link } from 'react-router-dom';
import { Layout } from '../components/layout/Layout';
import { Loader } from '../components/common/Loader';
import { Button } from '../components/common/Button';
import { useProject } from '@/application/hooks/useProject';
import { motion } from 'framer-motion';

export function ProjectDetailPage() {
    const { slug } = useParams<{ slug: string }>();
    const { data: project, isLoading, error } = useProject(slug!);

    if (isLoading) {
        return <Loader />;
    }

    if (error || !project) {
        return (
            <Layout>
                <div className="container mx-auto px-4 py-16 text-center">
                    <h1 className="text-2xl font-bold text-gray-900 mb-4">Projet non trouvé</h1>
                    <Link to="/projects">
                        <Button variant="primary">Retour aux projets</Button>
                    </Link>
                </div>
            </Layout>
        );
    }

    return (
        <Layout>
            <article className="container mx-auto px-4 py-16">
                {/* Image */}
                {project.hasImage() && (
                    <motion.div
                        initial={{ opacity: 0 }}
                        animate={{ opacity: 1 }}
                        className="mb-8 rounded-xl overflow-hidden"
                    >
                        <img
                            src={project.image!}
                            alt={project.title}
                            className="w-full h-96 object-cover"
                        />
                    </motion.div>
                )}

                {/* Titre */}
                <h1 className="text-4xl font-bold text-gray-900 mb-4">{project.title}</h1>

                {/* Technologies */}
                <div className="flex flex-wrap gap-2 mb-8">
                    {project.technologies.map((tech) => (
                        <span
                            key={tech}
                            className="rounded-full bg-blue-100 px-4 py-2 text-sm font-medium text-blue-800"
                        >
              {tech}
            </span>
                    ))}
                </div>

                {/* Description */}
                <div className="prose prose-lg max-w-none mb-8">
                    <p className="text-gray-700 leading-relaxed">{project.description}</p>
                </div>

                {/* Liens */}
                <div className="flex gap-4">
                    {project.hasDemoUrl() && (
                        <a href={project.url!} target="_blank" rel="noopener noreferrer">
                            <Button variant="primary">Voir la démo →</Button>
                        </a>
                    )}
                    {project.hasGithubUrl() && (
                        <a href={project.githubUrl!} target="_blank" rel="noopener noreferrer">
                            <Button variant="outline">Code source (GitHub)</Button>
                        </a>
                    )}
                </div>

                {/* Retour */}
                <div className="mt-12">
                    <Link to="/projects">
                        <Button variant="secondary">← Retour aux projets</Button>
                    </Link>
                </div>
            </article>
        </Layout>
    );
}
