<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'id' => '1',
                'name' => 'Admin',
                'username' => 'superadmin',
                'password' => '1',
                'role' => 'admin',
                'foto' => null,
            ]
        ];
        foreach ($users as $key => $user) {
            User::create($user);
        }
    }
}
