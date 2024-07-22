<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'account_user' => 'admin',
                'name_user' => 'Admin',
                'email_user' => 'admin@gmail.com',
                'phone_user' => '0123456789',
                'password_user' => Hash::make('123456'),
            ],
            [
                'account_user' => 'admin2',
                'name_user' => 'Admin2',
                'email_user' => 'admin2@gmail.com',
                'phone_user' => '1234567890',
                'password_user' => Hash::make('123456'),
            ],
            [
                'account_user' => 'admin3',
                'name_user' => 'Admin3',
                'email_user' => 'admin3@gmail.com',
                'phone_user' => '1234567809',
                'password_user' => Hash::make('123456'),
            ],
            [
                'account_user' => 'admin4',
                'name_user' => 'Admin4',
                'email_user' => 'admin4@gmail.com',
                'phone_user' => '1023456789',
                'password_user' => Hash::make('123456'),
            ],
            ]);
    }
}
