<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'username' => 'user1@gmail.com',
                'password' => bcrypt('123123'),
                'created_at' => date('Y-m-d H:i:s')
            ],[
                'username' => 'user2@gmail.com',
                'password' => bcrypt('123123'),
                'created_at' => date('Y-m-d H:i:s')
            ],[
                'username' => 'user3@gmail.com',
                'password' => bcrypt('123123'),
                'created_at' => date('Y-m-d H:i:s')
            ],
        ]);
    }
}