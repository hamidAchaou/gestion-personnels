<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class UserSeeder extends Seeder
{
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

        $adminUser = User::where("email", "admin@solicode.co")->first();
        if ($adminUser) {
            $adminUser->assignRole(User::ADMIN);
        }

        $responsableUser = User::where("email", "responsable@solicode.co")->first();
        if ($responsableUser) {
            $responsableUser->assignRole(User::RESPONSABLE);
        }
        // // ==========================================================
        // // =========== Add Seeder Permission Assign Role ============
        // // ==========================================================
        // $adminRole = User::ADMIN;
        // $responsableRole = User::RESPONSABLE;
        // $roleAdmin = Role::where('name', $adminRole)->first();
        // $roleResponsable = Role::where('name', $responsableRole)->first();
        // $adminUser = User::where('nom', $adminRole)->first();
        // $responsableUser = User::where('nom', $responsableRole)->first();
        // $adminUser->assignRole($adminRole);
        // $responsableUser->assignRole($adminRole);

        // Schema::disableForeignKeyConstraints();
        // Schema::enableForeignKeyConstraints();

        // $csvFile = fopen(base_path("database/data/pkg_PriseDeServices/personnels/PersonnelsPermissions.csv"), "r");
        // $firstline = true;
        // while (($data = fgetcsv($csvFile)) !== FALSE) {
        //     if (!$firstline) {
        //         Permission::create([
        //             "name" => $data['0'],
        //             "guard_name" => $data['1'],
        //         ]);

        //         if ($roleAdmin) {
        //             // If the role exists, update its permissions
        //             $roleAdmin->givePermissionTo($data['0']);
        //         } else {
        //             // If the role doesn't exist, create it and give permissions
        //             $roleAdmin = Role::create([
        //                 'name' => $adminRole,
        //                 'guard_name' => 'web',
        //             ]);
        //             $roleAdmin->givePermissionTo($data['0']);
        //         }
        //         // Only give specific permissions to the 'responsable' role
        //         if (in_array($data['0'], ['index-PersonnelController', 'show-PersonnelController', 'export-PersonnelController'])) {
        //             if ($roleResponsable) {
        //                 $roleResponsable->givePermissionTo($data['0']);
        //             } else {
        //                 $roleResponsable = Role::create([
        //                     'name' => $responsableRole,
        //                     'guard_name' => 'web',
        //                 ]);
        //                 $roleResponsable->givePermissionTo($data['0']);
        //             }
        //         }

        //     }
        //     $firstline = false;
        // }
        // fclose($csvFile);
    }
}
