<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * Model Eloquent : Project
 *
 * Ce model fait partie de la couche Infrastructure.
 * Il NE contient PAS de logique métier.
 * Il sert uniquement d'interface avec la base de données.
 *
 * La logique métier est dans l'entité App\Core\Entities\Project
 *
 * Principe : Séparation entre persistance (Model) et métier (Entity)
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property string|null $image
 * @property array $technologies
 * @property string|null $url
 * @property string|null $github_url
 * @property string $status
 * @property bool $featured
 * @property int $order
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon|null $updated_at
 */
class ProjectModel extends Model
{
    /**
     * Nom de la table
     */
    protected $table = 'projects';

    /**
     * Attributs assignables en masse
     *
     * Protection contre les mass assignment attacks
     */
    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'technologies',
        'url',
        'github_url',
        'status',
        'featured',
        'order',
    ];

    /**
     * Casting des attributs
     *
     * Automatic conversion des types lors de la récupération/sauvegarde
     */
    protected $casts = [
        'technologies' => 'array',      // JSON → array PHP
        'featured' => 'boolean',        // 0/1 → true/false
        'order' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Valeurs par défaut
     */
    protected $attributes = [
        'status' => 'draft',
        'featured' => false,
        'order' => 0,
    ];

    // ========================================================================
    // SCOPES - Requêtes réutilisables
    // ========================================================================

    /**
     * Scope : Projets publiés uniquement
     *
     * Usage : ProjectModel::published()->get()
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope : Projets featured
     *
     * Usage : ProjectModel::featured()->limit(3)->get()
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true)
            ->where('status', 'published');
    }

    /**
     * Scope : Ordonné pour l'affichage
     *
     * Usage : ProjectModel::ordered()->get()
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc')
            ->orderBy('created_at', 'desc');
    }

    /**
     * Scope : Par statut
     *
     * Usage : ProjectModel::byStatus('published')->get()
     */
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    // ========================================================================
    // ACCESSORS - Transformation des données en lecture
    // ========================================================================

    /**
     * Accessor : URL complète de l'image
     *
     * Transforme le chemin relatif en URL complète
     * Usage : $project->image_url
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->image
                ? asset('storage/' . $this->image)
                : null
        );
    }

    /**
     * Accessor : Extrait des technologies
     *
     * Retourne les 3 premières technologies pour l'affichage en carte
     * Usage : $project->main_technologies
     */
    protected function mainTechnologies(): Attribute
    {
        return Attribute::make(
            get: fn () => array_slice($this->technologies ?? [], 0, 3)
        );
    }

    // ========================================================================
    // MÉTHODES UTILITAIRES
    // ========================================================================

    /**
     * Vérifier si le projet est publié
     */
    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    /**
     * Vérifier si le projet est archivé
     */
    public function isArchived(): bool
    {
        return $this->status === 'archived';
    }

    /**
     * Vérifier si le projet est un brouillon
     */
    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }
}
