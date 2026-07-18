<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produk_umkm', function (Blueprint $table) {
            $table->id();
            $table->string('nama_produk', 150);
            $table->text('deskripsi')->nullable();
            $table->bigInteger('harga')->default(0);
            $table->string('foto_path', 255)->nullable();
            $table->string('no_whatsapp', 20)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produk_umkm');
    }
};
