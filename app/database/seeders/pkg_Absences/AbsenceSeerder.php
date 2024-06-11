<?php

namespace Database\Seeders\pkg_Absences;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\pkg_Absences\Absence;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AbsenceSeerder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Absence::truncate();
        Schema::enableForeignKeyConstraints();

        $csvFile = fopen(base_path("database/data/pkg_Absences/Absences.csv"), "r");
        $firstline = true;

        while (($data = fgetcsv($csvFile)) !== FALSE) {
            if (!$firstline) {
                Absence::create([
                    'date_debut' => $data[0],
                    'date_fin' => $data[1],
                    'remarques' => $data[2],
                    'user_id' => $data[3],
                    'motif_id' => $data[4],
                    'created_at' => $data[5],
                    'updated_at' => $data[6],
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);



        // ==========================================================
        // =========== Add Seeder Permission Assign Role ============
        // ==========================================================

        $AdminRole = Role::where('name', User::ADMIN)->first();
        $ResponsableRole = Role::where('name', User::RESPONSABLE)->first();
        $csvFile = fopen(base_path("database/data/pkg_Absences/AbsencesPermissions.csv"), "r");
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

        // Assign the permissions from the file to the member
        $ResponsableRole->givePermissionTo($permissions);
    }
}
