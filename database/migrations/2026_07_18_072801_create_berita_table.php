<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berita', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_berita_id')->constrained('kategori_berita')->cascadeOnDelete();
            $table->string('judul', 255);
            $table->string('slug', 255)->unique();
            $table->text('konten');
            $table->string('thumbnail_path', 255)->nullable();
            $table->string('status', 20)->default('draft');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
