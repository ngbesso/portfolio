/**
 * Value Object : SkillLevel
 * Niveau de maîtrise d'une compétence
 */
export enum SkillLevel {
    BEGINNER = 'beginner',
    INTERMEDIATE = 'intermediate',
    ADVANCED = 'advanced',
    EXPERT = 'expert',
}

export function getSkillLevelLabel(level: SkillLevel): string {
    switch (level) {
        case SkillLevel.BEGINNER:
            return 'Débutant';
        case SkillLevel.INTERMEDIATE:
            return 'Intermédiaire';
        case SkillLevel.ADVANCED:
            return 'Avancé';
        case SkillLevel.EXPERT:
            return 'Expert';
        default:
            return 'Inconnu';
    }
}

export function getSkillLevelPercentage(level: SkillLevel): number {
    switch (level) {
        case SkillLevel.BEGINNER:
            return 25;
        case SkillLevel.INTERMEDIATE:
            return 50;
        case SkillLevel.ADVANCED:
            return 75;
        case SkillLevel.EXPERT:
            return 100;
        default:
            return 0;
    }
}
