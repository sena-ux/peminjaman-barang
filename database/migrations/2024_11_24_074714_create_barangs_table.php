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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->string('harga')->nullable();
            $table->string('sumber_dana')->nullable();
            $table->string('foto_barang');
            $table->string('total_barang')->nullable();
            $table->string('tahun_pengadaan')->nullable();
            $table->string('deskripsi')->nullable();
            $table->date('date')->nullable();
            $table->enum('jenis', ['masuk', 'keluar'])->nullable();
            $table->unsignedBigInteger('id_category');
            $table->foreign('id_category')->references('id')->on('categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
