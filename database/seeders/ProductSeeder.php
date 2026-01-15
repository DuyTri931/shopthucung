<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // ====== DANH MỤC (theo ảnh) ======
        $categories = [
            ['id_danhmuc' => 1, 'ten_danhmuc' => 'Sản phẩm cho chó'],
            ['id_danhmuc' => 2, 'ten_danhmuc' => 'Sản phẩm cho mèo'],
            ['id_danhmuc' => 3, 'ten_danhmuc' => 'tất cả sản phẩm'],
            ['id_danhmuc' => 4, 'ten_danhmuc' => 'con giống'],
            ['id_danhmuc' => 5, 'ten_danhmuc' => 'nổi bật'],
            ['id_danhmuc' => 6, 'ten_danhmuc' => 'chó giống'],
            ['id_danhmuc' => 7, 'ten_danhmuc' => 'mèo giống'],
        ];

        foreach ($categories as $c) {
            DB::table('danhmuc')->updateOrInsert(
                ['id_danhmuc' => $c['id_danhmuc']],
                ['ten_danhmuc' => $c['ten_danhmuc']]
            );
        }

        // ====== SẢN PHẨM (theo ảnh bảng sanpham) ======
        $products = [
            [
                'id_sanpham' => 1,
                'tensp' => 'Thức Ăn Cho Chó Trưởng Thành Giống Lớn Eminent A...',
                'anhsp' => '/frontend/upload/dVvckCrzbX1QWM74rrDMrCdgmd2xcUYBRUKkG1uq.jpg',
                'giasp' => 72000,
                'mota' => null,
                'giamgia' => 0,
                'giakhuyenmai' => 72000,
                'soluong' => 2,
                'id_danhmuc' => 1,
            ],
            [
                'id_sanpham' => 2,
                'tensp' => 'Pate Cho Mèo  Pate Fit4 Cats - Cá Ngừ Và Thanh...',
                'anhsp' => '/frontend/upload/fit4cats-2.jpg',
                'giasp' => 20000,
                'mota' => null,
                'giamgia' => 0,
                'giakhuyenmai' => 20000,
                'soluong' => 5,
                'id_danhmuc' => 2,
            ],
            [
                'id_sanpham' => 4,
                'tensp' => 'Cheems',
                'anhsp' => '/frontend/upload/meme-cheems-1.png',
                'giasp' => 20000,
                'mota' => null,
                'giamgia' => 0,
                'giakhuyenmai' => 20000,
                'soluong' => 2,
                'id_danhmuc' => 6,
            ],
            [
                'id_sanpham' => 5,
                'tensp' => 'Chó chihuahua',
                'anhsp' => '/frontend/upload/Chó-chi-hua-hua.jpg',
                'giasp' => 20000,
                'mota' => null,
                'giamgia' => 0,
                'giakhuyenmai' => 20000,
                'soluong' => 3,
                'id_danhmuc' => 6,
            ],
            [
                'id_sanpham' => 6,
                'tensp' => 'Bánh Gặm Cho Chó – Smoked Beefy Dental Bone -14g',
                'anhsp' => '/frontend/upload/dochocho1.jpg',
                'giasp' => 20000,
                'mota' => null,
                'giamgia' => 0,
                'giakhuyenmai' => 20000,
                'soluong' => 6,
                'id_danhmuc' => 1,
            ],
            [
                'id_sanpham' => 10,
                'tensp' => 'Hạt Smartehart Gold Puppy- Dành cho chó con & chó ...',
                'anhsp' => '/frontend/upload/smartheart-10.jpg',
                'giasp' => 30000,
                'mota' => 'uy tín',
                'giamgia' => 50,
                'giakhuyenmai' => 15000,
                'soluong' => 5,
                'id_danhmuc' => 1,
            ],
            [
                'id_sanpham' => 11,
                'tensp' => 'Pate gói dành cho mèo',
                'anhsp' => '/frontend/upload/pate-goi-11.jpg',
                'giasp' => 50000,
                'mota' => null,
                'giamgia' => 12,
                'giakhuyenmai' => 44000,
                'soluong' => 4,
                'id_danhmuc' => 2,
            ],
            [
                'id_sanpham' => 12,
                'tensp' => 'Hạt Reflex Plus Adult Cat Food Urinary 1.5Kg hỗ tr...',
                'anhsp' => '/frontend/upload/reflex-12.jpg',
                'giasp' => 30000,
                'mota' => null,
                'giamgia' => 13,
                'giakhuyenmai' => 26100,
                'soluong' => 3,
                'id_danhmuc' => 2,
            ],
            [
                'id_sanpham' => 14,
                'tensp' => 'Snack thịt vịt sấy Natural Core dạng thanh cho chó...',
                'anhsp' => '/frontend/upload/dVvckCrzbX1QWM74rrDMrCdgmd2xcUYBRUKkG1uq.jpg',
                'giasp' => 30000,
                'mota' => null,
                'giamgia' => 10,
                'giakhuyenmai' => 27000,
                'soluong' => 7,
                'id_danhmuc' => 1,
            ],
            [
                'id_sanpham' => 15,
                'tensp' => 'Pate cho chó Gran-Deli dạng thạch 80 Gr',
                'anhsp' => '/frontend/upload/gran-deli-15.jpg',
                'giasp' => 60000,
                'mota' => null,
                'giamgia' => 8,
                'giakhuyenmai' => 55200,
                'soluong' => 3,
                'id_danhmuc' => 2,
            ],
            [
                'id_sanpham' => 16,
                'tensp' => 'Ức Gà Sấy Khô Dạng Miếng 50g Cho Chó Mèo – Thưởng ...',
                'anhsp' => '/frontend/upload/uc-ga-16.jpg', // sửa // thành /
                'giasp' => 25000,
                'mota' => null,
                'giamgia' => 3,
                'giakhuyenmai' => 24250,
                'soluong' => 2,
                'id_danhmuc' => 2,
            ],
            [
                'id_sanpham' => 17,
                'tensp' => 'Thức ăn hạt Captain Wang Wang cho chó',
                'anhsp' => '/frontend/upload/captain-17.jpg',
                'giasp' => 250000,
                'mota' => null,
                'giamgia' => 3,
                'giakhuyenmai' => 242500,
                'soluong' => 4,
                'id_danhmuc' => 1,
            ],
            [
                'id_sanpham' => 18,
                'tensp' => 'Cleopatra',
                'anhsp' => '/frontend/upload/cleopatra-18.jpg',
                'giasp' => 2000000,
                'mota' => null,
                'giamgia' => 40,
                'giakhuyenmai' => 1200000,
                'soluong' => 4,
                'id_danhmuc' => 6,
            ],
            [
                'id_sanpham' => 19,
                'tensp' => 'Archie',
                'anhsp' => '/frontend/upload/archie-19.jpg',
                'giasp' => 400000,
                'mota' => null,
                'giamgia' => null,
                'giakhuyenmai' => 400000,
                'soluong' => 1,
                'id_danhmuc' => 6,
            ],
            [
                'id_sanpham' => 20,
                'tensp' => 'shiba',
                'anhsp' => '/frontend/upload/shiba-20.jpg',
                'giasp' => 400000,
                'mota' => null,
                'giamgia' => 45,
                'giakhuyenmai' => 220000,
                'soluong' => 6,
                'id_danhmuc' => 6,
            ],
        ];

        // ✅ THÊM ĐOẠN NÀY: XOÁ SẢN PHẨM DƯ ("Đồ chơi cho chó" id=3) HOẶC XOÁ HẾT SẢN PHẨM KHÔNG NẰM TRONG LIST
        $keepIds = array_column($products, 'id_sanpham');

        // Option an toàn: xoá đúng id=3
        DB::table('sanpham')->where('id_sanpham', 3)->delete();

        // Option mạnh: chỉ giữ đúng các id trong ảnh (bật nếu bạn muốn sạch sẽ tuyệt đối)
        DB::table('sanpham')->whereNotIn('id_sanpham', $keepIds)->delete();

        // ====== UPSERT SẢN PHẨM ======
        foreach ($products as $p) {
            $id = $p['id_sanpham'];
            $data = $p;
            unset($data['id_sanpham']);

            DB::table('sanpham')->updateOrInsert(
                ['id_sanpham' => $id],
                $data
            );
        }
    }
}
