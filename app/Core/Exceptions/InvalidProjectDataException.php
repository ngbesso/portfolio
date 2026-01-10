<?php

namespace App\Core\Exceptions;

use DomainException;

/**
 * Exception lancée lorsqu'une donnée de projet est invalide
 *
 * Hérite de DomainException (pas de RuntimeException) car c'est une
 * erreur de logique métier, pas une erreur d'exécution.
 *
 * @package App\Core\Exceptions
 */
class InvalidProjectDataException extends DomainException
{
    /**
     * Créer une exception pour un titre invalide
     */
    public static function invalidTitle(string $reason): self
    {
        return new self("Invalid project title: {$reason}");
    }

    /**
     * Créer une exception pour une description invalide
     */
    public static function invalidDescription(string $reason): self
    {
        return new self("Invalid project description: {$reason}");
    }

    /**
     * Créer une exception pour des technologies invalides
     */
    public static function invalidTechnologies(string $reason): self
    {
        return new self("Invalid project technologies: {$reason}");
    }

    /**
     * Créer une exception pour publication impossible
     */
    public static function cannotPublish(string $reason): self
    {
        return new self("Cannot publish project: {$reason}");
    }
}




