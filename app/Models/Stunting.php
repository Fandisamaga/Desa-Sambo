<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stunting extends Model
{
    protected $table = 'stunting';

    protected $fillable = [
        'penduduk_id',
        'tanggal_diagnosa',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_diagnosa' => 'date',
    ];

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'penduduk_id');
    }
}
