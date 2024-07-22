<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'id_role' => '1',
                'title_role' => 'Quản lý',
                'descript_role' => 'Đầy đủ chức năng tương tự user sở hữu WorkSpace +
                                    thêm thành viên vô WorkSpace hiện đang là thành viên
                                     và các thành viên còn lại.',
            ],
            [
                'id_role' => '2',
                'title_role' => 'Trưởng nhóm',
                'descript_role' => 'Là thành viên của 1 Board và đầy đủ chức năng +
                                    thêm thành viên vô trong Board + Card.',
            ],
            [
                'id_role' => '3',
                'title_role' => 'Thành viên',
                'descript_role' => 'Là thành viên của 1 Board và có chức năng thêm, sửa,
                                    không được xóa + thêm thành viên vô trong Card.',
            ],
        ]);
    }
}
