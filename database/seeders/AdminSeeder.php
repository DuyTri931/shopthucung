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
        // ✅ đảm bảo có quyền id = 1 trước (tránh lỗi FK)
        DB::table('phanquyen')->updateOrInsert(
            ['id_phanquyen' => 1],
            ['tenquyen' => 'Admin'] // nếu cột khác tên -> đổi lại
        );

        // ✅ tránh seed lại bị trùng email
        Khachhang::updateOrCreate(
            ['email' => 'tritong392@gmail.com'],
            [
                'hoten' => 'Admin',
                'password' => Hash::make('tribro12'),
                'diachi' => 'Admin Address',
                'sdt' => '0123456789',
                'id_phanquyen' => 1,
            ]
        );
    }
}
