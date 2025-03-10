<?php

namespace App\Http\Requests;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CreateSaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'grid' => ['required', 'array'],
            'grid_size' => ['required', 'integer', 'min:10', 'max:50'],
            'update_speed' => ['required', 'integer', 'min:100', 'max:1000'],
            'neighbor_thresholds' => ['required', 'array'],
            'selected_color' => ['required', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'grid.required' => 'Le champ "Grille" est obligatoire.',
            'grid_size.required' => 'Le champ "Taille de la grille" est obligatoire.',
            'grid_size.min' => 'La taille de la grille doit être supérieure à 10.',
            'grid_size.max' => 'La taille de la grille doit être inférieure à 50.',
            'update_speed.required' => 'Le champ "Vitesse (ms)" est obligatoire.',
            'update_speed.min' => 'La vitesse doit être supérieure à 100.',
            'update_speed.max' => 'La vitesse doit être inférieure à 1000.',
            'neighbor_thresholds.required' => 'Le champ "Neighbor Thresholds" est obligatoire.',
            'selected_color.required' => 'Le champ "Couleur de sélection" est obligatoire.',
        ];
    }
}
