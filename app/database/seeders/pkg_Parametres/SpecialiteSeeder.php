<?php

namespace Database\Seeders\pkg_Parametres;

use App\Models\pkg_Parametres\Specialite;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Schema;

class SpecialiteSeeder extends Seeder
{
    public function run(): void
    {

        // ==========================================================
        // ================= Add Seeder Avancements =================
        // ==========================================================
        Schema::disableForeignKeyConstraints();
        Specialite::truncate();
        Schema::enableForeignKeyConstraints();

        $csvFile = fopen(base_path("database/data/pkg_Parametres/specialites/Specialites.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($csvFile)) !== FALSE) {
            if (!$firstline) {
                Specialite::create([
                    "nom" => $data['0'],
                    "description" => $data['1'],
                ]);
            }
            $firstline = false;
        }
        fclose($csvFile);


        // ==========================================================
        // =========== Add Seeder Permission Assign Role ============
        // ==========================================================
        $adminRoleName = User::ADMIN; // Change this to match the role name in your database

        // Find or create the admin role
        $adminRole = Role::firstOrCreate([
            'name' => $adminRoleName,
            'guard_name' => 'web',
        ]);

        $csvFile = fopen(base_path("database/data/pkg_Parametres/specialites/SpecialitesPermissions.csv"), "r");
        $firstLine = true;

        while (($data = fgetcsv($csvFile)) !== false) {
            if (!$firstLine) {
                $permissionName = $data[0];
                $permissionGuardName = $data[1];

                // Find or create the permission
                $permission = Permission::firstOrCreate([
                    "name" => $permissionName,
                    "guard_name" => $permissionGuardName,
                ]);

                // Assign the permission to the admin role
                $adminRole->givePermissionTo($permission);
            }
            $firstLine = false;
        }

        fclose($csvFile);
    }
}