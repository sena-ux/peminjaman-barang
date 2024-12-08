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
        Schema::table('k_i_r_s', function (Blueprint $table) {
            $table->string('kode_kir')->nullable();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('k_i_r_s', function (Blueprint $table) {
            $table->dropColumn('kode_kir');
        });
    }
};
