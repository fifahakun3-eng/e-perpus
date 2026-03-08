<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengembalian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peminjaman_id')->constrained('peminjaman')->onDelete('cascade');
            $table->date('tanggal_kembali_aktual');
            $table->unsignedInteger('hari_terlambat')->default(0);
            $table->unsignedBigInteger('denda_keterlambatan')->default(0); // Rp
            $table->unsignedBigInteger('denda_kondisi')->default(0);       // Rp
            $table->unsignedBigInteger('total_denda')->default(0);         // Rp
            $table->enum('kondisi_buku', ['baik', 'rusak_ringan', 'rusak_berat', 'hilang'])->default('baik');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengembalian');
    }
};