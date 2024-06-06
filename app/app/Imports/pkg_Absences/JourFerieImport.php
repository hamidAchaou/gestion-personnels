<?php

namespace App\Imports\pkg_Absences;

use App\Models\pkg_Absences\JourFerie;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Validator;
use App\Models\pkg_Absences\AnneeJuridique;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class JourFerieImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $validatedData = $this->validate($row);

        // Create a new JourFerie instance with the validated data
        return new JourFerie([
            'annee_juridique_id' => $validatedData['annee_juridique_id'],
            'nom' => $validatedData['nom'],
            'is_formateur' => $validatedData['is_formateur'],
            'is_administrateur' => $validatedData['is_administrateur'],
            'date_debut' => $validatedData['date_debut'],
            'date_fin' => $validatedData['date_fin'],
        ]);
    }

    private function validate(array $row)
    {
        $validator = Validator::make($row, [
            'annee_juridique' => 'required|string',
            'nom' => 'required|string|max:255',
            'formateur' => 'required',
            'administrateur' => 'required',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
        ]);

        // Throw an exception if the validation fails
        if ($validator->fails()) {
            $errorMessage = 'Les données fournies ne sont pas valides. Veuillez vérifier les erreurs ci-dessous et réessayer.';

            // Store the error message in the session
            session()->flash('error', $errorMessage);

            throw new \Illuminate\Validation\ValidationException($validator);
        }

        // Get the validated data
        $validatedData = $validator->validated();

        // Find the ID of the annee_juridique based on the year
        $anneeJuridique = AnneeJuridique::where('annee', $validatedData['annee_juridique'])->first();

        // Add the annee_juridique_id to the validated data
        $validatedData['annee_juridique_id'] = $anneeJuridique->id;

        // Cast 'formateur' and 'administrateur' to boolean and rename them
        $validatedData['is_formateur'] = filter_var($validatedData['formateur'], FILTER_VALIDATE_BOOLEAN);
        $validatedData['is_administrateur'] = filter_var($validatedData['administrateur'], FILTER_VALIDATE_BOOLEAN);

        // Prepare the final array with only the required keys
        $finalData = [
            'annee_juridique_id' => $validatedData['annee_juridique_id'],
            'nom' => $validatedData['nom'],
            'is_formateur' => $validatedData['is_formateur'],
            'is_administrateur' => $validatedData['is_administrateur'],
            'date_debut' => $validatedData['date_debut'],
            'date_fin' => $validatedData['date_fin'],
        ];

        return $finalData;
    }
}
