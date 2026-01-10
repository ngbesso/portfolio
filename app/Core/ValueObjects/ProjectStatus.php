<?php

namespace App\Core\ValueObjects;

/**
 * Value Object : ProjectStatus
 *
 * Représente le statut d'un projet sous forme d'énumération.
 *
 * Principes des Value Objects :
 * - Immuable : Pas de setters
 * - Pas d'identité : Comparaison par valeur
 * - Auto-validant : Validation dans le constructeur
 *
 * Utilise les Enums PHP 8.1+ (Backed Enum)
 *
 * @package App\Core\ValueObjects
 */
enum ProjectStatus: string
{
    case DRAFT = 'draft';           // Brouillon - En cours de création
    case PUBLISHED = 'published';   // Publié - Visible sur le portfolio
    case ARCHIVED = 'archived';     // Archivé - Plus affiché mais conservé

    /**
     * Obtenir le libellé humain du statut
     * Utile pour l'affichage dans l'interface
     *
     * @return string
     */
    public function label(): string
    {
        return match($this) {
            self::DRAFT => 'Brouillon',
            self::PUBLISHED => 'Publié',
            self::ARCHIVED => 'Archivé',
        };
    }

    /**
     * Obtenir la couleur associée au statut
     * Pour le badge dans l'interface admin
     *
     * @return string Classe Tailwind CSS
     */
    public function color(): string
    {
        return match($this) {
            self::DRAFT => 'gray',
            self::PUBLISHED => 'green',
            self::ARCHIVED => 'red',
        };
    }

    /**
     * Vérifier si le statut est "brouillon"
     */
    public function isDraft(): bool
    {
        return $this === self::DRAFT;
    }

    /**
     * Vérifier si le statut est "publié"
     */
    public function isPublished(): bool
    {
        return $this === self::PUBLISHED;
    }

    /**
     * Vérifier si le statut est "archivé"
     */
    public function isArchived(): bool
    {
        return $this === self::ARCHIVED;
    }

    /**
     * Obtenir tous les statuts possibles
     * Utile pour les dropdowns dans l'admin
     *
     * @return array
     */
    public static function all(): array
    {
        return [
            self::DRAFT->value => self::DRAFT->label(),
            self::PUBLISHED->value => self::PUBLISHED->label(),
            self::ARCHIVED->value => self::ARCHIVED->label(),
        ];
    }

    /**
     * Créer depuis une chaîne de caractères
     * Avec validation et message d'erreur personnalisé
     *
     * @param string $value
     * @return self
     * @throws \ValueError Si la valeur n'est pas valide
     */
    public static function fromString(string $value): self
    {
        return self::tryFrom($value)
            ?? throw new \ValueError("Invalid project status: {$value}");
    }
}


