<?php

namespace App\Core\ValueObjects;

use App\Core\Exceptions\InvalidEmailException;

/**
 * Value Object : Email
 *
 * Représente une adresse email valide.
 * Garantit que toutes les emails dans le système sont valides.
 *
 * @package App\Core\ValueObjects
 */
final readonly class Email
{
    private string $value;

    /**
     * @param string $email L'adresse email à valider
     * @throws InvalidEmailException Si l'email n'est pas valide
     */
    public function __construct(string $email)
    {
        $this->validate($email);
        $this->value = strtolower(trim($email)); // Normalisation
    }

    /**
     * Obtenir la valeur de l'email
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Représentation en chaîne
     */
    public function __toString(): string
    {
        return $this->value;
    }

    /**
     * Obtenir le domaine de l'email
     * Ex: john@example.com -> example.com
     */
    public function getDomain(): string
    {
        $parts = explode('@', $this->value);
        return $parts[1] ?? '';
    }

    /**
     * Obtenir la partie locale de l'email
     * Ex: john@example.com -> john
     */
    public function getLocalPart(): string
    {
        $parts = explode('@', $this->value);
        return $parts[0] ?? '';
    }

    /**
     * Comparer deux emails
     */
    public function equals(Email $other): bool
    {
        return $this->value === $other->value;
    }

    /**
     * Valider l'adresse email
     *
     * Règles :
     * - Format email valide
     * - Pas d'espaces
     * - Longueur maximale de 254 caractères (RFC 5321)
     */
    private function validate(string $email): void
    {
        $email = trim($email);

        // Vérification de la présence de valeur
        if (empty($email)) {
            throw new InvalidEmailException('Email cannot be empty');
        }

        // Vérification du format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException("Invalid email format: {$email}");
        }

        // Vérification de la longueur (RFC 5321)
        if (strlen($email) > 254) {
            throw new InvalidEmailException('Email address too long (max 254 characters)');
        }

        // Vérification de l'absence d'espaces
        if (preg_match('/\s/', $email)) {
            throw new InvalidEmailException('Email cannot contain whitespace');
        }
    }

    /**
     * Créer un email de manière sûre
     */
    public static function tryCreate(?string $email): ?self
    {
        if ($email === null || trim($email) === '') {
            return null;
        }

        try {
            return new self($email);
        } catch (InvalidEmailException) {
            return null;
        }
    }
}
