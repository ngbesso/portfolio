import { useQuery } from '@tanstack/react-query';
import { container } from '@/config/container';

/**
 * Custom Hook : Récupérer tous les projets
 *
 * Utilise React Query pour le caching et la gestion du state
 */
export function useProjects() {
    const getProjects = container.getGetProjects();

    return useQuery({
        queryKey: ['projects'],
        queryFn: () => getProjects.execute(),
        staleTime: 5 * 60 * 1000, // 5 minutes
    });
}
