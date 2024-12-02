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
        Schema::create('k_i_r_s', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barang_id');
            $table->unsignedBigInteger('siswa_id')->nullable();
            $table->unsignedBigInteger('ruangan_id');
            $table->unsignedBigInteger('kepala_sekolah_id');
            $table->unsignedBigInteger('pengelola_id');
            $table->unsignedBigInteger('wali_id')->nullable();
            $table->unsignedBigInteger('setting_id');
            $table->unsignedBigInteger('riwayat_id')->nullable();

            $table->foreign('barang_id')->references('id')->on('barangs')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('siswa_id')->references('id')->on('siswas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('ruangan_id')->references('id')->on('ruangans')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('kepala_sekolah_id')->references('id')->on('staff')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('pengelola_id')->references('id')->on('staff')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('wali_id')->references('id')->on('staff')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('setting_id')->references('id')->on('settings');
            $table->foreign('riwayat_id')->references('id')->on('riwayat_k_i_r_s')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('k_i_r_s');
    }
};
