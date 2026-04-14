<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('bukus', function (Blueprint $table) {
            $table->enum('tipe', ['fisik', 'ebook'])->default('fisik')->after('kategori');
            $table->string('url_ebook')->nullable()->after('tipe');
        });
    }

    public function down(): void
    {
        Schema::table('bukus', function (Blueprint $table) {
            $table->dropColumn(['tipe', 'url_ebook']);
        });
    }
};