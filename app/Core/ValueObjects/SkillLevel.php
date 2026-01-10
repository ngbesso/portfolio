<?php

namespace App\Core\ValueObjects;

/**
 * Value Object : SkillLevel
 * Représente le niveau de maîtrise d'une compétence
 *
 * @package App\Core\ValueObjects
 */
enum SkillLevel: string
{
    case BEGINNER = 'beginner';         // Débutant - Notions de base
    case INTERMEDIATE = 'intermediate'; // Intermédiaire - Utilisation régulière
    case ADVANCED = 'advanced';         // Avancé - Maîtrise approfondie
    case EXPERT = 'expert';             // Expert - Référent sur la technologie

    /**
     * Obtenir le libellé en français
     */
    public function label(): string
    {
        return match($this) {
            self::BEGINNER => 'Débutant',
            self::INTERMEDIATE => 'Intermédiaire',
            self::ADVANCED => 'Avancé',
            self::EXPERT => 'Expert',
        };
    }

    /**
     * Obtenir un pourcentage de maîtrise (pour les barres de progression)
     */
    public function percentage(): int
    {
        return match($this) {
            self::BEGINNER => 25,
            self::INTERMEDIATE => 50,
            self::ADVANCED => 75,
            self::EXPERT => 100,
        };
    }

    /**
     * Obtenir la couleur associée (Tailwind)
     */
    public function color(): string
    {
        return match($this) {
            self::BEGINNER => 'blue',
            self::INTERMEDIATE => 'yellow',
            self::ADVANCED => 'green',
            self::EXPERT => 'purple',
        };
    }

    /**
     * Tous les niveaux pour les dropdowns
     */
    public static function all(): array
    {
        return [
            self::BEGINNER->value => self::BEGINNER->label(),
            self::INTERMEDIATE->value => self::INTERMEDIATE->label(),
            self::ADVANCED->value => self::ADVANCED->label(),
            self::EXPERT->value => self::EXPERT->label(),
        ];
    }
}


