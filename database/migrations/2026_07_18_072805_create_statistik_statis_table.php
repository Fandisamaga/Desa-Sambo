<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('statistik_statis', function (Blueprint $table) {
            $table->id();
            $table->string('kategori', 50);
            $table->string('kunci', 50);
            $table->string('label', 100);
            $table->string('nilai', 100);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('statistik_statis');
    }
};
