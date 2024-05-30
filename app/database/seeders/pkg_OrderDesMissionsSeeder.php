<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Database\Seeders\pkg_OrderDesMissions\{
    MissionsSeeder,
    TransportsSeeder,
    MoyensTransportsSeeder,
};


class Pkg_OrderDesMissionsSeeder extends Seeder
{

    public function run(): void
    {
        $this->call(Pkg_OrderDesMissionsSeeder::Classes());
    }

    public static function Classes(): array
    {
        return [
            MissionsSeeder::class,
            TransportsSeeder::class,
            MoyensTransportsSeeder::class,
        ];
    }
}