import { Skill } from '../entities/Skill';

/**
 * Interface : Skill Repository
 */
export interface ISkillRepository {
    /**
     * Récupérer toutes les compétences groupées par catégorie
     */
    findAllGroupedByCategory(): Promise<Map<string, Skill[]>>;
}
