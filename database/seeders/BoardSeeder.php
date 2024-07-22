<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BoardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('boards')->insert([
            'id_workspace' => '1',
            'title_board' => 'admin_test_board',
            'id_bgcolor' => '6',
        ]);
    }
}
