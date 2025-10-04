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
        Schema::create('ketersediaan_dokter', function (Blueprint $table) {
            $table->id();
            $table->integer('id_dokter');
            $table->date('tanggal')->nullable();
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->enum('status', ['Tersedia', 'Tidak Tersedia'])->nullable();
            $table->bigInteger('limit_janji')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ketersediaan_dokter');
    }
};
