<?php
namespace App\Http\Requests\pkg_OrderDesMissions;

use Illuminate\Foundation\Http\FormRequest;

class MissionRequest extends FormRequest
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
            'nom' => 'required|max:40',
            'description' => 'nullable|max:255',
            'categorie_technologies_id' => 'required|not_in:null',
            'competence_id' => 'required|not_in:null',
        ];
    }


}