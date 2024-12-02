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
        Schema::create('inventory_barangs', function (Blueprint $table) {
            $table->id();              
            $table->enum('status_barang', ['Tersedia', 'Dipinjam', 'Rusak', 'Habis', 'Tidak Tersedia'])->nullable();
            $table->string('kondisi')->nullable();
            $table->string('kode_barang')->unique();
            $table->integer('jumlah')->nullable();
            $table->date('tanggal');
            $table->longText('keterangan')->nullable();
            $table->unsignedBigInteger('id_barang'); 
            $table->unsignedBigInteger('id_ruangan');
            $table->timestamps();

            $table->foreign('id_barang')->references('id')->on('barangs')->onDelete('cascade');
            $table->foreign('id_ruangan')->references('id')->on('ruangans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_barangs');
    }
};
