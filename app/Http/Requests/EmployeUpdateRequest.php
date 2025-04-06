<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeUpdateRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'matricule' => ['required', 'string'],
            'nom' => ['required', 'string'],
            'prenom' => ['required', 'string'],
            'genre' => ['required', 'string'],
            'adresse' => ['required', 'string'],
            'email' => ['required', 'email'],
            'profil' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'is_active' => ['required'],
            'location_id' => ['nullable', 'integer'],
            'fonction_id' => ['required', 'integer', 'exists:fonctions,id'],
            'direction_id' => ['required', 'integer', 'exists:directions,id'],
            'commissariat_id' => ['required', 'integer', 'exists:commissariats,id'],
            'application_id' => ['required', 'integer', 'exists:applications,id'],
        ];
    }
}
