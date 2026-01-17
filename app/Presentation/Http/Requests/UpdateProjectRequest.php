<?php

namespace App\Presentation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form Request : Modification d'un projet
 *
 * @package App\Presentation\Http\Requests
 */
class UpdateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'required', 'string', 'min:3', 'max:200'],
            'description' => ['sometimes', 'required', 'string', 'min:20'],
            'technologies' => ['sometimes', 'required', 'array', 'min:1'],
            'technologies.*' => ['string', 'max:50'],
            'url' => ['nullable', 'url', 'max:255'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
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
        if ($this->has('technologies') && is_string($this->technologies)) {
            $this->merge([
                'technologies' => array_filter(
                    array_map('trim', explode(',', $this->technologies))
                )
            ]);
        }

        if ($this->has('featured')) {
            $this->merge([
                'featured' => filter_var($this->featured, FILTER_VALIDATE_BOOLEAN)
            ]);
        }
    }
}
