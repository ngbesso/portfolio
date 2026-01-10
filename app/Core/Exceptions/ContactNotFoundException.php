<?php

namespace App\Core\Exceptions;

use RuntimeException;

/**
 * Exception lancée quand un message de contact n'est pas trouvé
 *
 * @package App\Core\Exceptions
 */
class ContactNotFoundException extends RuntimeException
{
    public static function withId(int $id): self
    {
        return new self("Contact message not found with ID: {$id}");
    }
}


