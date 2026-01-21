import { useQuery } from '@tanstack/react-query';
import { container } from '@/config/container';

/**
 * Custom Hook : Récupérer un projet par slug
 */
export function useProject(slug: string) {
    const getProjectBySlug = container.getGetProjectBySlug();

    return useQuery({
        queryKey: ['projects', slug],
        queryFn: () => getProjectBySlug.execute(slug),
        enabled: !!slug,
        staleTime: 10 * 60 * 1000,
    });
}
