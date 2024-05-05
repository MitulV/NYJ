<?php

use App\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            ['name' => 'Mumbai'],
            ['name' => 'Delhi'],
            ['name' => 'Bangalore'],
            ['name' => 'Hyderabad']
        ];

        City::insert($cities);
        
    }
}
