<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Interfaces (Core)
use App\Core\Repositories\ProjectRepositoryInterface;
use App\Core\Repositories\SkillRepositoryInterface;
use App\Core\Repositories\ContactRepositoryInterface;

// Implémentations (Infrastructure)
use App\Infrastructure\Repositories\EloquentProjectRepository;
use App\Infrastructure\Repositories\EloquentSkillRepository;
use App\Infrastructure\Repositories\EloquentContactRepository;

/**
 * Service Provider : Binding des Repositories
 *
 * Ce provider configure l'Inversion de Dépendance (Dependency Inversion).
 *
 * Principe SOLID (D) :
 * - Les Use Cases dépendent des INTERFACES (Core)
 * - Ce provider bind les interfaces vers les IMPLEMENTATIONS (Infrastructure)
 * - Le code métier ne connaît jamais Eloquent directement
 *
 * Avantages :
 * - Testabilité : On peut facilement créer des mocks
 * - Flexibilité : On peut changer d'implémentation sans toucher au Core
 * - Clean Architecture : Respect de la règle de dépendance
 *
 * @package App\Providers
 */
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Enregistrer les bindings dans le conteneur d'injection de dépendances
     *
     * Quand Laravel résout une interface, il utilise l'implémentation bindée ici.
     *
     * Exemple :
     * Quand un Use Case demande ProjectRepositoryInterface,
     * Laravel injecte automatiquement EloquentProjectRepository
     */
    public function register(): void
    {
        // Binding : ProjectRepositoryInterface → EloquentProjectRepository
        $this->app->bind(
            ProjectRepositoryInterface::class,
            EloquentProjectRepository::class
        );

        // Binding : SkillRepositoryInterface → EloquentSkillRepository
        $this->app->bind(
            SkillRepositoryInterface::class,
            EloquentSkillRepository::class
        );

        // Binding : ContactRepositoryInterface → EloquentContactRepository
        $this->app->bind(
            ContactRepositoryInterface::class,
            EloquentContactRepository::class
        );
    }

    /**
     * Bootstrap des services (optionnel)
     *
     * Exécuté après le register de tous les providers
     */
    public function boot(): void
    {
        //
    }
}
