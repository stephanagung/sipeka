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
        Schema::create('sipeka_jatah_absensi', function (Blueprint $table) {
            $table->integer('id_jatah_absensi')->autoIncrement(); // Primary key, auto increment
            $table->integer('id_pengguna'); // Foreign key
            $table->integer('total_jatah_absensi')->nullable(); // Kolom ini dapat bernilai NULL
            $table->date('tanggal_bergabung'); 
            $table->timestamps();

            // Menambahkan foreign key constraint
            $table->foreign('id_pengguna')
                ->references('id_pengguna')
                ->on('sipeka_pengguna')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sipeka_jatah_absensi');
    }
};
