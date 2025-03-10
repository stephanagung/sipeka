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
        Schema::create('sipeka_data_kecelakaan', function (Blueprint $table) {
            $table->integer('id_data_kecelakaan')->autoIncrement(); // Primary key, auto increment
            $table->integer('id_rekap_kecelakaan'); // Foreign key
            $table->integer('id_departemen'); // Foreign key
            $table->string('nama_kecelakaan')->nullable();
            $table->integer('jumlah_korban_kecelakaan')->nullable();
            $table->string('deskripsi_kecelakaan')->nullable();
            $table->date('tanggal_kecelakaan');
            $table->timestamps();

            // Menambahkan foreign key constraint
            $table->foreign('id_rekap_kecelakaan')
                ->references('id_rekap_kecelakaan')
                ->on('sipeka_rekap_kecelakaan')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('id_departemen')
                ->references('id_departemen')
                ->on('sipeka_departemen')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sipeka_data_kecelakaan');
    }
};
