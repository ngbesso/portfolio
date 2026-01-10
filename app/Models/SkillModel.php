<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * Model Eloquent : Skill
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $category
 * @property string $level
 * @property string|null $icon
 * @property int $order
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon|null $updated_at
 */
class SkillModel extends Model
{
    protected $table = 'skills';

    protected $fillable = [
        'name',
        'slug',
        'category',
        'level',
        'icon',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'level' => 'intermediate',
        'order' => 0,
    ];

    // ========================================================================
    // SCOPES
    // ========================================================================

    /**
     * Scope : Par catégorie
     */
    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope : Ordonné
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc')
            ->orderBy('name', 'asc');
    }

    /**
     * Scope : Par niveau
     */
    public function scopeByLevel($query, string $level)
    {
        return $query->where('level', $level);
    }

    // ========================================================================
    // MÉTHODES UTILITAIRES
    // ========================================================================

    /**
     * Obtenir le pourcentage de maîtrise
     */
    public function getLevelPercentage(): int
    {
        return match($this->level) {
            'beginner' => 25,
            'intermediate' => 50,
            'advanced' => 75,
            'expert' => 100,
            default => 50,
        };
    }

    /**
     * Obtenir le libellé du niveau
     */
    public function getLevelLabel(): string
    {
        return match($this->level) {
            'beginner' => 'Débutant',
            'intermediate' => 'Intermédiaire',
            'advanced' => 'Avancé',
            'expert' => 'Expert',
            default => 'Intermédiaire',
        };
    }
}
