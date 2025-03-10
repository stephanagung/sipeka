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
        Schema::create('sipeka_data_kaizen', function (Blueprint $table) {
            $table->integer('id_data_kaizen')->autoIncrement(); // Primary key, auto increment
            $table->integer('id_rekap_kaizen'); // Foreign key
            $table->integer('id_pengguna'); // Foreign key
            $table->string('nama_kaizen');
            $table->integer('jumlah_kaizen')->nullable();
            $table->date('tanggal_penerbitan_kaizen');
            $table->timestamps();

            // Menambahkan foreign key constraint
            $table->foreign('id_rekap_kaizen')
                ->references('id_rekap_kaizen')
                ->on('sipeka_rekap_kaizen')
                ->onDelete('cascade')
                ->onUpdate('cascade');

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
        Schema::dropIfExists('sipeka_data_kaizen');
    }
};
