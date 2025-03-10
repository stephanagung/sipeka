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
        Schema::create('sipeka_data_asesmen_prd', function (Blueprint $table) {
            $table->integer('id_data_asesmen_prd')->autoIncrement(); // Primary key, auto increment
            $table->integer('id_rekap_asesmen_prd'); // Foreign key
            $table->enum('grup_asesmen', [
                'Produksi Injection Grup A',
                'Produksi Injection Grup B',
                'Produksi Injection Grup C',
                'Assy'
            ]);
            $table->integer('jumlah_plan_asesmen')->nullable();
            $table->integer('jumlah_act_asesmen')->nullable();
            $table->timestamps();

            // Menambahkan foreign key constraint
            $table->foreign('id_rekap_asesmen_prd')
                ->references('id_rekap_asesmen_prd')
                ->on('sipeka_rekap_asesmen_prd')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sipeka_data_asesmen_prd');
    }
};
