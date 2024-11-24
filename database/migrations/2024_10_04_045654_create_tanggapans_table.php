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
        Schema::create('tanggapans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('message');
            $table->string('key')->nullable();
            $table->enum('status', ['Pending', 'Error','Baru', 'Validasi','Dalam Pengerjaan', 'Sedang Diproses', 'Selesai']);
            $table->unsignedBigInteger('pengaduan_id')->nullable();
            $table->unsignedBigInteger('penanggap_id')->nullable();
            // $table->unsignedBigInteger('inventoryBRK_id')->nullable();
            $table->string('foto_tanggapan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tanggapans');
    }
};
