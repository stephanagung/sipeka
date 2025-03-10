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
        Schema::create('sipeka_kategori_absensi', function (Blueprint $table) {
            $table->integer('id_kategori_absensi')->autoIncrement(); // Tipe integer, auto increment
            $table->string('nama_kategori_absensi');
            $table->string('kode_kategori_absensi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sipeka_kategori_absensi');
    }
};
