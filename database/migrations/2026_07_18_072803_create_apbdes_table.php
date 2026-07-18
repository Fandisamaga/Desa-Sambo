<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('apbdes', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->bigInteger('pendapatan')->default(0);
            $table->bigInteger('belanja')->default(0);
            $table->bigInteger('penerimaan_pembiayaan')->default(0);
            $table->bigInteger('pengeluaran_pembiayaan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apbdes');
    }
};
