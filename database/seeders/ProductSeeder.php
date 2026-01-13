<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Thêm danh mục mẫu nếu chưa có
        DB::table('danhmuc')->updateOrInsert(
            ['id_danhmuc' => 1],
            ['tendanhmuc' => 'Thức ăn cho chó']
        );

        DB::table('danhmuc')->updateOrInsert(
            ['id_danhmuc' => 2],
            ['tendanhmuc' => 'Thức ăn cho mèo']
        );

        // Thêm sản phẩm mẫu
        DB::table('sanpham')->updateOrInsert(
            ['id_sanpham' => 1],
            [
                'tensp' => 'Thức ăn cho chó Pedigree',
                'anhsp' => '/upload/pedigree.jpg',
                'giasp' => 50000,
                'mota' => 'Thức ăn dinh dưỡng cho chó.',
                'giamgia' => 10,
                'giakhuyenmai' => 45000,
                'soluong' => 100,
                'id_danhmuc' => 1
            ]
        );

        DB::table('sanpham')->updateOrInsert(
            ['id_sanpham' => 2],
            [
                'tensp' => 'Thức ăn cho mèo Whiskas',
                'anhsp' => '/upload/whiskas.jpg',
                'giasp' => 40000,
                'mota' => 'Thức ăn ngon cho mèo.',
                'giamgia' => 5,
                'giakhuyenmai' => 38000,
                'soluong' => 80,
                'id_danhmuc' => 2
            ]
        );

        // Thêm thêm một số sản phẩm khác
        DB::table('sanpham')->updateOrInsert(
            ['id_sanpham' => 3],
            [
                'tensp' => 'Đồ chơi cho chó',
                'anhsp' => '/upload/toy.jpg',
                'giasp' => 20000,
                'mota' => 'Đồ chơi vui nhộn cho chó.',
                'giamgia' => 0,
                'giakhuyenmai' => 20000,
                'soluong' => 50,
                'id_danhmuc' => 1
            ]
        );
    }
}