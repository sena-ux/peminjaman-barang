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
            $table->unsignedBigInteger('sarana_id');
            $table->string('kode_barang')->nullable();
            $table->string('jenis_pemeliharaan');
            $table->string('kode_pemeliharaan');
            $table->string('tanggal_mulai');
            $table->string('tanggal_selesai');
            $table->string('kondisi_sebelum');
            $table->string('kondisi_sesudah');
            $table->string('biaya');
            $table->string('sumber_dana');
            $table->string('penanggung_jawab');
            $table->enum('status', ['Validasi', 'Disetujui', 'Vefirikasi', 'Verifikasi Sukses', 'Realisasi', 'Error', 'Batal', 'Pending', 'Tidak Disetujui', 'Dalam Pengerjaan', 'Selesai'])->default('Validasi');
            $table->string('keterangan')->default('Memvalidasi data');
            $table->string('dokumen_pendukung');
            $table->foreign('sarana_id')->references('id')->on('saranas');
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
