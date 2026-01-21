import { ISkillRepository } from '@/domain/repositories/ISkillRepository';
import { Skill } from '@/domain/entities/Skill';
import { httpClient } from './httpClient';
import { SkillMapper } from '../mappers/SkillMapper';

/**
 * Repository : Implémentation API pour les compétences
 */
export class SkillApiRepository implements ISkillRepository {
    async findAllGroupedByCategory(): Promise<Map<string, Skill[]>> {
        const response = await httpClient.get<{ data: any[] }>('/api/skills');

        const skillsMap = new Map<string, Skill[]>();

        response.data.data.forEach((group: any) => {
            const skills = SkillMapper.toDomainArray(group.skills);
            skillsMap.set(group.category, skills);
        });

        return skillsMap;
    }
}
