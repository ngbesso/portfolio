<?php

namespace App\Core\Entities;

use App\Core\ValueObjects\SkillLevel;
use App\Core\Exceptions\InvalidSkillDataException;
use DateTime;

/**
 * Entité Skill - Représente une compétence technique
 *
 * @package App\Core\Entities
 */
class Skill
{
    public function __construct(
        private ?int $id,
        private string $name,
        private string $slug,
        private string $category,
        private SkillLevel $level,
        private ?string $icon,
        private int $order,
        private DateTime $createdAt,
        private ?DateTime $updatedAt = null
    ) {
        $this->validateName($name);
        $this->validateCategory($category);
    }

    /**
     * Factory : Créer une nouvelle compétence
     */
    public static function create(
        string $name,
        string $category,
        SkillLevel $level
    ): self {
        return new self(
            id: null,
            name: $name,
            slug: self::generateSlug($name),
            category: $category,
            level: $level,
            icon: null,
            order: 0,
            createdAt: new DateTime()
        );
    }

    // Getters
    public function getId(): ?int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getSlug(): string { return $this->slug; }
    public function getCategory(): string { return $this->category; }
    public function getLevel(): SkillLevel { return $this->level; }
    public function getIcon(): ?string { return $this->icon; }
    public function getOrder(): int { return $this->order; }
    public function getCreatedAt(): DateTime { return $this->createdAt; }
    public function getUpdatedAt(): ?DateTime { return $this->updatedAt; }

    // Méthodes métier
    public function updateName(string $name): void
    {
        $this->validateName($name);
        $this->name = $name;
        $this->slug = self::generateSlug($name);
        $this->markAsUpdated();
    }

    public function updateCategory(string $category): void
    {
        $this->validateCategory($category);
        $this->category = $category;
        $this->markAsUpdated();
    }

    public function updateLevel(SkillLevel $level): void
    {
        $this->level = $level;
        $this->markAsUpdated();
    }

    public function setIcon(string $icon): void
    {
        $this->icon = $icon;
        $this->markAsUpdated();
    }

    public function reorder(int $newOrder): void
    {
        if ($newOrder < 0) {
            throw new InvalidSkillDataException('Order must be positive');
        }
        $this->order = $newOrder;
        $this->markAsUpdated();
    }

    // Validations
    private function validateName(string $name): void
    {
        $length = mb_strlen(trim($name));
        if ($length < 2 || $length > 50) {
            throw new InvalidSkillDataException(
                'Skill name must be between 2 and 50 characters'
            );
        }
    }

    private function validateCategory(string $category): void
    {
        $length = mb_strlen(trim($category));
        if ($length < 2 || $length > 50) {
            throw new InvalidSkillDataException(
                'Category must be between 2 and 50 characters'
            );
        }
    }

    private static function generateSlug(string $name): string
    {
        $slug = mb_strtolower($name);
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
        return trim($slug, '-');
    }

    private function markAsUpdated(): void
    {
        $this->updatedAt = new DateTime();
    }

    // Conversion
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'category' => $this->category,
            'level' => $this->level->value,
            'icon' => $this->icon,
            'order' => $this->order,
            'created_at' => $this->createdAt->format('Y-m-d H:i:s'),
            'updated_at' => $this->updatedAt?->format('Y-m-d H:i:s'),
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            name: $data['name'],
            slug: $data['slug'],
            category: $data['category'],
            level: SkillLevel::from($data['level']),
            icon: $data['icon'] ?? null,
            order: $data['order'] ?? 0,
            createdAt: new DateTime($data['created_at'] ?? 'now'),
            updatedAt: isset($data['updated_at']) ? new DateTime($data['updated_at']) : null
        );
    }
}


