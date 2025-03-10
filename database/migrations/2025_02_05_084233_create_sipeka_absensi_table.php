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
        Schema::create('sipeka_absensi', function (Blueprint $table) {
            $table->integer('id_absensi')->autoIncrement(); // Primary key, auto increment
            $table->integer('id_jatah_absensi'); // Foreign key
            $table->integer('id_kategori_absensi'); // Foreign key
            $table->enum('shift', ['1', '2', '3']);
            $table->text('dokumen_pendukung')->nullable(); // Text, nullable
            $table->integer('status_absensi'); // Integer
            $table->dateTime('tanggal_absensi_mulai'); // Datetime
            $table->dateTime('tanggal_absensi_akhir'); // Datetime
            $table->integer('jumlah_absensi')->nullable(); // Integer, nullable
            $table->string('alasan'); // Varchar
            $table->string('catatan')->nullable(); // Varchar
            $table->integer('disetujui_atasan')->nullable(); // Integer, nullable
            $table->integer('disetujui_hrd')->nullable(); // Integer, nullable
            $table->timestamps();

            // Menambahkan foreign key constraint
            $table->foreign('id_jatah_absensi')
                ->references('id_jatah_absensi')
                ->on('sipeka_jatah_absensi')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('id_kategori_absensi')
                ->references('id_kategori_absensi')
                ->on('sipeka_kategori_absensi')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sipeka_absensi');
    }
};
