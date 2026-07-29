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
        'harga_max',
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
        'harga_max' => 'integer',
    ];

    public function getFormattedJamOperasionalAttribute(): ?string
    {
        if (! $this->jam_operasional) {
            return null;
        }

        $parts = array_map('trim', explode('-', $this->jam_operasional, 2));
        $format = function (?string $part): ?string {
            if ($part === null || $part === '') {
                return null;
            }

            if (! preg_match('/^\d{1,2}$/', $part)) {
                return null;
            }

            $hour = (int) $part;
            return $hour >= 0 && $hour <= 23 ? sprintf('%02d:00', $hour) : null;
        };

        $start = $format($parts[0] ?? null);
        $end = $format($parts[1] ?? null);

        if ($start && $end) {
            return "$start - $end";
        }

        if ($start) {
            return "$start -";
        }

        if ($end) {
            return "- $end";
        }

        return null;
    }

    public function getHargaRangeAttribute(): ?string
    {
        $low = $this->harga > 0 ? 'Rp ' . number_format($this->harga, 0, ',', '.') : null;
        $high = $this->harga_max > 0 ? 'Rp ' . number_format($this->harga_max, 0, ',', '.') : null;

        if ($low && $high) {
            return "$low - $high";
        }

        return $low ?? $high;
    }
}
