<?php

namespace App\Http\Requests\GestionConges;

use Illuminate\Foundation\Http\FormRequest;

class CreateCongeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Determine if the user is authorized to make this request.
        // Return true if they are authorized, or false if not.
        // You may add authorization logic here.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date_debut' => ['required', 'date'],
            'date_fin' => ['required', 'date', 'after_or_equal:date_debut'],
            'motif_id' => ['required', 'exists:motifs,id'],
            'user_id' => ['required', 'exists:users,id'],
        ];
    }

    /**
     * Define custom error messages for the validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'date_debut.required' => 'The start date is required.',
            'date_fin.required' => 'The end date is required.',
            'date_fin.after_or_equal' => 'The end date must be on or after the start date.',
            'motif_id.required' => 'The reason for leave is required.',
            'motif_id.exists' => 'The selected reason for leave is invalid.',
            'user_id.required' => 'The user ID is required.',
            'user_id.exists' => 'The selected user ID is invalid.',
            'jours_restants.required' => 'Remaining days are required.',
            'jours_restants.integer' => 'Remaining days must be an integer.',
            'jours_restants.min' => 'Remaining days cannot be negative.',
            // Add other custom error messages as needed.
        ];
    }
}
