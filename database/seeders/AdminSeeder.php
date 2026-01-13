<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Khachhang;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // 1) tạo quyền admin nếu chưa có
        DB::table('phanquyen')->updateOrInsert(
            ['id_phanquyen' => 1],
            ['tenquyen' => 'Admin']
        );

        // 2) tạo admin nếu chưa có / update nếu đã có
        Khachhang::updateOrCreate(
            ['email' => 'tritong392@gmail.com'],
            [
                'hoten' => 'Admin',
                'password' => Hash::make('123'),
                'diachi' => 'Admin Address',
                'sdt' => '0123456789',
                'id_phanquyen' => 1,
            ]
        );
    }
}
