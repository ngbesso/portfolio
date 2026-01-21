import React from 'react';
import { Link, useLocation } from 'react-router-dom';
import { motion } from 'framer-motion';

export function Header() {
    const location = useLocation();

    const isActive = (path: string) => location.pathname === path;

    const navItems = [
        { path: '/', label: 'Accueil' },
        { path: '/projects', label: 'Projets' },
        { path: '/contact', label: 'Contact' },
    ];

    return (
        <header className="bg-white shadow-sm sticky top-0 z-50">
            <nav className="container mx-auto px-4 py-4">
                <div className="flex items-center justify-between">
                    {/* Logo */}
                    <Link to="/" className="text-2xl font-bold text-blue-600">
                        Portfolio
                    </Link>

                    {/* Navigation */}
                    <ul className="flex space-x-8">
                        {navItems.map((item) => (
                            <li key={item.path}>
                                <Link
                                    to={item.path}
                                    className={`relative py-2 text-gray-700 hover:text-blue-600 transition-colors ${
                                        isActive(item.path) ? 'text-blue-600 font-semibold' : ''
                                    }`}
                                >
                                    {item.label}
                                    {isActive(item.path) && (
                                        <motion.div
                                            layoutId="activeTab"
                                            className="absolute bottom-0 left-0 right-0 h-0.5 bg-blue-600"
                                            initial={false}
                                        />
                                    )}
                                </Link>
                            </li>
                        ))}
                    </ul>
                </div>
            </nav>
        </header>
    );
}
