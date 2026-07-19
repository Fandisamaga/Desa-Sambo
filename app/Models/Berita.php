<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita';

    protected $fillable = [
        'kategori_berita_id',
        'judul',
        'slug',
        'konten',
        'thumbnail_path',
        'status',
    ];

    /**
     * Berita dimiliki satu kategori.
     */
    public function kategori()
    {
        return $this->belongsTo(KategoriBerita::class, 'kategori_berita_id');
    }
}