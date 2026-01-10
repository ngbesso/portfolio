<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model Eloquent : Contact
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $subject
 * @property string $message
 * @property \Carbon\Carbon|null $read_at
 * @property \Carbon\Carbon $created_at
 */
class ProjectModel extends Model
{
    protected $table = 'contacts';

    /**
     * Pas de updated_at pour les messages de contact
     */
    public const UPDATED_AT = null;

    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    // ========================================================================
    // SCOPES
    // ========================================================================

    /**
     * Scope : Messages non lus
     */
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    /**
     * Scope : Messages lus
     */
    public function scopeRead($query)
    {
        return $query->whereNotNull('read_at');
    }

    /**
     * Scope : Messages récents (dernières 24h)
     */
    public function scopeRecent($query)
    {
        return $query->where('created_at', '>=', now()->subDay());
    }

    /**
     * Scope : Ordre décroissant (plus récents d'abord)
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // ========================================================================
    // MÉTHODES UTILITAIRES
    // ========================================================================

    /**
     * Vérifier si le message est lu
     */
    public function isRead(): bool
    {
        return $this->read_at !== null;
    }

    /**
     * Vérifier si le message est récent (< 24h)
     */
    public function isRecent(): bool
    {
        return $this->created_at->isAfter(now()->subDay());
    }

    /**
     * Marquer comme lu
     */
    public function markAsRead(): void
    {
        if (!$this->isRead()) {
            $this->read_at = now();
            $this->save();
        }
    }

    /**
     * Marquer comme non lu
     */
    public function markAsUnread(): void
    {
        $this->read_at = null;
        $this->save();
    }
}
