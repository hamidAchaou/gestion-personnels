<?php

namespace Database\Seeders\pkg_Absences;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\pkg_Absences\JourFerie;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JourFerieSeerder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        JourFerie::truncate();
        Schema::enableForeignKeyConstraints();

        $csvFile = fopen(base_path("database/data/pkg_Absences/JourFeries.csv"), "r");
        $firstline = true;

        while (($data = fgetcsv($csvFile)) !== FALSE) {
            if (!$firstline) {
                JourFerie::create([
                    'annee_juridique_id' => $data[0],
                    'nom' => $data[1],
                    'date_debut' => $data[2],
                    'date_fin' => $data[3],
                    'is_formateur' => $data[4],
                    'is_administrateur' => $data[5],
                    'created_at' => $data[6],
                    'updated_at' => $data[7],
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);



        // ==========================================================
        // =========== Add Seeder Permission Assign Role ============
        // ==========================================================

        $AdminRole = Role::where('name', User::ADMIN)->first();
        $csvFile = fopen(base_path("database/data/pkg_Absences/JourFeriesPermissions.csv"), "r");
        $firstLine = true;
        $permissions = [];

        while (($data = fgetcsv($csvFile)) !== false) {
            if (!$firstLine) {
                $permissionName = $data[0];
                $permissionGuardName = $data[1];

                // Find or create the permission and add it to the array
                $permission = Permission::firstOrCreate([
                    "name" => $permissionName,
                    "guard_name" => $permissionGuardName,
                ]);

                $permissions[] = $permission;
            }
            $firstLine = false;
        }

        fclose($csvFile);

        // Assign the permissions from the file to the admin
        $AdminRole->givePermissionTo($permissions);

    }
}
