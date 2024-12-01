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
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('token')->unique(); // kode peminjaman
            $table->unsignedBigInteger('barang_id');
            $table->date('tanggal_pinjam');
            $table->string('action')->nullable();
            $table->longText('keperluan');
            $table->string('penanggung_jawab')->nullable();
            $table->date('tanggal_kembali')->nullable();
            $table->boolean('status_pengembalian')->default(false);
            $table->string('barang_yang_dikembalikan')->nullable();
            $table->timestamps();
        
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('barang_id')->references('id')->on('barangs')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};
