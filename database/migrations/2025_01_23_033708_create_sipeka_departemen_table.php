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
        Schema::create('sipeka_departemen', function (Blueprint $table) {
            $table->integer('id_departemen')->autoIncrement(); // Tipe integer, auto increment
            $table->string('nama_departemen');
            $table->string('kode_departemen');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sipeka_departemen');
    }
};
