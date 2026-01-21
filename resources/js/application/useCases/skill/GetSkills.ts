import { ISkillRepository } from '@/domain/repositories/ISkillRepository.ts';
import { Skill } from '@/domain/entities/Skill.ts';

/**
 * Use Case : Récupérer les compétences groupées
 */
export class GetSkills {
    constructor(private repository: ISkillRepository) {}

    async execute(): Promise<Map<string, Skill[]>> {
        return await this.repository.findAllGroupedByCategory();
    }
}
