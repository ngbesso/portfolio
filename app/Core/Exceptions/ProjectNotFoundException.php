<?php

namespace App\Core\Exceptions;

use RuntimeException;

/**
 * Exception lancée quand un projet n'est pas trouvé
 *
 * Hérite de RuntimeException car c'est une erreur d'exécution
 * (le projet devrait exister mais n'existe pas)
 *
 * @package App\Core\Exceptions
 */
class ProjectNotFoundException extends RuntimeException
{
    public static function withId(int $id): self
    {
        return new self("Project not found with ID: {$id}");
    }

    public static function withSlug(string $slug): self
    {
        return new self("Project not found with slug: {$slug}");
    }
}


