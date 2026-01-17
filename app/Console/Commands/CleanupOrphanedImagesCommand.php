<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Infrastructure\Storage\ImageStorageService;
use App\Models\ProjectModel;

/**
 * Commande : Nettoyer les images orphelines
 *
 * Usage : php artisan images:cleanup
 */
class CleanupOrphanedImagesCommand extends Command
{
    protected $signature = 'images:cleanup';

    protected $description = 'Clean up orphaned project images that are no longer referenced';

    public function __construct(
        private readonly ImageStorageService $imageService
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $this->info('Starting orphaned images cleanup...');

        // Récupérer tous les chemins d'images référencés
        $referencedImages = ProjectModel::whereNotNull('image')
            ->pluck('image')
            ->toArray();

        $this->info('Found ' . count($referencedImages) . ' referenced images.');

        // Nettoyer les images orphelines
        $deletedCount = $this->imageService->cleanupOrphanedImages($referencedImages);

        if ($deletedCount > 0) {
            $this->info("✅ Deleted {$deletedCount} orphaned image(s).");
        } else {
            $this->info('✅ No orphaned images found.');
        }

        return Command::SUCCESS;
    }
}
