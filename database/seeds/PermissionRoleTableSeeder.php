<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    public function run()
    {
        $admin_permissions = Permission::whereIn('title', [
            'Dashboard',
            'Event_Management',
            'Category_Management',
            'City_Management',
            'Bookings',
            'User_Management'
        ])->get();

        Role::findOrFail(1)->permissions()->sync($admin_permissions->pluck('id'));

        $organizer_permissions = Permission::whereIn('title', [
            'Dashboard',
            'Event_Management',
            'Bookings'
        ])->get();

        Role::findOrFail(2)->permissions()->sync($organizer_permissions);

        $user_permissions = Permission::whereIn('title', ['My_Bookings'])->get();

        Role::findOrFail(3)->permissions()->sync($user_permissions);
    }
}
