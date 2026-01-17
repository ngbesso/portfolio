<?php

namespace App\Presentation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form Request : Validation du formulaire de contact
 *
 * Cette classe gère la validation côté présentation (Laravel).
 * La validation métier reste dans les entités et value objects.
 *
 * Principe de séparation :
 * - FormRequest : Validation des données HTTP (format, required, etc.)
 * - Entity/ValueObject : Validation des règles métier
 *
 * @package App\Presentation\Http\Requests
 */
class ContactFormRequest extends FormRequest
{
    /**
     * Déterminer si l'utilisateur est autorisé à faire cette requête
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // Tout le monde peut envoyer un message de contact
        return true;
    }

    /**
     * Règles de validation
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'email' => ['required', 'email:rfc,dns', 'max:254'],
            'subject' => ['required', 'string', 'min:5', 'max:200'],
            'message' => ['required', 'string', 'min:20', 'max:2000'],
        ];
    }

    /**
     * Messages d'erreur personnalisés
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Le nom est obligatoire.',
            'name.min' => 'Le nom doit contenir au moins 2 caractères.',
            'name.max' => 'Le nom ne peut pas dépasser 100 caractères.',

            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'L\'adresse email n\'est pas valide.',
            'email.max' => 'L\'adresse email ne peut pas dépasser 254 caractères.',

            'subject.required' => 'Le sujet est obligatoire.',
            'subject.min' => 'Le sujet doit contenir au moins 5 caractères.',
            'subject.max' => 'Le sujet ne peut pas dépasser 200 caractères.',

            'message.required' => 'Le message est obligatoire.',
            'message.min' => 'Le message doit contenir au moins 20 caractères.',
            'message.max' => 'Le message ne peut pas dépasser 2000 caractères.',
        ];
    }

    /**
     * Préparer les données pour la validation
     * Nettoyer et normaliser les données avant validation
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => trim($this->name ?? ''),
            'email' => strtolower(trim($this->email ?? '')),
            'subject' => trim($this->subject ?? ''),
            'message' => trim($this->message ?? ''),
        ]);
    }
}

