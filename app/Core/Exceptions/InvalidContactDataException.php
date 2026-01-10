<?php

namespace App\Core\Exceptions;

use DomainException;

/**
 * Exception pour les données de contact invalides
 *
 * @package App\Core\Exceptions
 */
class InvalidContactDataException extends DomainException
{
    public static function invalidName(string $reason): self
    {
        return new self("Invalid contact name: {$reason}");
    }

    public static function invalidSubject(string $reason): self
    {
        return new self("Invalid contact subject: {$reason}");
    }

    public static function invalidMessage(string $reason): self
    {
        return new self("Invalid contact message: {$reason}");
    }
}


