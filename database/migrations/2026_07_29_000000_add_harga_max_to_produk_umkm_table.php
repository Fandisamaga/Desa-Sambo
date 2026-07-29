<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produk_umkm', function (Blueprint $table) {
            $table->bigInteger('harga_max')->nullable()->after('harga');
        });
    }

    public function down(): void
    {
        Schema::table('produk_umkm', function (Blueprint $table) {
            $table->dropColumn('harga_max');
        });
    }
};
