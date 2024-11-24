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
            $table->id('id');
            $table->string('nama_barang');
            $table->text('deskripsi')->nullable();
            $table->text('harga')->nullable();
            $table->text('sumber_dana')->nullable();
            $table->text('pengadaan')->nullable();
            $table->text('foto_barang')->nullable();
            $table->unsignedBigInteger('id_category');
            $table->unsignedBigInteger('id_amount')->nullable();

            $table->foreign('id_category')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('id_amount')->references('id')->on('amounts')->onDelete('cascade');
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
