<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel anggota
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            // Relasi ke tabel buku
            $table->foreignId('buku_id')
                ->constrained('bukus')
                ->onDelete('cascade');

            // Tanggal peminjaman
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali');

            // Akan diisi saat dikembalikan
            $table->date('tanggal_dikembalikan')->nullable();

            // Untuk hitung keterlambatan & denda
            $table->integer('terlambat')->default(0);
            $table->integer('denda')->default(0);

            // Status transaksi
            $table->enum('status', ['dipinjam', 'kembali'])
                ->default('dipinjam');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
