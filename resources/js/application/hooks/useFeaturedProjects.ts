import { useQuery } from '@tanstack/react-query';
import { container } from '@/config/container';

/**
 * Custom Hook : Récupérer les projets featured
 */
export function useFeaturedProjects(limit = 6) {
    const getFeaturedProjects = container.getGetFeaturedProjects();

    return useQuery({
        queryKey: ['projects', 'featured', limit],
        queryFn: () => getFeaturedProjects.execute(limit),
        staleTime: 5 * 60 * 1000,
    });
}
