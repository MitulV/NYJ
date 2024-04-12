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
            ['name' => 'Hyderabad'],
            ['name' => 'Ahmedabad'],
            ['name' => 'Chennai'],
            ['name' => 'Kolkata'],
            ['name' => 'Surat'],
            ['name' => 'Pune'],
            ['name' => 'Jaipur'],
            ['name' => 'Lucknow'],
            ['name' => 'Kanpur'],
            ['name' => 'Nagpur'],
            ['name' => 'Indore'],
            ['name' => 'Thane'],
            ['name' => 'Bhopal'],
            ['name' => 'Visakhapatnam'],
            ['name' => 'Patna'],
            ['name' => 'Vadodara'],
            ['name' => 'Ghaziabad']
        ];

        City::insert($cities);
        
    }
}
