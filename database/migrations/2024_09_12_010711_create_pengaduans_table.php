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
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->id('id_pengaduan');
            $table->unsignedBigInteger('id_barang');
            $table->unsignedBigInteger('id_pelapor')->nullable();
            $table->date('tanggal_pengaduan');
            $table->enum('status_pengaduan', ['Baru', 'Sedang Diproses', 'Selesai']);
            $table->text('deskripsi');
            $table->string('foto_kerusakan')->nullable();
            $table->foreign('id_barang')->references('id_barang')->on('barangs');
            $table->foreign('id_pelapor')->references('id_pelapor')->on('pelapors');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduans');
    }
};
