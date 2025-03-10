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
        Schema::create('sipeka_rekap_pelatihan', function (Blueprint $table) {
            $table->integer('id_rekap_pelatihan')->autoIncrement(); // Primary key, auto increment
            $table->integer('id_plant'); // Foreign key
            $table->integer('total_plan_pelatihan')->nullable(); // Kolom ini dapat bernilai NULL
            $table->integer('total_act_pelatihan')->nullable(); // Kolom ini dapat bernilai NULL
            $table->integer('total_plan_partisipasi')->nullable(); // Kolom ini dapat bernilai NULL
            $table->integer('total_act_partisipasi')->nullable(); // Kolom ini dapat bernilai NULL
            $table->enum('periode_bulan_pelatihan', [
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
            $table->year('periode_tahun_pelatihan'); // Untuk menyimpan tahun
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
        Schema::dropIfExists('sipeka_rekap_pelatihan');
    }
};
