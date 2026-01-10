<?php

namespace App\Core\Exceptions;
use DomainException;

/**
 * Exception pour les URLs invalides
 *
 * @package App\Core\Exceptions
 */
class InvalidUrlException extends DomainException
{
    public static function invalidFormat(string $url): self
    {
        return new self("Invalid URL format: {$url}");
    }

    public static function invalidProtocol(string $url): self
    {
        return new self("URL must use HTTP or HTTPS: {$url}");
    }

    public static function missingDomain(string $url): self
    {
        return new self("URL must have a valid domain: {$url}");
    }
}

