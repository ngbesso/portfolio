import React from 'react';

export function Footer() {
    const currentYear = new Date().getFullYear();

    return (
        <footer className="bg-gray-900 text-white py-12 mt-20">
            <div className="container mx-auto px-4">
                <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
                    {/* À propos */}
                    <div>
                        <h3 className="text-xl font-bold mb-4">Portfolio</h3>
                        <p className="text-gray-400">
                            Développeur Full Stack passionné par les technologies web modernes
                            et l'architecture logicielle.
                        </p>
                    </div>

                    {/* Liens rapides */}
                    <div>
                        <h3 className="text-xl font-bold mb-4">Liens Rapides</h3>
                        <ul className="space-y-2">
                            <li>
                                <a href="/" className="text-gray-400 hover:text-white transition-colors">
                                    Accueil
                                </a>
                            </li>
                            <li>
                                <a href="/projects" className="text-gray-400 hover:text-white transition-colors">
                                    Projets
                                </a>
                            </li>
                            <li>
                                <a href="/contact" className="text-gray-400 hover:text-white transition-colors">
                                    Contact
                                </a>
                            </li>
                        </ul>
                    </div>

                    {/* Réseaux sociaux */}
                    <div>
                        <h3 className="text-xl font-bold mb-4">Suivez-moi</h3>
                        <div className="flex space-x-4">
                            <a
                                href="https://github.com"
                                target="_blank"
                                rel="noopener noreferrer"
                                className="text-gray-400 hover:text-white transition-colors"
                            >
                                GitHub
                            </a>
                            <a
                                href="https://linkedin.com"
                                target="_blank"
                                rel="noopener noreferrer"
                                className="text-gray-400 hover:text-white transition-colors"
                            >
                                LinkedIn
                            </a>
                        </div>
                    </div>
                </div>

                <div className="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                    <p>&copy; {currentYear} Portfolio. Tous droits réservés.</p>
                </div>
            </div>
        </footer>
    );
}
