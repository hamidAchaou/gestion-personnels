<?php

namespace Database\Seeders\pkg_PriseDeServices;

use App\Models\pkg_PriseDeServices\Personnel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;

class PersonnelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Schema::disableForeignKeyConstraints();
        Schema::enableForeignKeyConstraints();

        $csvFile = fopen(base_path("database/data/pkg_PriseDeServices/personnels/Personnels.csv"), "r");
        $firstline = true;

        while (($data = fgetcsv($csvFile)) !== FALSE) {
            if (!$firstline) {
                $password = Hash::make($data[3]);
                Personnel::create([
                    'prenom' => $data[0],
                    'nom' => $data[1],
                    'email' => $data[2],
                    'password' => $password,
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
                    'specialite_id' => $data[15],
                    'etablissement_id' => $data[16],
                    'created_at' => $data[17],
                    'updated_at' => $data[18],
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);

    }
}

