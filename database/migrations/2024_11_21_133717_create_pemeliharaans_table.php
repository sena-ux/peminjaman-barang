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
            $table->string('barang')->nullable()->unique();
            $table->string('jenis_pemeliharaan');
            $table->string('category');
            $table->string('kode_pemeliharaan')->unique();
            $table->string('penanggung_jawab');
            $table->string('tanggal_mulai')->nullable();
            $table->string('tanggal_selesai')->nullable();
            $table->string('kondisi_sebelum')->nullable();
            $table->string('kondisi_sesudah')->nullable();
            $table->string('biaya')->nullable();
            $table->string('sumber_dana')->nullable();
            $table->enum('status', ['Validasi', 'Disetujui', 'Vefirikasi', 'Verifikasi Sukses', 'Realisasi', 'Error', 'Batal', 'Pending', 'Tidak Disetujui', 'Dalam Pengerjaan', 'Selesai'])->default('Validasi');
            $table->string('keterangan')->default('Memvalidasi data');
            $table->longText('dokumen_pendukung')->nullable();
            $table->longText('detail_pemeliharaan')->nullable();
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
