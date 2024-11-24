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
        // Menambahkan foreign key ke tabel pengaduans
        Schema::table('pengaduans', function (Blueprint $table) {
            $table->foreign('id_pelapor')->references('id_pelapor')->on('pelapors')->onDelete('cascade');
            $table->foreign('id_tanggapan')->references('id')->on('tanggapans')->onDelete('cascade');
        });

        // Menambahkan foreign key ke tabel tanggapans
        Schema::table('tanggapans', function (Blueprint $table) {
            $table->foreign('pengaduan_id')->references('id_pengaduan')->on('pengaduans')->onDelete('cascade');
            $table->foreign('penanggap_id')->references('id')->on('penanggaps')->onDelete('cascade');
            // $table->foreign('inventoryBRK_id')->references('id')->on('inventory_ruang_kelas_barangs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Menghapus foreign key jika rollback
        Schema::table('pengaduans', function (Blueprint $table) {
            $table->dropForeign(['id_barang']);
            $table->dropForeign(['id_pelapor']);
            $table->dropForeign(['id_tanggapan']);
        });

        Schema::table('tanggapans', function (Blueprint $table) {
            $table->dropForeign(['pengaduan_id']);
            $table->dropForeign(['penanggap_id']);
            $table->dropForeign(['inventoryBRK_id']);
        });
    }
};
