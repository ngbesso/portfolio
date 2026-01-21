import React from 'react';
import { Link } from 'react-router-dom';
import { motion } from 'framer-motion';
import { Project } from '@/domain/entities/Project';

interface ProjectCardProps {
    project: Project;
}

export function ProjectCard({ project }: ProjectCardProps) {
    return (
        <Link to={`/projects/${project.slug}`}>
            <motion.div
                whileHover={{ y: -8 }}
                className="group relative overflow-hidden rounded-xl bg-white shadow-lg transition-shadow hover:shadow-2xl"
            >
                {/* Image */}
                {project.hasImage() && (
                    <div className="relative h-48 overflow-hidden bg-gray-200">
                        <img
                            src={project.image!}
                            alt={project.title}
                            className="h-full w-full object-cover transition-transform duration-300 group-hover:scale-110"
                        />
                        {project.isFeatured() && (
                            <span className="absolute top-2 right-2 rounded-full bg-yellow-500 px-3 py-1 text-xs font-semibold text-white">
                ⭐ Featured
              </span>
                        )}
                    </div>
                )}

                {/* Contenu */}
                <div className="p-6">
                    <h3 className="text-xl font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors">
                        {project.title}
                    </h3>

                    <p className="text-gray-600 mb-4 line-clamp-2">
                        {project.description}
                    </p>

                    {/* Technologies */}
                    <div className="flex flex-wrap gap-2">
                        {project.getMainTechnologies().map((tech) => (
                            <span
                                key={tech}
                                className="rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-800"
                            >
                {tech}
              </span>
                        ))}
                        {project.technologies.length > 3 && (
                            <span className="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600">
                +{project.technologies.length - 3}
              </span>
                        )}
                    </div>
                </div>

                {/* Hover overlay */}
                <div className="absolute inset-0 bg-gradient-to-t from-blue-600/10 to-transparent opacity-0 transition-opacity group-hover:opacity-100" />
            </motion.div>
        </Link>
    );
}
