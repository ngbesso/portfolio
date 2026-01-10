<?php

namespace App\Core\Exceptions;

use DomainException;

/**
 * Exception pour les données de compétence invalides
 *
 * @package App\Core\Exceptions
 */
class InvalidSkillDataException extends DomainException
{
    public static function invalidName(string $reason): self
    {
        return new self("Invalid skill name: {$reason}");
    }

    public static function invalidCategory(string $reason): self
    {
        return new self("Invalid skill category: {$reason}");
    }

    public static function invalidLevel(string $reason): self
    {
        return new self("Invalid skill level: {$reason}");
    }

    public static function invalidOrder(string $reason): self
    {
        return new self("Invalid skill order: {$reason}");
    }
}

