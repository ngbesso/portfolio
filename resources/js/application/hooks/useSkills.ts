import { useQuery } from '@tanstack/react-query';
import { container } from '@/config/container';

/**
 * Custom Hook : Récupérer les compétences
 */
export function useSkills() {
    const getSkills = container.getGetSkills();

    return useQuery({
        queryKey: ['skills'],
        queryFn: () => getSkills.execute(),
        staleTime: 10 * 60 * 1000,
    });
}
