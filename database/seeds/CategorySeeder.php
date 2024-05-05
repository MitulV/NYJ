<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Music'],
            ['name' => 'Sports'],
            ['name' => 'Business'],
            ['name' => 'Technology'],
            ['name' => 'Food & Drink'],
            ['name' => 'Arts'],
            ['name' => 'Fashion'],
            ['name' => 'Health'],
            ['name' => 'Education'],
            ['name' => 'Travel']
        ];
        
        Category::insert($categories);
    }
}
