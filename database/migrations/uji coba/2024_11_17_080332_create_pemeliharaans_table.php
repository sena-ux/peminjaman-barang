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
        Schema::create('pemeliharaans', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_pemeliharaan');
            $table->string('name');
            $table->unsignedBigInteger('id_barang');
            $table->string('kode_pemeliharaan');
            $table->string('kondisi_sebelum');
            $table->string('kondisi_sesudah');
            $table->string('tanggal');
            $table->string('sumber_dana');
            $table->string('dokumen_pendukung');
            $table->foreign('id_barang')->references('id')->on('inventory_barangs')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemeliharaans');
    }
};
