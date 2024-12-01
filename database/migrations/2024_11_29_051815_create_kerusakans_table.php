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
        Schema::create('kerusakans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('tingkat_kerusakan', ['rendah', 'sedang', 'tinggi'])->default('sedang');
            $table->longText('detail_kerusakan');
            $table->enum('status', ['validasi', 'proses', 'error', 'selesai', 'pending'])->default('pending');
            $table->unsignedBigInteger('id_pelapor');
            $table->foreign('id_pelapor')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kerusakans');
    }
};
