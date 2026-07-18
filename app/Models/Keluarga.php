<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KartuKeluarga extends Model
{
    use HasFactory;

    protected $table = 'kartu_keluarga';

    protected $fillable = [
        'no_kk',
        'kepala_keluarga_id',
        'alamat',
        'rt',
        'rw',
        'dusun',
    ];

    public function kepalaKeluarga()
    {
        return $this->belongsTo(Penduduk::class, 'kepala_keluarga_id');
    }

    public function penduduk()
    {
        return $this->hasMany(Penduduk::class, 'kartu_keluarga_id');
    }
}