<?php

namespace Database\Seeders\pkg_Parametres;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use App\Models\pkg_Parametres\Avancement;

class AvancementSeeder extends Seeder
{
    public function run(): void
    {

        // ==========================================================
        // ================= Add Seeder Avancements =================
        // ==========================================================
        Schema::disableForeignKeyConstraints();
        Avancement::truncate();
        Schema::enableForeignKeyConstraints();

        $csvFile = fopen(base_path("database/data/pkg_Parametres/avancements/Avancements.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($csvFile)) !== FALSE) {
            if (!$firstline) {
                Avancement::create([
                    "date_debut" => $data['0'],
                    "date_fin" => $data['1'],
                    "echell" => $data['2'],
                    "personnel_id" => $data['3'],
                ]);
            }
            $firstline = false;
        }
        fclose($csvFile);


        // ==========================================================
        // =========== Add Seeder Permission Assign Role ============
        // ==========================================================
        $csvFile = fopen(base_path("database/data/pkg_Parametres/avancements/AvancementsPermissions.csv"), "r");
        $firstLine = true;
        $adminRole = User::ADMIN;
        $responsableRole = User::RESPONSABLE;
        $roleAdmin = Role::where('name', $adminRole)->first();
        $roleResponsable = Role::where('name', $responsableRole)->first();

        while (($data = fgetcsv($csvFile)) !== false) {
            if (!$firstLine) {
                $permissionName = $data[0];
                $permissionGuardName = $data[1];

                // Find or create the permission
                Permission::firstOrCreate([
                    "name" => $permissionName,
                    "guard_name" => $permissionGuardName,
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
            }
            $firstLine = false;


           
        }

        fclose($csvFile);

    }
}