<?php

namespace App\Presentation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form Request : Création d'un projet
 *
 * @package App\Presentation\Http\Requests
 */
class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Seuls les utilisateurs authentifiés peuvent créer des projets
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:3', 'max:200'],
            'description' => ['required', 'string', 'min:20'],
            'technologies' => ['required', 'array', 'min:1'],
            'technologies.*' => ['required', 'string', 'max:50'],
            'url' => ['nullable', 'url', 'max:255'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'], // 5MB
            'featured' => ['nullable', 'boolean'],
            'order' => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Le titre est obligatoire.',
            'title.min' => 'Le titre doit contenir au moins 3 caractères.',
            'title.max' => 'Le titre ne peut pas dépasser 200 caractères.',

            'description.required' => 'La description est obligatoire.',
            'description.min' => 'La description doit contenir au moins 20 caractères.',

            'technologies.required' => 'Au moins une technologie est requise.',
            'technologies.min' => 'Vous devez spécifier au moins une technologie.',

            'url.url' => 'L\'URL de démo doit être valide.',
            'github_url.url' => 'L\'URL GitHub doit être valide.',

            'image.image' => 'Le fichier doit être une image.',
            'image.mimes' => 'L\'image doit être au format : jpeg, png, jpg, gif ou webp.',
            'image.max' => 'L\'image ne peut pas dépasser 5 Mo.',
        ];
    }

    protected function prepareForValidation(): void
    {
        // Normaliser les données
        if ($this->has('technologies') && is_string($this->technologies)) {
            // Si technologies est une chaîne (ex: depuis un champ texte)
            $this->merge([
                'technologies' => array_filter(
                    array_map('trim', explode(',', $this->technologies))
                )
            ]);
        }

        // Convertir featured en boolean
        if ($this->has('featured')) {
            $this->merge([
                'featured' => filter_var($this->featured, FILTER_VALIDATE_BOOLEAN)
            ]);
        }
    }
}
