<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArsipSurat extends Model
{
    protected $table = 'arsip_surat';

    protected $fillable = [
        'kategori_surat_id',
        'penduduk_id',
        'nomor_surat',
        'tanggal_surat',
        'perihal',
        'keterangan',
        'file_path',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
    ];

    public function kategoriSurat()
    {
        return $this->belongsTo(KategoriSurat::class, 'kategori_surat_id');
    }

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'penduduk_id');
    }
}
