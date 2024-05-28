<?php

namespace Database\Seeders\pkg_Parametres;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\pkg_Parametres\Grade;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // ==========================================================
        // ================= Add Seeder Avancements =================
        // ==========================================================
        Schema::disableForeignKeyConstraints();
        Grade::truncate();
        Schema::enableForeignKeyConstraints();

        $csvFile = fopen(base_path("database/data/pkg_Parametres/grades/Grades.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($csvFile)) !== FALSE) {
            if (!$firstline) {
                Grade::create([
                    "nom" => $data['0'],
                    "echell_debut" => $data['1'],
                    "echell_fin" => $data['2'],
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

        $csvFile = fopen(base_path("database/data/pkg_Parametres/grades/GradesPermissions.csv"), "r");
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