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
        Schema::create('gurpegs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('nip');
            $table->string('name');
            $table->string('no_hp')->nullable();
            $table->string('status')->default('guru wali')->nullable();
            $table->unsignedBigInteger('wali_kelas')->nullable();
            $table->string('alamat')->nullable();
            $table->string('gender')->nullable();
            $table->string('instansi')->default('SMAN 2 Amlapura');
            $table->string('foto')->default('icon/default-people.png');
            
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('wali_kelas')->references('id')->on('kelas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gurpegs');
    }
};
