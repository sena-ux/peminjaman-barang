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
        Schema::table('riwayat_k_i_r_s', function (Blueprint $table) {
            $table->integer('jumlah')->nullable();
            $table->integer('bagus')->nullable();
            $table->integer('kurang_bagus')->nullable();
            $table->integer('rusak_berat')->nullable();
            $table->integer('date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('riwayat_kir', function (Blueprint $table) {
            $table->dropColumn('jumlah');
            $table->dropColumn('bagus');
            $table->dropColumn('kurang_bagus');
            $table->dropColumn('rusak_berat');
            $table->dropColumn('date');
        });
    }
};
