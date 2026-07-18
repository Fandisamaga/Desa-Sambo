<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriBerita extends Model
{
    use HasFactory;

    protected $table = 'kategori_berita';

    protected $fillable = [
        'nama_kategori',
        'slug',
    ];

    /**
     * Relasi One To Many
     * Satu kategori memiliki banyak berita.
     */
    public function berita()
    {
        return $this->hasMany(Berita::class, 'kategori_berita_id');
    }
}