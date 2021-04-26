<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
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
                'name' => 'Pesapot Admin',
                'email' => 'admin@pesapot.com',
                'password' => 'admin@100',
                'is_admin' => true
            ],
            [
                'name' => 'Pesapot Admin',
                'email' => 'mmwangi@pesapot.com',
                'password' => 'mmwangi@100',
                'is_admin' => true
            ],
            [
                'name' => 'User One',
                'email' => 'user1@pesapot.com',
                'password' => 'user1@100',
                'is_admin' => false
            ],
        ];

        collect($users)->each(function ($user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => bcrypt($user['password']),
                'is_admin' => $user['is_admin']
            ]);
        });
    }
}
