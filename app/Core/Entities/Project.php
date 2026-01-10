<?php
namespace App\Core\Entities;

use App\Core\ValueObjects\ProjectStatus;
use App\Core\ValueObjects\Url;
use App\Core\Exceptions\InvalidProjectDataException;
use DateTime;

/**
 * Entité Project - Représente un projet du portfolio
 *
 * Cette classe fait partie de la couche Domain (Core).
 * Elle contient UNIQUEMENT la logique métier pure, sans dépendance
 * à un framework ou une base de données.
 *
 * Principes appliqués :
 * - Encapsulation : Les propriétés sont privées
 * - Validation métier : Les règles métier sont dans l'entité
 * - Immuabilité partielle : Utilisation de setters avec validation
 * - Pas de dépendance externe : Aucune référence à Eloquent, DB, etc.
 *
 * @package App\Core\Entities
 */
class Project
{
    /**
     * @param int|null $id Identifiant unique (null pour une nouvelle entité)
     * @param string $title Titre du projet (3-200 caractères)
     * @param string $slug Slug unique pour l'URL
     * @param string $description Description détaillée du projet
     * @param string|null $image Chemin vers l'image principale
     * @param array $technologies Liste des technologies utilisées ['PHP', 'Laravel', 'Vue.js']
     * @param Url|null $url URL de démo du projet
     * @param Url|null $githubUrl URL du repository GitHub
     * @param ProjectStatus $status Statut du projet (draft, published, archived)
     * @param bool $featured Projet mis en avant sur la page d'accueil
     * @param int $order Ordre d'affichage (pour le tri)
     * @param DateTime $createdAt Date de création
     * @param DateTime|null $updatedAt Date de dernière modification
     */
    public function __construct(
        private ?int $id,
        private string $title,
        private string $slug,
        private string $description,
        private ?string $image,
        private array $technologies,
        private ?Url $url,
        private ?Url $githubUrl,
        private ProjectStatus $status,
        private bool $featured,
        private int $order,
        private DateTime $createdAt,
        private ?DateTime $updatedAt = null
    ) {
        // Validation des règles métier à l'instanciation
        $this->validateTitle($title);
        $this->validateDescription($description);
        $this->validateTechnologies($technologies);
    }

    /**
     * Factory method pour créer un nouveau projet
     * Pattern : Named Constructor
     *
     * @param string $title
     * @param string $description
     * @param array $technologies
     * @return self
     */
    public static function create(
        string $title,
        string $description,
        array $technologies
    ): self {
        return new self(
            id: null,
            title: $title,
            slug: self::generateSlug($title),
            description: $description,
            image: null,
            technologies: $technologies,
            url: null,
            githubUrl: null,
            status: ProjectStatus::DRAFT, // Par défaut : brouillon
            featured: false,
            order: 0,
            createdAt: new DateTime(),
            updatedAt: null
        );
    }

    // ========================================================================
    // GETTERS - Accès en lecture aux propriétés
    // ========================================================================

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function getTechnologies(): array
    {
        return $this->technologies;
    }

    public function getUrl(): ?Url
    {
        return $this->url;
    }

    public function getGithubUrl(): ?Url
    {
        return $this->githubUrl;
    }

    public function getStatus(): ProjectStatus
    {
        return $this->status;
    }

    public function isFeatured(): bool
    {
        return $this->featured;
    }

