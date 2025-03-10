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
        Schema::create('sipeka_data_overtime', function (Blueprint $table) {
            $table->integer('id_data_overtime')->autoIncrement(); // Primary key, auto increment
            $table->integer('id_rekap_overtime'); // Foreign key
            $table->decimal('jumlah_act_overtime_minggu_1', 10, 2)->nullable();
            $table->decimal('jumlah_convert_overtime_minggu_1', 10, 2)->nullable();
            $table->decimal('jumlah_act_overtime_minggu_2', 10, 2)->nullable();
            $table->decimal('jumlah_convert_overtime_minggu_2', 10, 2)->nullable();
            $table->decimal('jumlah_act_overtime_minggu_3', 10, 2)->nullable();
            $table->decimal('jumlah_convert_overtime_minggu_3', 10, 2)->nullable();
            $table->decimal('jumlah_act_overtime_minggu_4', 10, 2)->nullable();
            $table->decimal('jumlah_convert_overtime_minggu_4', 10, 2)->nullable();
            $table->decimal('jumlah_act_overtime_minggu_5', 10, 2)->nullable();
            $table->decimal('jumlah_convert_overtime_minggu_5', 10, 2)->nullable();
            $table->timestamps();

            // Menambahkan foreign key constraint
            $table->foreign('id_rekap_overtime')
                ->references('id_rekap_overtime')
                ->on('sipeka_rekap_overtime')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sipeka_data_overtime');
    }
};
