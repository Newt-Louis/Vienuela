<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BackgroundColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('background_colors')->insert([
            // Xanh + Hồng sáng + Vàng xanh lá
            ['bgcolor_name'=> 'linear-gradient(135deg, rgba(154,205,50,0.75), rgba(183,166,166,0.5), rgba(147,112,219,0.75))'],
            // Xanh lá + xanh marine + xanh đen
            ['bgcolor_name'=> 'linear-gradient(135deg, rgba(0,0,139,0.5), rgba(0,175,175,0.7), rgba(69,182,146,0.5))'],
            // Xanh + Tím + Hồng
            ['bgcolor_name'=> 'linear-gradient(135deg, rgba(0,0,255,0.5), rgba(138,43,226,0.5), rgba(238,130,238,0.5))'],
            // Cam, Cam nhạt, Bisque
            ['bgcolor_name'=> 'linear-gradient(135deg,rgba(255,80,0,0.7), rgba(233,150,122,0.7),rgba(255,228,196,0.7))'],
            // Đỏ, Đỏ nhạt, Đỏ cam
            ['bgcolor_name'=> 'linear-gradient(135deg, rgba(128,0,0,0.85), rgba(165,42,42,0.85), rgba(220,20,60,0.85))'],
            // xám nhạt, xám, xám đậm
            ['bgcolor_name' => 'linear-gradient(135deg, rgba(168,168,168,0.9), rgba(131,131,131,0.9), rgba(68,66,66,0.9))'],
            // xanh blue nhạt, xanh blue, xanh blue đậm
            ['bgcolor_name'=> 'linear-gradient(135deg, rgba(0,191,255,0.8), rgba(0,129,253,0.8), rgba(69,69,255,0.8))'],
            // Tím, Tím nhạt, Tím lợt
            ['bgcolor_name'=> 'linear-gradient(135deg, #c16cff, #d791ff, #e2c5fd)'],
        ]);
    }
}
