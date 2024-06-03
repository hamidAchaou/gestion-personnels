<?php

namespace Database\Seeders\pkg_PriseDeServices;

use App\Models\pkg_PriseDeServices\Personnel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class PersonnelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        $csvFile = fopen(base_path("database/data/pkg_PriseDeServices/personnels/Personnels.csv"), "r");
        $firstline = true;

        while (($data = fgetcsv($csvFile)) !== FALSE) {
            if (!$firstline) {
                $existingPersonnel = Personnel::where('email', $data[2])->first();
                if (!$existingPersonnel) {
                    Personnel::create([
                        'prenom' => $data[0],
                        'nom' => $data[1],
                        'email' => $data[2],
                        'password' => $data[3],
                        'nom_arab' => $data[4],
                        'prenom_arab' => $data[5],
                        'cin' => $data[6],
                        'date_naissance' => $data[7],
                        'telephone' => $data[8],
                        'address' => $data[9],
                        'images' => $data[10],
                        'matricule' => $data[11],
                        'ville_id' => $data[12],
                        'fonction_id' => $data[13],
                        'ETPAffectation_id' => $data[14],
                        'grade_id' => $data[15],
                        'specialite_id' => $data[16],
                        'etablissement_id' => $data[17],
                        'avancement_id' => $data[18],
                        'created_at' => $data[19],
                        'updated_at' => $data[20],
                    ]);
                } else {
                    Log::info("Duplicate email found: " . $data[2]);
                }
            }
            $firstline = false;
        }

        fclose($csvFile);

        Schema::enableForeignKeyConstraints();
    }
}
