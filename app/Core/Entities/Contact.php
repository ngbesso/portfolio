<?php

namespace App\Core\Entities;

use App\Core\ValueObjects\Email;
use App\Core\Exceptions\InvalidContactDataException;
use DateTime;

/**
 * Entité Contact - Représente un message de contact
 *
 * @package App\Core\Entities
 */
class Contact
{
    public function __construct(
        private ?int $id,
        private string $name,
        private Email $email,
        private string $subject,
        private string $message,
        private ?DateTime $readAt,
        private DateTime $createdAt
    ) {
        $this->validateName($name);
        $this->validateSubject($subject);
        $this->validateMessage($message);
    }

    /**
     * Factory : Créer un nouveau message de contact
     */
    public static function create(
        string $name,
        Email $email,
        string $subject,
        string $message
    ): self {
        return new self(
            id: null,
            name: $name,
            email: $email,
            subject: $subject,
            message: $message,
            readAt: null,
            createdAt: new DateTime()
        );
    }

    // Getters
    public function getId(): ?int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getEmail(): Email { return $this->email; }
    public function getSubject(): string { return $this->subject; }
    public function getMessage(): string { return $this->message; }
    public function getReadAt(): ?DateTime { return $this->readAt; }
    public function getCreatedAt(): DateTime { return $this->createdAt; }

    // Méthodes métier

    /**
     * Marquer le message comme lu
     */
    public function markAsRead(): void
    {
        if ($this->isRead()) {
            return; // Déjà lu
        }

        $this->readAt = new DateTime();
    }

    /**
     * Marquer le message comme non lu
     */
    public function markAsUnread(): void
    {
        $this->readAt = null;
    }

    /**
     * Vérifier si le message a été lu
     */
    public function isRead(): bool
    {
        return $this->readAt !== null;
    }

    /**
     * Vérifier si le message est récent (moins de 24h)
     */
    public function isRecent(): bool
    {
        $now = new DateTime();
        $diff = $now->getTimestamp() - $this->createdAt->getTimestamp();
        return $diff < 86400; // 24 heures en secondes
    }

    // Validations

    /**
     * Valider le nom
     * Règle : 2-100 caractères
     */
    private function validateName(string $name): void
    {
        $length = mb_strlen(trim($name));
        if ($length < 2 || $length > 100) {
            throw new InvalidContactDataException(
                'Name must be between 2 and 100 characters'
            );
        }
    }

    /**
     * Valider le sujet
     * Règle : 5-200 caractères
     */
    private function validateSubject(string $subject): void
    {
        $length = mb_strlen(trim($subject));
        if ($length < 5 || $length > 200) {
            throw new InvalidContactDataException(
                'Subject must be between 5 and 200 characters'
            );
        }
    }

    /**
     * Valider le message
     * Règle : 20-2000 caractères
     */
    private function validateMessage(string $message): void
    {
        $length = mb_strlen(trim($message));
        if ($length < 20) {
            throw new InvalidContactDataException(
                'Message must be at least 20 characters long'
            );
        }
        if ($length > 2000) {
            throw new InvalidContactDataException(
                'Message cannot exceed 2000 characters'
            );
        }
    }

    // Conversion
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email->getValue(),
            'subject' => $this->subject,
            'message' => $this->message,
            'read_at' => $this->readAt?->format('Y-m-d H:i:s'),
            'created_at' => $this->createdAt->format('Y-m-d H:i:s'),
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            name: $data['name'],
            email: new Email($data['email']),
            subject: $data['subject'],
            message: $data['message'],
            readAt: isset($data['read_at']) ? new DateTime($data['read_at']) : null,
            createdAt: new DateTime($data['created_at'] ?? 'now')
        );
    }
}


