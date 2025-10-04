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
        Schema::create('layanan_tarif', function (Blueprint $table) {
            $table->id();
            $table->string('img_url');
            $table->string('caption');
            $table->bigInteger('id_poly');
            $table->integer('price');
            $table->boolean('is_active');
            $table->bigInteger('created_by');
            $table->bigInteger('lastupdate_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanan_tarif');
    }
};
