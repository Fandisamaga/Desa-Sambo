<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penduduk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kartu_keluarga_id')->constrained('kartu_keluarga')->cascadeOnDelete();
            $table->string('nik', 16)->unique();
            $table->string('nama_lengkap', 150);
            $table->string('tempat_lahir', 100);
            $table->date('tanggal_lahir');
            $table->string('jenis_kelamin', 20);
            $table->string('agama', 50);
            $table->string('pendidikan', 100);
            $table->string('pekerjaan', 100);
            $table->string('status_kawin', 50);
            $table->string('status_keluarga', 50);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penduduk');
    }
};
