<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Create_User extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'firstname' => 'John',
            'lastname' => 'Doe',
            'image' => 'user.jpg',
            'email' => 'john@example.com',
            'role_id' => 1, // ID role sesuai dengan data yang ada di tabel 'roles'
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'firstname' => 'Jane',
            'lastname' => 'Smith',
            'image' => 'user.jpg',
            'email' => 'jane@example.com',
            'role_id' => 2, // ID role sesuai dengan data yang ada di tabel 'roles'
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
