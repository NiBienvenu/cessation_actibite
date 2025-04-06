<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CessationActiviteStoreRequest extends FormRequest
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
            'employe_id' => ['required', 'integer', 'exists:employes,id'],
            'date_entree' => ['required', 'date'],
            'date_sortie' => ['required', 'date'],
            'motif_id' => ['required', 'integer', 'exists:motifs,id'],
            'description' => ['required', 'string'],
            'user_id' => ['nullable', 'integer', 'exists:users,id'],
        ];
    }
}
