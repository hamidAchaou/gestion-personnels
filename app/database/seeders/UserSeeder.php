<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Schema::disableForeignKeyConstraints();
        User::truncate();
        Schema::enableForeignKeyConstraints();

        $csvFile = fopen(base_path("database/data/Users.csv"), "r");
        $firstline = true;

        while (($data = fgetcsv($csvFile)) !== FALSE) {
            if (!$firstline) {
                User::create([
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
            }
            $firstline = false;
        }

        fclose($csvFile);

        // User::create([
        // User::create([
        //     'name' => 'admin',
        //     'nom' => User::ADMIN,
        //     'email' => 'admin@gmail.com',
        //     'prenom' => User::ADMIN,
        //     'password' => Hash::make('admin'),
        //     'email' => User::ADMIN . '@gmail.com',
        //     'password' => Hash::make(User::ADMIN),
        //     'created_at' => Carbon::now(),
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);
        // ])->assignRole(User::ADMIN);

        // User::create([
        //     'nom' => User::RESPOSABLE,
        //     'prenom' => User::RESPOSABLE,
        //     'email' => User::RESPOSABLE . '@gmail.com',
        //     'password' => Hash::make(User::RESPOSABLE),
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ])->assignRole(User::RESPOSABLE);
    }
}

