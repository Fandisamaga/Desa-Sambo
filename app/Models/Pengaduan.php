<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    protected $table = 'pengaduan';

    protected $fillable = [
        'nama_pengirim',
        'kontak_pengirim',
        'isi_aduan',
        'status',
        'catatan_admin',
    ];
}
