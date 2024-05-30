<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


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
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);

        // ==========================================================
        // =========== Add Seeder Permission Assign Role ============
        // ==========================================================
        $adminRole = User::ADMIN;
        $responsableRole = User::RESPONSABLE;
        $roleAdmin = Role::where('name', $adminRole)->first();
        $roleResponsable = Role::where('name', $responsableRole)->first();

        Schema::disableForeignKeyConstraints();
        Schema::enableForeignKeyConstraints();

        $csvFile = fopen(base_path("database/data/pkg_PriseDeServices/personnels/PersonnelsPermissions.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($csvFile)) !== FALSE) {
            if (!$firstline) {
                Permission::create([
                    "name" => $data['0'],
                    "guard_name" => $data['1'],
                ]);

                if ($roleAdmin) {
                    // If the role exists, update its permissions
                    $roleAdmin->givePermissionTo($data['0']);
                } else {
                    // If the role doesn't exist, create it and give permissions
                    $roleAdmin = Role::create([
                        'name' => $adminRole,
                        'guard_name' => 'web',
                    ]);
                    $roleAdmin->givePermissionTo($data['0']);
                }
                // Only give specific permissions to the 'responsable' role
                if (in_array($data['0'], ['index-PersonnelController', 'show-PersonnelController', 'export-PersonnelController'])) {
                    if ($roleResponsable) {
                        $roleResponsable->givePermissionTo($data['0']);
                    } else {
                        $roleResponsable = Role::create([
                            'name' => $responsableRole,
                            'guard_name' => 'web',
                        ]);
                        $roleResponsable->givePermissionTo($data['0']);
                    }
                }

            }
            $firstline = false;
        }
        fclose($csvFile);
    }
}

