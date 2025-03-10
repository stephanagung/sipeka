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
        Schema::create('sipeka_rekap_overtime', function (Blueprint $table) {
            $table->integer('id_rekap_overtime')->autoIncrement(); // Primary key, auto increment
            $table->integer('id_plant'); // Foreign key
            $table->decimal('total_act_overtime', 10, 2)->nullable();
            $table->decimal('total_convert_overtime', 10, 2)->nullable();
            $table->enum('periode_bulan_overtime', [
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
            $table->year('periode_tahun_overtime'); // Untuk menyimpan tahun
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
        Schema::dropIfExists('sipeka_rekap_overtime');
    }
};
