<?php

namespace App\Core\Exceptions;

use RuntimeException;

/**
 * Exception lancée quand une compétence n'est pas trouvée
 *
 * @package App\Core\Exceptions
 */
class SkillNotFoundException extends RuntimeException
{
    public static function withId(int $id): self
    {
        return new self("Skill not found with ID: {$id}");
    }

    public static function withSlug(string $slug): self
    {
        return new self("Skill not found with slug: {$slug}");
    }
}

