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
        Schema::create('sipeka_rekap_kecelakaan', function (Blueprint $table) {
            $table->integer('id_rekap_kecelakaan')->autoIncrement(); // Primary key, auto increment
            $table->integer('id_plant'); // Foreign key
            $table->integer('total_kecelakaan')->nullable(); // Kolom ini dapat bernilai NULL
            $table->integer('total_korban_kecelakaan')->nullable(); // Kolom ini dapat bernilai NULL
            $table->enum('periode_bulan_kecelakaan', [
                'January',
                'February',
                'March',
                'April',
                'May',
                'June',
                'July',
                'August',
                'September',
                'October',
                'November',
                'December'
            ]);
            $table->year('periode_tahun_kecelakaan'); // Untuk menyimpan tahun
            $table->timestamps();

            // Menambahkan foreign key constraint
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
        Schema::dropIfExists('sipeka_rekap_kecelakaan');
    }
};
