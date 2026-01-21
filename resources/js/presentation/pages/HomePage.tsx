import React from 'react';
import { Link } from 'react-router-dom';
import { Layout } from '../components/layout/Layout';
import { ProjectList } from '../components/projects/ProjectList';
import { SkillsGrid } from '../components/skills/SkillsGrid';
import { Loader } from '../components/common/Loader';
import { Button } from '../components/common/Button';
import { useFeaturedProjects } from '@/application/hooks/useFeaturedProjects';
import { useSkills } from '@/application/hooks/useSkills';
import { motion } from 'framer-motion';

export function HomePage() {
    const { data: projects, isLoading: projectsLoading } = useFeaturedProjects(6);
    const { data: skills, isLoading: skillsLoading } = useSkills();

    if (projectsLoading || skillsLoading) {
        return <Loader />;
    }

    return (
        <Layout>
            {/* Hero Section */}
            <section className="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-20">
                <div className="container mx-auto px-4">
                    <motion.div
                        initial={{ opacity: 0, y: 20 }}
                        animate={{ opacity: 1, y: 0 }}
                        transition={{ duration: 0.6 }}
                        className="max-w-3xl"
                    >
                        <h1 className="text-5xl font-bold mb-6">
                            Développeur Full Stack
                        </h1>
                        <p className="text-xl mb-8 text-blue-100">
                            Passionné par les technologies web modernes et l'architecture logicielle.
                            Créateur d'applications performantes et maintenables.
                        </p>
                        <div className="flex gap-4">
                            <Link to="/projects">
                                <Button variant="primary" size="lg">
                                    Voir mes projets
                                </Button>
                            </Link>
                            <Link to="/contact">
                                <Button variant="outline" size="lg" className="bg-white/10 border-white text-white hover:bg-white/20">
                                    Me contacter
                                </Button>
                            </Link>
                        </div>
                    </motion.div>
                </div>
            </section>

            {/* Projets Featured */}
            <section className="py-16 bg-gray-50">
                <div className="container mx-auto px-4">
                    <h2 className="text-3xl font-bold text-gray-900 mb-8">Projets en Vedette</h2>
                    <ProjectList projects={projects || []} />
                    <div className="mt-12 text-center">
                        <Link to="/projects">
                            <Button variant="outline">Voir tous les projets →</Button>
                        </Link>
                    </div>
                </div>
            </section>

            {/* Compétences */}
            <section className="py-16">
                <div className="container mx-auto px-4">
                    <h2 className="text-3xl font-bold text-gray-900 mb-8">Compétences</h2>
                    {skills && <SkillsGrid skillsByCategory={skills} />}
                </div>
            </section>
        </Layout>
    );
}
