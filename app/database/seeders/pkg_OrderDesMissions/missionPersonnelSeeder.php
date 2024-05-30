<?php

namespace Database\Seeders\pkg_OrderDesMissions;

use DateTime;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use App\Models\pkg_OrderDesMissions\Mission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MissionPersonnelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // ==========================================================
        // =================== Add Seeder Mission ===================
        // ==========================================================
        Schema::disableForeignKeyConstraints();
        Mission::truncate();
        Schema::enableForeignKeyConstraints();

        $csvFile = fopen(base_path("database/data/pkg_OrderDesMissions/missions/Missions.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($csvFile)) !== FALSE) {
            if (!$firstline) {
                Mission::create([
                    "nom" => $data[0],
                    "numero_mission" => $data[1],
                ]);
            }
            $firstline = false;
        }
        fclose($csvFile);

    }
}
