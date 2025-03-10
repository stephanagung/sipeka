<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sipeka_pengguna', function (Blueprint $table) {
            $table->integer('id_pengguna')->autoIncrement(); // Tipe integer, auto increment
            $table->integer('id_departemen');
            $table->integer('id_plant');
            $table->string('nik');
            $table->string('nama_lengkap');
            $table->string('jabatan');
            $table->enum('domisili', ['Bekasi', 'LuarBekasi']);
            $table->enum('jenis_lemburan', ['Flat', 'NonFlat']);
            $table->enum('status_pekerjaan', ['Tetap', 'Kontrak', 'Magang/PKL']);
            $table->enum('pendidikan_terakhir', ['SD', 'SMP', 'SMA', 'SMK', 'D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3']);
            $table->enum('jenis_kelamin', ['Pria', 'Wanita']);
            $table->string('username')->nullable(); // Kolom ini dapat bernilai NULL
            $table->string('password')->nullable(); // Kolom ini dapat bernilai NULL
            $table->enum('level', ['Admin', 'Atasan', 'Karyawan'])->nullable(); // Kolom ini dapat bernilai NULL
            $table->timestamps();

            // Menambahkan foreign key constraint
            $table->foreign('id_departemen')
                ->references('id_departemen')
                ->on('sipeka_departemen')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('id_plant')
                ->references('id_plant')
                ->on('sipeka_plant')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sipeka_pengguna');
    }
};
