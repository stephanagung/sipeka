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
        Schema::create('sipeka_data_pemenuhan_tk', function (Blueprint $table) {
            $table->integer('id_data_pemenuhan_tk')->autoIncrement(); // Primary key, auto increment
            $table->integer('id_rekap_pemenuhan_tk'); // Foreign key
            $table->integer('id_departemen'); // Foreign key
            $table->string('posisi_tk')->nullable();
            $table->integer('jumlah_plan_pemenuhan_tk')->nullable();
            $table->integer('jumlah_act_pemenuhan_tk')->nullable();
            $table->date('tanggal_pemenuhan_tk');
            $table->timestamps();

            // Menambahkan foreign key constraint
            $table->foreign('id_rekap_pemenuhan_tk')
                ->references('id_rekap_pemenuhan_tk')
                ->on('sipeka_rekap_pemenuhan_tk')
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
        Schema::dropIfExists('sipeka_data_pemenuhan_tk');
    }
};
