<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ✅ Nếu bảng chưa tồn tại thì bỏ qua (tránh fail trên môi trường mới)
        if (!Schema::hasTable('khachhang')) {
            return;
        }

        // ✅ Nếu bảng phanquyen chưa tồn tại thì cũng bỏ qua (FK tham chiếu)
        if (!Schema::hasTable('phanquyen')) {
            return;
        }

        Schema::table('khachhang', function (Blueprint $table) {
            // ✅ tránh add trùng nếu đã có constraint
            // Postgres không có hasForeign nên ta check theo cột là đủ cho đa số case
            if (Schema::hasColumn('khachhang', 'id_phanquyen')) {
                $table->foreign('id_phanquyen', 'fk_dk')
                      ->references('id_phanquyen')
                      ->on('phanquyen')
                      ->onDelete('restrict')
                      ->onUpdate('restrict');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('khachhang')) {
            return;
        }

        Schema::table('khachhang', function (Blueprint $table) {
            // ✅ drop theo tên constraint
            $table->dropForeign('fk_dk');
        });
    }
};
