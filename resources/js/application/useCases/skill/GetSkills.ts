import { ISkillRepository } from '@/domain/repositories/ISkillRepository';
import { Skill } from '@/domain/entities/Skill';

/**
 * Use Case : Récupérer les compétences groupées
 */
export class GetSkills {
    constructor(private repository: ISkillRepository) {}

    async execute(): Promise<Map<string, Skill[]>> {
        return await this.repository.findAllGroupedByCategory();
    }
}
