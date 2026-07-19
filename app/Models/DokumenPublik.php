<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenPublik extends Model
{
    protected $table = 'dokumen_publik';

    protected $fillable = [
        'judul_dokumen',
        'file_path',
        'tahun',
    ];

    protected $casts = [
        'tahun' => 'integer',
    ];
}
