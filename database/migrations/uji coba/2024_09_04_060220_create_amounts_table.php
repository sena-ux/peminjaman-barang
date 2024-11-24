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
        Schema::create('amounts', function (Blueprint $table) {
            $table->id();
            $table->integer('total')->default(0);
            $table->integer('update')->default(0);
            $table->integer('akhir')->default(0);
            $table->integer('tersedia')->default(0);
            $table->integer('tidak_tersedia')->default(0);
            $table->integer('baru')->default(0);
            $table->integer('rusak')->default(0);
            $table->integer('hilang')->default(0);
            $table->integer('dipinjam')->default(0);
            $table->integer('bagus')->default(0);
            $table->integer('habis')->default(0);
            $table->unsignedBigInteger('id_barang')->nullable();
            $table->unsignedBigInteger('id_inventory')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amounts');
    }
};
