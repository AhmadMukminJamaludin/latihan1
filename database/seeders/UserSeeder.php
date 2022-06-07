<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
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
        $admin = User::create([
            'name' => 'admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin')
        ]);


        $user = User::create([
            'name' => 'author',
            'username' => 'author',
            'email' => 'author@gmail.com',
            'password' => Hash::make('author')
        ]);

        $admin->assignRole('admin');
        $user->assignRole('author');
    }
}
