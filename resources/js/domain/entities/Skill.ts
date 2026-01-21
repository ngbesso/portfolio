import { SkillLevel } from '../valueObjects/SkillLevel';

/**
 * Entity : Skill
 * Représente une compétence technique
 */
export class Skill {
    constructor(
        public readonly id: number,
        public readonly name: string,
        public readonly slug: string,
        public readonly category: string,
        public readonly level: SkillLevel,
        public readonly levelLabel: string,
        public readonly levelPercentage: number,
        public readonly icon: string | null
    ) {}

    /**
     * Vérifier si c'est un niveau expert
     */
    isExpert(): boolean {
        return this.level === SkillLevel.EXPERT;
    }

    /**
     * Vérifier si c'est un niveau avancé ou plus
     */
    isAdvancedOrHigher(): boolean {
        return this.level === SkillLevel.ADVANCED || this.level === SkillLevel.EXPERT;
    }
}
