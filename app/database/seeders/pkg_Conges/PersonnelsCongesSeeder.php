<?php

namespace Database\Seeders\pkg_Conges;

use App\Models\pkg_PriseDeServices\Personnel;
use Illuminate\Database\Seeder;

class PersonnelsCongesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {        
        Personnel::find(1)->conges()->attach(1);
        Personnel::find(2)->conges()->attach(2);
    }
}
