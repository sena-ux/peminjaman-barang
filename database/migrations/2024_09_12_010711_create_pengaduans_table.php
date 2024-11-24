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
            $table->string('nama_barang');
            $table->unsignedBigInteger('id_tanggapan')->nullable();
            $table->unsignedBigInteger('id_pelapor');
            $table->date('tanggal_pengaduan');
            $table->enum('status_pengaduan', ['Pending', 'Error','Baru', 'Validasi','Dalam Pengerjaan', 'Sedang Diproses', 'Selesai']);
            $table->text('title');
            $table->text('message');
            $table->string('foto_kerusakan')->nullable();
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
