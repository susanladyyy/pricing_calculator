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
        User::create([
            'university_id' => 1,
            'role_id' => 1,
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123'),
        ]);

        User::create([
            'university_id' => 1,
            'role_id' => 2,
            'username' => 'user',
            'email' => 'user@gmail.com',
            'password' => bcrypt('user123'),
        ]);

        User::create([
            'university_id' => 2,
            'role_id' => 2,
            'username' => 'user2',
            'email' => 'user2@gmail.com',
            'password' => bcrypt('user123'),
        ]);

        User::create([
            'university_id' => 2,
            'role_id' => 1,
            'username' => 'admin2',
            'email' => 'admin2@gmail.com',
            'password' => bcrypt('admin123'),
        ]);
    }
}
