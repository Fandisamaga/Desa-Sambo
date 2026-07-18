<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('arsip_surat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_surat_id')->constrained('kategori_surat')->cascadeOnDelete();
            $table->foreignId('penduduk_id')->constrained('penduduk')->cascadeOnDelete();
            $table->string('nomor_surat', 100);
            $table->date('tanggal_surat');
            $table->string('perihal', 200);
            $table->text('keterangan')->nullable();
            $table->string('file_path', 255);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('arsip_surat');
    }
};
