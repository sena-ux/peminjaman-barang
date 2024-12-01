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
        Schema::create('riwayat_pemeliharaans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pemeliharaan_id');
            $table->longText('deskripsi');
            $table->unsignedBigInteger('user_id'); //created by
            $table->foreign('pemeliharaan_id')->references('id')->on('pemeliharaans')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_pemeliharaans');
    }
};
