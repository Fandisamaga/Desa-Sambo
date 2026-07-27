<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produk_umkm', function (Blueprint $table) {
            $table->string('nama_pemilik', 150)->nullable()->after('nama_produk');
            $table->string('jenis_usaha', 150)->nullable()->after('nama_pemilik');
            $table->string('alamat', 255)->nullable()->after('jenis_usaha');
            $table->string('nama_kontak', 150)->nullable()->after('no_whatsapp');
            $table->string('jam_operasional', 100)->nullable()->after('nama_kontak');
            $table->text('produk_jasa')->nullable()->after('jam_operasional');
            $table->string('lokasi_maps', 255)->nullable()->after('produk_jasa');
            $table->text('keterangan_tambahan')->nullable()->after('lokasi_maps');
        });
    }

    public function down(): void
    {
        Schema::table('produk_umkm', function (Blueprint $table) {
            $table->dropColumn([
                'nama_pemilik',
                'jenis_usaha',
                'alamat',
                'nama_kontak',
                'jam_operasional',
                'produk_jasa',
                'lokasi_maps',
                'keterangan_tambahan',
            ]);
        });
    }
};
