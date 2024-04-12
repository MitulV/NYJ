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
            ['name' => 'Travel'],
            ['name' => 'Family'],
            ['name' => 'Community'],
            ['name' => 'Film & Media'],
            ['name' => 'Government'],
            ['name' => 'Hobbies'],
            ['name' => 'Science & Tech'],
            ['name' => 'Charity & Causes'],
            ['name' => 'Religion'],
            ['name' => 'Auto, Boat & Air'],
            ['name' => 'Home & Lifestyle']
        ];
        
        Category::insert($categories);
    }
}
