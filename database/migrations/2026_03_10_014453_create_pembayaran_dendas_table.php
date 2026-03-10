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
        Schema::create('pembayaran_dendas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengembalian_id')->constrained('pengembalian')->onDelete('cascade');
            $table->integer('jumlah_bayar');
            $table->date('tanggal_bayar');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran_dendas');
    }
};
