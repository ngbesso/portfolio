<?php

namespace App\Infrastructure\Storage;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

/**
 * Service : Gestion du stockage des images
 *
 * Responsabilités :
 * - Upload d'images
 * - Redimensionnement et optimisation
 * - Suppression d'anciennes images
 * - Génération de noms uniques
 *
 * Ce service fait partie de l'Infrastructure car il dépend
 * de packages externes (Storage facade, Intervention Image)
 *
 * @package App\Infrastructure\Storage
 */
class ImageStorageService
{
    /**
     * Dossier de stockage des images de projets
     */
    private const PROJECT_IMAGES_PATH = 'projects';

    /**
     * Largeur maximale des images
     */
    private const MAX_WIDTH = 1200;

    /**
     * Hauteur maximale des images
     */
    private const MAX_HEIGHT = 800;

    /**
     * Qualité JPEG (0-100)
     */
    private const JPEG_QUALITY = 85;

    /**
     * Upload et traiter une image de projet
     *
     * Flow :
     * 1. Générer un nom unique
     * 2. Redimensionner l'image
     * 3. Optimiser la qualité
     * 4. Sauvegarder dans le storage
     * 5. Retourner le chemin
     *
     * @param UploadedFile $file
     * @param string|null $oldImagePath Ancienne image à supprimer
     * @return string Chemin relatif de l'image sauvegardée
     */
    public function storeProjectImage(UploadedFile $file, ?string $oldImagePath = null): string
    {
        // 1. Supprimer l'ancienne image si elle existe
        if ($oldImagePath) {
            $this->deleteImage($oldImagePath);
        }

        // 2. Générer un nom unique
        $filename = $this->generateUniqueFilename($file);

        // 3. Créer le chemin complet
        $path = self::PROJECT_IMAGES_PATH . '/' . $filename;

        // 4. Traiter et optimiser l'image
        $image = Image::make($file);

        // Redimensionner si nécessaire (garde les proportions)
        if ($image->width() > self::MAX_WIDTH || $image->height() > self::MAX_HEIGHT) {
            $image->resize(self::MAX_WIDTH, self::MAX_HEIGHT, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize(); // Ne pas agrandir les petites images
            });
        }

        // 5. Encoder en JPEG avec compression
        $encodedImage = $image->encode('jpg', self::JPEG_QUALITY);

        // 6. Sauvegarder dans le storage (public disk)
        Storage::disk('public')->put($path, $encodedImage);

        // 7. Retourner le chemin relatif
        return $path;
    }

    /**
     * Supprimer une image
     *
     * @param string $path Chemin relatif de l'image
     * @return bool True si supprimée, false sinon
     */
    public function deleteImage(string $path): bool
    {
        if (!$path) {
            return false;
        }

        // Vérifier que le fichier existe avant de supprimer
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }

        return false;
    }

    /**
     * Obtenir l'URL publique d'une image
     *
     * @param string|null $path
     * @return string|null
     */
    public function getImageUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        return Storage::disk('public')->url($path);
    }

    /**
     * Vérifier si une image existe
     *
     * @param string $path
     * @return bool
     */
    public function imageExists(string $path): bool
    {
        return Storage::disk('public')->exists($path);
    }

    /**
     * Générer un nom de fichier unique
     *
     * Format : timestamp_random_extension
     * Exemple : 1703519234_a3f8b2c1.jpg
     *
     * @param UploadedFile $file
     * @return string
     */
    private function generateUniqueFilename(UploadedFile $file): string
    {
        $timestamp = time();
        $random = bin2hex(random_bytes(4)); // 8 caractères hexadécimaux
        $extension = $file->getClientOriginalExtension();

        return "{$timestamp}_{$random}.{$extension}";
    }

    /**
     * Obtenir la taille d'une image en Ko
     *
     * @param string $path
     * @return int|null Taille en Ko, null si l'image n'existe pas
     */
    public function getImageSize(string $path): ?int
    {
        if (!$this->imageExists($path)) {
            return null;
        }

        $sizeInBytes = Storage::disk('public')->size($path);
        return (int) ($sizeInBytes / 1024); // Convertir en Ko
    }

    /**
     * Nettoyer les images orphelines
     *
     * Supprimer les images qui ne sont plus référencées en base
     * Utile pour un nettoyage périodique (commande artisan)
     *
     * @param array $referencedPaths Chemins d'images encore utilisés
     * @return int Nombre d'images supprimées
     */
    public function cleanupOrphanedImages(array $referencedPaths): int
    {
        $allImages = Storage::disk('public')->files(self::PROJECT_IMAGES_PATH);
        $deletedCount = 0;

        foreach ($allImages as $imagePath) {
            // Si l'image n'est pas dans la liste des références
            if (!in_array($imagePath, $referencedPaths, true)) {
                Storage::disk('public')->delete($imagePath);
                $deletedCount++;
            }
        }

        return $deletedCount;
    }
}
