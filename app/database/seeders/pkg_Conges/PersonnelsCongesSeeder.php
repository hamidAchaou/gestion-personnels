<?php

namespace Database\Seeders\pkg_Conges;

use App\Models\GestionPersonnels\Personnel;
use App\Models\User;
use Illuminate\Database\Seeder;

class PersonnelsCongesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {        
        User::find(1)->conges()->attach(1);
        User::find(2)->conges()->attach(2);
    }
}
