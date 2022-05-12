<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\city;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        city::create(['name' => 'Vilnius']);
        city::create(['name' => 'Kaunas']);
        city::create(['name' => 'Kalaipėda']);
        city::create(['name' => 'Šiauliai']);
        city::create(['name' => 'Panevėžys']);
    }
}
