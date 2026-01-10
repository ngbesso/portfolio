<?php

namespace App\Core\Exceptions;

use DomainException;

/**
 * Exception pour les emails invalides
 *
 * @package App\Core\Exceptions
 */
class InvalidEmailException extends DomainException
{
    public static function emptyEmail(): self
    {
        return new self('Email address cannot be empty');
    }

    public static function invalidFormat(string $email): self
    {
        return new self("Invalid email format: {$email}");
    }

    public static function tooLong(string $email): self
    {
        return new self("Email address too long (max 254 characters): {$email}");
    }

    public static function containsWhitespace(string $email): self
    {
        return new self("Email address cannot contain whitespace: {$email}");
    }
}
