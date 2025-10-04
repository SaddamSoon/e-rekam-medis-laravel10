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
        Schema::create('janji_temu', function (Blueprint $table) {
            $table->id();
            $table->integer('id_dokter');
            $table->string('nama_pasien');
            $table->date('tgl_lahir');
            $table->string('no_hp');
            $table->string('alamat');
            $table->string('keluhan');
            $table->enum('status', ['pending','dikonfirmasi','selesai','batal']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('janji_temu');
    }
};
