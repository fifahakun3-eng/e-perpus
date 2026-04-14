<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Buat tabel users dari awal jika belum ada
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->string('nis', 50)->nullable();
                $table->string('kelas', 50)->nullable();
                $table->string('no_telp', 20)->nullable();
                $table->text('alamat')->nullable();
                $table->enum('role', ['admin', 'anggota'])->default('anggota');
                $table->rememberToken();
                $table->timestamps();
            });
        } else {
            // Tambah kolom yang belum ada
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'nis')) {
                    $table->string('nis', 50)->nullable()->after('name');
                }
                if (!Schema::hasColumn('users', 'kelas')) {
                    $table->string('kelas', 50)->nullable()->after('nis');
                }
                if (!Schema::hasColumn('users', 'no_telp')) {
                    $table->string('no_telp', 20)->nullable()->after('kelas');
                }
                if (!Schema::hasColumn('users', 'alamat')) {
                    $table->text('alamat')->nullable()->after('no_telp');
                }
                if (!Schema::hasColumn('users', 'role')) {
                    $table->enum('role', ['admin', 'anggota'])->default('anggota')->after('alamat');
                }
            });
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nis', 'kelas', 'no_telp', 'alamat', 'role']);
        });
    }
};