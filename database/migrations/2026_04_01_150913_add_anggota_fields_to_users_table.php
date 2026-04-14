<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nis', 50)->nullable()->unique()->after('name');
            $table->string('kelas', 50)->nullable()->after('nis');
            $table->string('no_telp', 20)->nullable()->after('kelas');
            $table->text('alamat')->nullable()->after('no_telp');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nis', 'kelas', 'no_telp', 'alamat']);
        });
    }
};