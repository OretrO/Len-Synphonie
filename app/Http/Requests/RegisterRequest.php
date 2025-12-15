<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Tout le monde peut s'inscrire
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8)
                    ->mixedCase() // Au moins une majuscule et une minuscule
                    ->numbers()   // Au moins un chiffre
            ],
            'avatar' => [
                'nullable',
                'image',
                'mimes:png,jpg,jpeg',
                'max:2048', // 2 Mo maximum
                'dimensions:max_width=512,max_height=512'
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Le nom d\'utilisateur est requis.',
            'name.unique' => 'Ce nom d\'utilisateur est déjà utilisé.',
            'email.required' => 'L\'adresse e-mail est requise.',
            'email.email' => 'L\'adresse e-mail doit être valide.',
            'email.unique' => 'Cette adresse e-mail est déjà associée à un compte.',
            'password.required' => 'Le mot de passe est requis.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'avatar.image' => 'L\'avatar doit être une image.',
            'avatar.mimes' => 'L\'avatar doit être au format PNG ou JPEG.',
            'avatar.max' => 'L\'avatar ne doit pas dépasser 2 Mo.',
            'avatar.dimensions' => 'L\'avatar ne doit pas dépasser 512x512 pixels.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'nom d\'utilisateur',
            'email' => 'adresse e-mail',
            'password' => 'mot de passe',
            'avatar' => 'avatar',
        ];
    }
}
