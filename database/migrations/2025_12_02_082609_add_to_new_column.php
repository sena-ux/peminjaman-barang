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
        Schema::table('barangs', function (Blueprint $table) {
            $table->string('no_seri_pubrik')->nullable();
            $table->string('ukuran')->nullable();
            $table->string('bahan')->nullable();
            $table->string('kode_barang')->nullable();
            $table->string('satuan')->nullable();
        });
        Schema::table('gurpegs', function (Blueprint $table) {
            $table->unsignedBigInteger('wali_kelas')->nullable();
            $table->foreign('wali_kelas')->references('id')->on('kelas');
            $table->string('alamat')->nullable();
            $table->string('gender')->nullable();
            $table->string('instansi')->default('SMAN 2 Amlapura');
            $table->string('foto')->default('icon/default-people.png');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropColumn('no_seri_pubrik');
            $table->dropColumn('ukuran');
            $table->dropColumn('bahan');
            $table->dropColumn('kode_barang');
            $table->dropColumn('satuan');
        });
        Schema::table('gurpegs', function (Blueprint $table) {
            $table->dropColumn('wali_kelas');
            $table->dropForeign('wali_kelas');
            $table->dropColumn('alamat');
            $table->dropColumn('gender');
            $table->dropColumn('instansi');
            $table->dropColumn('foto');
        });
    }
};
