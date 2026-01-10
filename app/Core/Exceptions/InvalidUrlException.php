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


################################################################################
# PHASE 2 (SUITE) : EXCEPTIONS & COMMANDES
################################################################################

################################################################################
# FICHIER 11 : app/Core/Repositories/ContactRepositoryInterface.php
################################################################################

<?php

namespace App\Core\Repositories;

use App\Core\Entities\Contact;

/**
 * Interface ContactRepository
 *
 * @package App\Core\Repositories
 */
interface ContactRepositoryInterface
{
    /**
     * Récupérer tous les messages de contact
     *
     * @return Contact[]
     */
    public function findAll(): array;

    /**
     * Récupérer un message par ID
     *
     * @param int $id
     * @return Contact|null
     */
    public function findById(int $id): ?Contact;

    /**
     * Récupérer les messages non lus
     *
     * @return Contact[]
     */
    public function findUnread(): array;

    /**
     * Récupérer les messages récents (dernières 24h)
     *
     * @return Contact[]
     */
    public function findRecent(): array;

    /**
     * Créer un nouveau message de contact
     *
     * @param Contact $contact
     * @return Contact
     */
    public function create(Contact $contact): Contact;

    /**
     * Mettre à jour un message (pour marquer comme lu)
     *
     * @param Contact $contact
     * @return Contact
     */
    public function update(Contact $contact): Contact;

    /**
     * Supprimer un message
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Compter les messages non lus
     *
     * @return int
     */
    public function countUnread(): int;
}

# ============================================================================
# 📝 COMMIT 11 : Interface ContactRepository
# ============================================================================
# git add app/Core/Repositories/ContactRepositoryInterface.php
# git commit -m "feat(core): add ContactRepositoryInterface

# - Define repository contract for Contact persistence
# - CRUD methods
# - findUnread and findRecent queries
# - countUnread for admin badge notification

# Part of Domain Layer (Clean Architecture)"


################################################################################
# FICHIER 12 : app/Core/Exceptions/InvalidProjectDataException.php
################################################################################

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

# ============================================================================
# 📝 COMMIT 12 : Exception InvalidProjectDataException
# ============================================================================
# git add app/Core/Exceptions/InvalidProjectDataException.php
# git commit -m "feat(core): add InvalidProjectDataException

# - Create domain exception for invalid project data
# - Add named constructors for specific errors
# - Extends DomainException (business logic error)

# Part of Domain Layer (Clean Architecture)"


################################################################################
# FICHIER 13 : app/Core/Exceptions/InvalidSkillDataException.php
################################################################################

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

# ============================================================================
# 📝 COMMIT 13 : Exception InvalidSkillDataException
# ============================================================================
# git add app/Core/Exceptions/InvalidSkillDataException.php
# git commit -m "feat(core): add InvalidSkillDataException

# - Create domain exception for invalid skill data
# - Add named constructors for specific validation errors

# Part of Domain Layer (Clean Architecture)"


################################################################################
# FICHIER 14 : app/Core/Exceptions/InvalidContactDataException.php
################################################################################

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

# ============================================================================
# 📝 COMMIT 14 : Exception InvalidContactDataException
# ============================================================================
# git add app/Core/Exceptions/InvalidContactDataException.php
# git commit -m "feat(core): add InvalidContactDataException

# - Create domain exception for invalid contact data
# - Add named constructors for validation errors

# Part of Domain Layer (Clean Architecture)"


################################################################################
# FICHIER 15 : app/Core/Exceptions/InvalidUrlException.php
################################################################################

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