    public function getOrder(): int
    {
        return $this->order;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    // ========================================================================
    // SETTERS - Modification avec validation des règles métier
    // ========================================================================

    /**
     * Modifier le titre du projet
     * Règle métier : Le titre doit faire entre 3 et 200 caractères
     */
    public function updateTitle(string $title): void
    {
        $this->validateTitle($title);
        $this->title = $title;
        $this->slug = self::generateSlug($title);
        $this->markAsUpdated();
    }

    /**
     * Modifier la description du projet
     * Règle métier : La description doit faire au moins 20 caractères
     */
    public function updateDescription(string $description): void
    {
        $this->validateDescription($description);
        $this->description = $description;
        $this->markAsUpdated();
    }

    /**
     * Définir l'image du projet
     */
    public function setImage(string $imagePath): void
    {
        $this->image = $imagePath;
        $this->markAsUpdated();
    }

    /**
     * Mettre à jour les technologies
     * Règle métier : Au moins une technologie doit être définie
     */
    public function updateTechnologies(array $technologies): void
    {
        $this->validateTechnologies($technologies);
        $this->technologies = $technologies;
        $this->markAsUpdated();
    }

    /**
     * Définir l'URL du projet
     */
    public function setUrl(?Url $url): void
    {
        $this->url = $url;
        $this->markAsUpdated();
    }

    /**
     * Définir l'URL GitHub
     */
    public function setGithubUrl(?Url $githubUrl): void
    {
        $this->githubUrl = $githubUrl;
        $this->markAsUpdated();
    }

    // ========================================================================
    // MÉTHODES MÉTIER - Actions et comportements
    // ========================================================================

    /**
     * Publier le projet
     * Transition d'état : draft -> published
     *
     * @throws InvalidProjectDataException Si le projet n'est pas prêt
     */
    public function publish(): void
    {
        // Règle métier : Un projet doit avoir une image pour être publié
        if ($this->image === null) {
            throw new InvalidProjectDataException(
                'Cannot publish project without an image'
            );
        }

        $this->status = ProjectStatus::PUBLISHED;
        $this->markAsUpdated();
    }

    /**
     * Archiver le projet
     * Transition d'état : * -> archived
     */
    public function archive(): void
    {
        $this->status = ProjectStatus::ARCHIVED;
        $this->markAsUpdated();
    }

    /**
     * Restaurer le projet (dé-archiver)
     * Transition d'état : archived -> draft
     */
    public function restore(): void
    {
        if (!$this->status->isArchived()) {
            return; // Déjà restauré
        }

        $this->status = ProjectStatus::DRAFT;
        $this->markAsUpdated();
    }

    /**
     * Mettre en avant le projet sur la page d'accueil
     */
    public function feature(): void
    {
        $this->featured = true;
        $this->markAsUpdated();
    }

    /**
     * Retirer le projet de la mise en avant
     */
    public function unfeature(): void
    {
        $this->featured = false;
        $this->markAsUpdated();
    }

    /**
     * Changer l'ordre d'affichage
     */
    public function reorder(int $newOrder): void
    {
        if ($newOrder < 0) {
            throw new InvalidProjectDataException('Order must be positive');
        }

        $this->order = $newOrder;
        $this->markAsUpdated();
    }

    /**
     * Vérifier si le projet est publié
     */
    public function isPublished(): bool
    {
        return $this->status->isPublished();
    }

    /**
     * Vérifier si le projet est archivé
     */
    public function isArchived(): bool
    {
        return $this->status->isArchived();
    }

    /**
     * Vérifier si le projet est un brouillon
     */
    public function isDraft(): bool
    {
        return $this->status->isDraft();
    }

    // ========================================================================
    // VALIDATIONS PRIVÉES - Règles métier
    // ========================================================================

    /**
     * Valider le titre
     * Règle : 3-200 caractères
     */
    private function validateTitle(string $title): void
    {
        $length = mb_strlen(trim($title));

        if ($length < 3) {
            throw new InvalidProjectDataException(
                'Project title must be at least 3 characters long'
            );
        }

        if ($length > 200) {
            throw new InvalidProjectDataException(
                'Project title cannot exceed 200 characters'
            );
        }
    }

    /**
     * Valider la description
     * Règle : Minimum 20 caractères
     */
    private function validateDescription(string $description): void
    {
        $length = mb_strlen(trim($description));

        if ($length < 20) {
            throw new InvalidProjectDataException(
                'Project description must be at least 20 characters long'
            );
        }
    }

    /**
     * Valider les technologies
     * Règle : Au moins une technologie
     */
    private function validateTechnologies(array $technologies): void
    {
        if (empty($technologies)) {
            throw new InvalidProjectDataException(
                'Project must have at least one technology'
            );
        }

        // Vérifier que tous les éléments sont des chaînes non vides
        foreach ($technologies as $tech) {
            if (!is_string($tech) || trim($tech) === '') {
                throw new InvalidProjectDataException(
                    'All technologies must be non-empty strings'
                );
            }
        }
    }

    /**
     * Générer un slug à partir du titre
     * Utilitaire interne pour créer des URLs SEO-friendly
     */
    private static function generateSlug(string $title): string
    {
        // Convertir en minuscules
        $slug = mb_strtolower($title);

        // Remplacer les caractères spéciaux
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);

        // Supprimer les tirets en début et fin
        $slug = trim($slug, '-');

        return $slug;
    }

    /**
     * Marquer l'entité comme modifiée
     * Met à jour le timestamp de modification
     */
    private function markAsUpdated(): void
    {
        $this->updatedAt = new DateTime();
    }

    // ========================================================================
    // CONVERSION - Pour la persistance
    // ========================================================================

    /**
     * Convertir l'entité en tableau associatif
     * Utilisé par le repository pour la persistance
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'image' => $this->image,
            'technologies' => $this->technologies,
            'url' => $this->url?->getValue(),
            'github_url' => $this->githubUrl?->getValue(),
            'status' => $this->status->value,
            'featured' => $this->featured,
            'order' => $this->order,
            'created_at' => $this->createdAt->format('Y-m-d H:i:s'),
            'updated_at' => $this->updatedAt?->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * Créer une entité depuis un tableau
     * Pattern : Hydration
     * Utilisé par le repository lors de la récupération depuis la DB
     *
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            title: $data['title'],
            slug: $data['slug'],
            description: $data['description'],
            image: $data['image'] ?? null,
            technologies: $data['technologies'] ?? [],
            url: isset($data['url']) ? new Url($data['url']) : null,
            githubUrl: isset($data['github_url']) ? new Url($data['github_url']) : null,
            status: ProjectStatus::from($data['status'] ?? 'draft'),
            featured: $data['featured'] ?? false,
            order: $data['order'] ?? 0,
            createdAt: new DateTime($data['created_at'] ?? 'now'),
            updatedAt: isset($data['updated_at']) ? new DateTime($data['updated_at']) : null
        );
    }
}

