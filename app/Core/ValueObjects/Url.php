<?php

namespace App\Core\ValueObjects;

use App\Core\Exceptions\InvalidUrlException;

/**
 * Value Object : URL
 *
 * Représente une URL valide avec validation.
 * Garantit que toute URL dans le système est valide.
 *
 * Principes :
 * - Immuable : Pas de modification après création
 * - Auto-validant : Validation à l'instanciation
 * - Encapsulation : La validation est masquée
 *
 * @package App\Core\ValueObjects
 */
final readonly class Url
{
    private string $value;

    /**
     * @param string $url L'URL à valider et encapsuler
     * @throws InvalidUrlException Si l'URL n'est pas valide
     */
    public function __construct(string $url)
    {
        $this->validate($url);
        $this->value = $url;
    }

    /**
     * Obtenir la valeur de l'URL
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Représentation en chaîne de caractères
     * Permet d'utiliser l'objet comme une string
     * Ex: echo $url;
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->value;
    }

    /**
     * Vérifier si l'URL est sécurisée (HTTPS)
     *
     * @return bool
     */
    public function isSecure(): bool
    {
        return str_starts_with($this->value, 'https://');
    }

    /**
     * Obtenir le domaine de l'URL
     * Ex: https://example.com/page -> example.com
     *
     * @return string
     */
    public function getDomain(): string
    {
        return parse_url($this->value, PHP_URL_HOST) ?? '';
    }

    /**
     * Vérifier si l'URL pointe vers GitHub
     * Utile pour les URLs GitHub du portfolio
     *
     * @return bool
     */
    public function isGithubUrl(): bool
    {
        return str_contains($this->getDomain(), 'github.com');
    }

    /**
     * Comparer deux URLs
     * Value Objects se comparent par valeur, pas par référence
     *
     * @param Url $other
     * @return bool
     */
    public function equals(Url $other): bool
    {
        return $this->value === $other->value;
    }

    /**
     * Valider l'URL selon les règles métier
     *
     * Règles :
     * - Format URL valide
     * - Protocole HTTP ou HTTPS uniquement
     * - Domaine requis
     *
     * @param string $url
     * @throws InvalidUrlException
     */
    private function validate(string $url): void
    {
        // Vérification du format général
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidUrlException("Invalid URL format: {$url}");
        }

        // Vérification du protocole (HTTP ou HTTPS uniquement)
        $scheme = parse_url($url, PHP_URL_SCHEME);
        if (!in_array($scheme, ['http', 'https'], true)) {
            throw new InvalidUrlException(
                "URL must use HTTP or HTTPS protocol: {$url}"
            );
        }

        // Vérification de la présence d'un domaine
        $host = parse_url($url, PHP_URL_HOST);
        if (empty($host)) {
            throw new InvalidUrlException("URL must have a valid domain: {$url}");
        }
    }

    /**
     * Créer une URL de manière sûre (retourne null si invalide)
     * Pattern : Null Object
     *
     * @param string|null $url
     * @return self|null
     */
    public static function tryCreate(?string $url): ?self
    {
        if ($url === null || trim($url) === '') {
            return null;
        }

        try {
            return new self($url);
        } catch (InvalidUrlException) {
            return null;
        }
    }
}
