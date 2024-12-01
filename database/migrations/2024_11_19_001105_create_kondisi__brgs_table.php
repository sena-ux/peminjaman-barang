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
        Schema::create('kondisi__brgs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inv_brg_id');
            $table->string('date');
            $table->enum('status_barang', ['Tersedia', 'Hilang', 'Dipinjam', 'Tidak Tersedia']);
            $table->string('kondisi');
            $table->string('keterangan')->nullable();
            $table->longText('detail_kondisi')->nullable();
            $table->string('images')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kondisi__brgs');
    }
};
