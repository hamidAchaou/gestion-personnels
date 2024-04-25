<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\GestionParametres\GradeSeeder;
use Database\Seeders\GestionParametres\MotifSeeder;
use Database\Seeders\GestionParametres\VilleSeeder;
use Database\Seeders\GestionParametres\FonctionSeeder;
use Database\Seeders\GestionParametres\AvancementSeeder;
use Database\Seeders\GestionParametres\SpecialiteSeeder;
use Database\Seeders\GestionParametres\EtablissementSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AvancementSeeder::class);
        $this->call(EtablissementSeeder::class);
        $this->call(FonctionSeeder::class);
        $this->call(GradeSeeder::class);
        $this->call(MotifSeeder::class);
        $this->call(SpecialiteSeeder::class);
        $this->call(VilleSeeder::class);
    }
}