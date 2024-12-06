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
            $table->unsignedBigInteger('kir_id')->nullable();
            $table->foreign('kir_id')->references('id')->on('k_i_r_s')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('riwayat_k_i_r_s', function (Blueprint $table) {
            $table->dropForeign('kir_id');
        });
    }
};
