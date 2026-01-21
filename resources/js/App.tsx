import React from 'react';
import { BrowserRouter, Routes, Route } from 'react-router-dom';
import { QueryClient, QueryClientProvider } from '@tanstack/react-query';
import { ReactQueryDevtools } from '@tanstack/react-query-devtools';

// Pages
import { HomePage } from './presentation/pages/HomePage';
import { ProjectsPage } from './presentation/pages/ProjectsPage';
import { ProjectDetailPage } from './presentation/pages/ProjectDetailPage';
import { ContactPage } from './presentation/pages/ContactPage';

// Configuration React Query
const queryClient = new QueryClient({
    defaultOptions: {
        queries: {
            refetchOnWindowFocus: false,
            retry: 1,
            staleTime: 5 * 60 * 1000, // 5 minutes
        },
    },
});

/**
 * Application React principale
 *
 * Configuration :
 * - React Router pour le routing SPA
 * - React Query pour la gestion du state serveur
 * - React Query Devtools en développement
 */
export function App() {
    return (
        <QueryClientProvider client={queryClient}>
            <BrowserRouter>
                <Routes>
                    <Route path="/" element={<HomePage />} />
                    <Route path="/projects" element={<ProjectsPage />} />
                    <Route path="/projects/:slug" element={<ProjectDetailPage />} />
                    <Route path="/contact" element={<ContactPage />} />

                    {/* 404 */}
                    <Route
                        path="*"
                        element={
                            <div className="flex items-center justify-center min-h-screen">
                                <div className="text-center">
                                    <h1 className="text-4xl font-bold text-gray-900 mb-4">404</h1>
                                    <p className="text-gray-600 mb-8">Page non trouvée</p>
                                    <a href="/" className="text-blue-600 hover:underline">
                                        Retour à l'accueil
                                    </a>
                                </div>
                            </div>
                        }
                    />
                </Routes>
            </BrowserRouter>

            {/* React Query Devtools (uniquement en dev) */}
            {import.meta.env.DEV && <ReactQueryDevtools initialIsOpen={false} />}
        </QueryClientProvider>
    );
}
