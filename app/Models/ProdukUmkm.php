<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdukUmkm extends Model
{
    protected $table = 'produk_umkm';

    protected $fillable = [
        'nama_produk',
        'nama_pemilik',
        'jenis_usaha',
        'alamat',
        'deskripsi',
        'harga',
        'foto_path',
        'no_whatsapp',
        'nama_kontak',
        'jam_operasional',
        'produk_jasa',
        'lokasi_maps',
        'keterangan_tambahan',
    ];

    protected $casts = [
        'harga' => 'integer',
    ];
}
