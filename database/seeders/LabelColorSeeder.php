<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LabelColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('labelcolors')->insert([
            ['color_name'=> 'wheat'],
            ['color_name'=> 'orange'],
            ['color_name'=> 'violet'],
            ['color_name'=> 'aqua'],
            ['color_name'=> 'deepskyblue'],
            ['color_name' => 'red'],
            ['color_name'=> 'rgb(25,135,84)'],
            ['color_name'=> 'rgb(255, 193, 7)'],
            ['color_name'=> 'rgb(108, 117, 125)'],
        ]);
    }
}
