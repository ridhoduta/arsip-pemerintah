<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_surat', function (Blueprint $table) {
            $table->id('surat_id');
            $table->string('nomor_surat')->unique();
            $table->unsignedBigInteger('kategori_id');
            $table->string('judul');
            $table->string('file');
            $table->timestamps();

            $table->foreign('kategori_id')->references('kategori_id')->on('tb_kategori')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surats');
    }
};
