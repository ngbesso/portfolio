import { Skill } from '@/domain/entities/Skill';
import { SkillLevel } from '@/domain/valueObjects/SkillLevel';

/**
 * Mapper : API Response → Skill Entity
 */
export class SkillMapper {
    static toDomain(data: any): Skill {
        return new Skill(
            data.id,
            data.name,
            data.slug,
            data.category,
            data.level as SkillLevel,
            data.level_label,
            data.level_percentage,
            data.icon
        );
    }

    static toDomainArray(dataArray: any[]): Skill[] {
        return dataArray.map((data) => this.toDomain(data));
    }
}
