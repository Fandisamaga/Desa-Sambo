<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profil_desa', function (Blueprint $table) {
            $table->id();
            $table->string('nama_desa', 100);
            $table->string('nama_kepala_desa', 100);
            $table->text('sejarah')->nullable();
            $table->text('visi_misi')->nullable();
            $table->string('logo_path', 255)->nullable();
            $table->text('alamat_kantor')->nullable();
            $table->string('kontak_telepon', 20)->nullable();
            $table->string('struktur_organisasi_path', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profil_desa');
    }
};
