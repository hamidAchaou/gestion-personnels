<?php

namespace App\Imports\pkg_PriseDeServices;

use App\Models\pkg_PriseDeServices\Personnel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PersonnelImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        if ($this->personnelExists($row)) {
            return null;
        }

        try {
            return new Personnel([
                'nom' => $row["nom"],
                'prenom' => $row["prenom"],
                'nom_arab' => $row["nom_arab"],
                'prenom_arab' => $row["prenom_arab"],
                'cin' => $row["cin"],
                'date_naissance' => $row["date_naissance"],
                'telephone' => $row["telephone"],
                'email' => $row["email"],
                'address' => $row["address"],
                'images' => $row["images"],
                'matricule' => $row["matricule"],
                'ville_id' => $row["ville_id"],
                'fonction_id' => $row["fonction_id"],
                'specialite_id' => $row["specialite_id"],
                'etablissement_id' => $row["etablissement_id"],
                'avancement_id' => $row["avancement_id"],
            ]);
        } catch (ValidationException $e) {
            return null; 
        } catch (\Exception $e) {
            
            return null; 
        }
    }

    private function personnelExists(array $row): bool
    {
    
        $existingTask = Personnel::where('email', $row['email'])
            ->exists();
        return $existingTask;
    }
 

}
