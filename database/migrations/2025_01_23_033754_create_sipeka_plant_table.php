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
        Schema::create('sipeka_plant', function (Blueprint $table) {
            $table->integer('id_plant')->autoIncrement(); // Tipe integer, auto increment
            $table->string('nama_plant');
            $table->string('kode_plant');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sipeka_plant');
    }
};
