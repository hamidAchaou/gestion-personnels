<?php

namespace App\Imports\pkg_Absences;

use Carbon\Carbon;
use App\Models\pkg_Absences\Absence;
use App\Models\pkg_Parametres\Motif;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AbsencesImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // try {
        $filteredRow = [
            'matricule' => (int) $row['matricule'],
            'motif' => $row['motif'],
            'date_debut' => $row['date_debut'],
            'date_fin' => $row['date_fin'],
            'remarques' => $row['remarques'],
        ];

        $user_id = User::where('matricule', $filteredRow['matricule'])
            ->pluck('id')
            ->first();
        $motif_id = Motif::where('nom', $filteredRow['motif'])
            ->pluck('id')
            ->first();
        if (!$user_id || !$motif_id) {
            throw new \Exception('Invalid user_id or motif_id.');
        }
        $this->validate($filteredRow);
        return new Absence([
            'user_id' => $user_id,
            'motif_id' => $motif_id,
            'remarques' => $row['remarques'],
            'date_debut' => isset($row['date_debut']) ? Carbon::createFromFormat('Y-m-d', $row['date_debut'])->format('Y-m-d H:i:s') : null,
            'date_fin' => isset($row['date_fin']) ? Carbon::createFromFormat('Y-m-d', $row['date_fin'])->format('Y-m-d H:i:s') : null,
        ]);
        // } catch (\InvalidArgumentException $e) {
        //     return redirect()->route('project.index')->withError('Le symbole de séparation est introuvable. Pas assez de données disponibles pour satisfaire au format.');
        // }
        // catch (\ErrorException $e) {
        //     return redirect()->route('project.index')->withError('Quelque chose s\'est mal passé, vérifiez votre fichier');
        // }
    }

    private function validate(array $row)
    {
        $validator = Validator::make($row, [
            'date_debut' => 'required|date_format:Y-m-d|before_or_equal:date_fin',
            'date_fin' => 'required|date_format:Y-m-d|after_or_equal:date_debut',
            'remarques' => 'nullable|string',
            'matricule' => 'required|exists:users,matricule',
            'motif' => 'nullable|exists:motifs,nom',
        ]);

        // dd($validator);

        if ($validator->fails()) {
            $errorMessage = 'Les données fournies ne sont pas valides. Veuillez vérifier les erreurs ci-dessous et réessayer.';

            // Store the error message in the session
            session()->flash('error', $errorMessage);

            throw new \Illuminate\Validation\ValidationException($validator);
        }
    }
}
