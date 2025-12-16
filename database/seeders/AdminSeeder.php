<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Khachhang;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Khachhang::create([
            'hoten' => 'Admin',
            'email' => 'tritong392@gmail.com',
            'password' => Hash::make('tribro12'),
            'diachi' => 'Admin Address',
            'sdt' => '0123456789',
            'id_phanquyen' => 1,
        ]);
    }
}