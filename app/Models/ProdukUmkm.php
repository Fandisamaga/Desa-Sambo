<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdukUmkm extends Model
{
    protected $table = 'produk_umkm';

    protected $fillable = [
        'nama_produk',
        'deskripsi',
        'harga',
        'foto_path',
        'no_whatsapp',
    ];

    protected $casts = [
        'harga' => 'integer',
    ];
}
