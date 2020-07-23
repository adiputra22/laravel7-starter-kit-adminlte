<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->delete();

        DB::table('users')->insert([
            'id' => 1,
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => null,
            'password' => bcrypt('admin123'),
            'remember_token' => null,
            'created_at' => '2020-06-04 13:42:19',
            'updated_at' => '2020-06-04 13:42:19'
        ]);
    }
}