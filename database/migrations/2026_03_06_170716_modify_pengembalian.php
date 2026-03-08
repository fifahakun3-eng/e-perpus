<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengembalian', function (Blueprint $table) {
            // Status pembayaran denda (default lunas jika total_denda = 0)
            $table->enum('status_bayar', ['lunas', 'belum_lunas'])
                  ->default('belum_lunas')
                  ->after('total_denda');
            $table->date('tanggal_bayar')->nullable()->after('status_bayar');
        });

        // Set status_bayar = lunas untuk data yang total_denda = 0
        DB::statement("UPDATE pengembalian SET status_bayar = 'lunas' WHERE total_denda = 0");
    }

    public function down(): void
    {
        Schema::table('pengembalian', function (Blueprint $table) {
            $table->dropColumn(['status_bayar', 'tanggal_bayar']);
        });
    }
};