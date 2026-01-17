<?php

namespace App\Infrastructure\Storage;

use Illuminate\Http\UploadedFile;

/**
 * Service : Validation des fichiers uploadés
 *
 * Responsabilités :
 * - Valider les types de fichiers
 * - Vérifier les tailles
 * - Valider les dimensions d'images
 *
 * @package App\Infrastructure\Storage
 */
class FileUploadValidator
{
    /**
     * Types MIME autorisés pour les images
     */
    private const ALLOWED_IMAGE_MIMES = [
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/webp',
    ];

    /**
     * Taille maximale en octets (5 Mo)
     */
    private const MAX_FILE_SIZE = 5 * 1024 * 1024;

    /**
     * Dimensions minimales d'image
     */
    private const MIN_WIDTH = 400;
    private const MIN_HEIGHT = 300;

    /**
     * Valider une image uploadée
     *
     * @param UploadedFile $file
     * @return array ['valid' => bool, 'errors' => array]
     */
    public function validateImage(UploadedFile $file): array
    {
        $errors = [];

        // 1. Vérifier que le fichier est valide
        if (!$file->isValid()) {
            $errors[] = 'Le fichier est invalide ou corrompu.';
            return ['valid' => false, 'errors' => $errors];
        }

        // 2. Vérifier le type MIME
        if (!in_array($file->getMimeType(), self::ALLOWED_IMAGE_MIMES, true)) {
            $errors[] = 'Le type de fichier n\'est pas autorisé. Formats acceptés : JPEG, PNG, GIF, WebP.';
        }

        // 3. Vérifier la taille
        if ($file->getSize() > self::MAX_FILE_SIZE) {
            $maxSizeMb = self::MAX_FILE_SIZE / 1024 / 1024;
            $errors[] = "La taille du fichier ne doit pas dépasser {$maxSizeMb} Mo.";
        }

        // 4. Vérifier les dimensions
        $dimensions = @getimagesize($file->getRealPath());
        if ($dimensions !== false) {
            [$width, $height] = $dimensions;

            if ($width < self::MIN_WIDTH || $height < self::MIN_HEIGHT) {
                $errors[] = "Les dimensions de l'image doivent être d'au moins " .
                    self::MIN_WIDTH . "x" . self::MIN_HEIGHT . " pixels.";
            }
        } else {
            $errors[] = 'Impossible de lire les dimensions de l\'image.';
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors,
        ];
    }

    /**
     * Vérifier si un fichier est une image
     *
     * @param UploadedFile $file
     * @return bool
     */
    public function isImage(UploadedFile $file): bool
    {
        return in_array($file->getMimeType(), self::ALLOWED_IMAGE_MIMES, true);
    }

    /**
     * Obtenir la taille du fichier en format lisible
     *
     * @param UploadedFile $file
     * @return string Ex: "2.5 Mo"
     */
    public function getHumanReadableSize(UploadedFile $file): string
    {
        $bytes = $file->getSize();

        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' Mo';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' Ko';
        } else {
            return $bytes . ' octets';
        }
    }
}
