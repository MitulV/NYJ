<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
  public function run()
  {
    $users = [
      [
        'id'             => 1,
        'name'           => 'Admin',
        'email'          => 'nyjtickets@yahoo.com',
        'password'       => '$2y$10$dm/PoPKtXM2s25GJeeWPduzo1GUJNjtfLrUwdQKcc4DueMNtafY9O', //Welcome@123
        'remember_token' => null,
        'created_at'     => '2019-09-24 19:16:02',
        'updated_at'     => '2019-09-24 19:16:02',
      ],
    ];

    User::insert($users);
  }
}
