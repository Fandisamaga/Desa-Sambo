<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stunting', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penduduk_id')->constrained('penduduk')->cascadeOnDelete();
            $table->date('tanggal_diagnosa')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stunting');
    }
};
