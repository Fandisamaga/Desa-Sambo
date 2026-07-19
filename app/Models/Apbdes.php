<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apbdes extends Model
{
    protected $table = 'apbdes';

    protected $fillable = [
        'tahun',
        'pendapatan',
        'belanja',
        'penerimaan_pembiayaan',
        'pengeluaran_pembiayaan',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'pendapatan' => 'integer',
        'belanja' => 'integer',
        'penerimaan_pembiayaan' => 'integer',
        'pengeluaran_pembiayaan' => 'integer',
    ];
}
