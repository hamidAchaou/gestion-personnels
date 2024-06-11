<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
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
                $password = Hash::make($data[3]);
                User::create([
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
            $firstline = false; // Move this line inside the loop
            $firstline = false; // Move this line inside the loop
        }

        fclose($csvFile);

        // ==========================================================
        // =========== Add Seeder Permission Assign Role ============
        // ==========================================================
        $adminRole = User::ADMIN;
        $responsableRole = User::RESPONSABLE;
        $roleAdmin = Role::where('name', $adminRole)->first();
        $roleResponsable = Role::where('name', $responsableRole)->first();

        $adminUser = User::where("email", "admin@solicode.co")->first();
        if ($adminUser) {
            $adminUser->assignRole(User::ADMIN);
        }

        $responsableUser = User::where("email", "responsable@solicode.co")->first();
        if ($responsableUser) {
            $responsableUser->assignRole(User::RESPONSABLE);
        }
    }
}