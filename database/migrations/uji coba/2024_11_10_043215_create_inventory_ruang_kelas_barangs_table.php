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
        Schema::create('inventory_ruang_kelas_barangs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_barangrk');
            $table->unsignedBigInteger('id_tanggapan')->nullable();
            $table->unsignedBigInteger('id_kelas');
            $table->unsignedBigInteger('user_id');
            $table->string('kode_barang');
            $table->string('kondisi');
            $table->string('status');
            $table->integer('amount');
            $table->string('foto');
            $table->timestamps();

            $table->foreign('id_barangrk')->references('id')->on('barang_r_k_s')->onDelete('cascade');
            $table->foreign('id_kelas')->references('id')->on('kelas')->onDelete('cascade');
            $table->foreign('id_tanggapan')->references('id')->on('tanggapans')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_ruang_kelas_barangs');
    }
};
