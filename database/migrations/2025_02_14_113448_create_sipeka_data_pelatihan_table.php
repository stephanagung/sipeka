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
        Schema::create('sipeka_data_pelatihan', function (Blueprint $table) {
            $table->integer('id_data_pelatihan')->autoIncrement(); // Primary key, auto increment
            $table->integer('id_rekap_pelatihan'); // Foreign key
            $table->integer('id_departemen'); // Foreign key
            $table->string('nama_pelatihan')->nullable();
            $table->integer('jumlah_plan_partisipan')->nullable();
            $table->integer('jumlah_act_partisipan')->nullable();
            $table->date('tanggal_pelatihan');
            $table->timestamps();

            // Menambahkan foreign key constraint
            $table->foreign('id_rekap_pelatihan')
                ->references('id_rekap_pelatihan')
                ->on('sipeka_rekap_pelatihan')
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
        Schema::dropIfExists('sipeka_data_pelatihan');
    }
};
