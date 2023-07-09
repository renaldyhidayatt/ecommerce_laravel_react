<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Create_Role_USer extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('role_user')->insert([
            'role_id' => 1, // ID role yang ingin dihubungkan
            'user_id' => 1, // ID user yang ingin dihubungkan
        ]);

        DB::table('role_user')->insert([
            'role_id' => 2, // ID role yang ingin dihubungkan
            'user_id' => 2, // ID user yang ingin dihubungkan
        ]);
    }
}
