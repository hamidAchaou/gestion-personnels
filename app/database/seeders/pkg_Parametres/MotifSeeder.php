<?php

namespace Database\Seeders\pkg_Parametres;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\pkg_Parametres\Motif;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

class MotifSeeder extends Seeder
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
        Motif::truncate();
        Schema::enableForeignKeyConstraints();

        $csvFile = fopen(base_path("database/data/pkg_Parametres/motifs/Motifs.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($csvFile)) !== FALSE) {
            if (!$firstline) {
                Motif::create([
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

        $csvFile = fopen(base_path("database/data/pkg_Parametres/motifs/MotifsPermissions.csv"), "r");
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