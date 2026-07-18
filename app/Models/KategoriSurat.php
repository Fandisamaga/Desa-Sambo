<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriSurat extends Model
{
    protected $table = 'kategori_surat';

    protected $fillable = [
        'nama_kategori',
    ];

    public function arsipSurat()
    {
        return $this->hasMany(ArsipSurat::class, 'kategori_surat_id');
    }
}
