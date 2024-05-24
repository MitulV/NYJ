<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'         => 1,
                'title'      => 'Dashboard',
                'created_at' => '2019-09-24 19:16:02',
                'updated_at' => '2019-09-24 19:16:02',
            ],
            [
                'id'         => 2,
                'title'      => 'Event_Management',
                'created_at' => '2019-09-24 19:16:02',
                'updated_at' => '2019-09-24 19:16:02',
            ],
            [
                'id'         => 3,
                'title'      => 'Category_Management',
                'created_at' => '2019-09-24 19:16:02',
                'updated_at' => '2019-09-24 19:16:02',
            ],
            [
                'id'         => 4,
                'title'      => 'City_Management',
                'created_at' => '2019-09-24 19:16:02',
                'updated_at' => '2019-09-24 19:16:02',
            ],
            [
                'id'         => 5,
                'title'      => 'Bookings',
                'created_at' => '2019-09-24 19:16:02',
                'updated_at' => '2019-09-24 19:16:02',
            ],
            [
                'id'         => 6,
                'title'      => 'My_Bookings',
                'created_at' => '2019-09-24 19:16:02',
                'updated_at' => '2019-09-24 19:16:02',
            ],

            [
                'id'         => 7,
                'title'      => 'User_Management',
                'created_at' => '2019-09-24 19:16:02',
                'updated_at' => '2019-09-24 19:16:02',
            ],
            
            [
                'id'         => 8,
                'title'      => 'Setting_access',
                'created_at' => '2019-09-24 19:16:02',
                'updated_at' => '2019-09-24 19:16:02',
            ],

            [
                'id'         => 9,
                'title'      => 'discount_code',
                'created_at' => '2019-09-24 19:16:02',
                'updated_at' => '2019-09-24 19:16:02',
            ],
            
            
        ];

        Permission::insert($permissions);
    }
}
