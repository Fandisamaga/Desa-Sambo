<?php

namespace App\Http\Controllers;

use App\Models\ProdukUmkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukUmkmController extends Controller
{
    private function resource(): array
    {
        return [
            'title' => 'UMKM Desa',
            'singular' => 'UMKM',
            'route' => 'admin.produk-umkm',
            'description' => 'Kelola data usaha, produk, kontak, dan lokasi UMKM desa.',
        ];
    }

    private function columns(): array
    {
        return [
            ['label' => 'Nama Usaha', 'key' => 'nama_produk', 'secondary' => 'nama_pemilik'],
            ['label' => 'Jenis Usaha', 'key' => 'jenis_usaha'],
            ['label' => 'WhatsApp', 'key' => 'no_whatsapp'],
            ['label' => 'Diperbarui', 'key' => 'updated_at', 'type' => 'date'],
        ];
    }

    private function fields(?ProdukUmkm $item = null): array
    {
        $jamOperasional = $item ? $item->jam_operasional : null;
        [$jamOperasionalMulai, $jamOperasionalSelesai] = $this->splitOperatingHours($jamOperasional);

        return [
            ['name' => 'nama_produk', 'label' => 'Nama usaha', 'type' => 'text', 'required' => true],
            ['name' => 'nama_pemilik', 'label' => 'Nama pemilik', 'type' => 'text'],
            ['name' => 'jenis_usaha', 'label' => 'Jenis usaha', 'type' => 'text'],
            ['name' => 'alamat', 'label' => 'Alamat (RT/Dusun)', 'type' => 'text'],
            ['name' => 'no_whatsapp', 'label' => 'Nomor WhatsApp', 'type' => 'text'],
            ['name' => 'nama_kontak', 'label' => 'Nama kontak WhatsApp', 'type' => 'text'],
            ['name' => 'jam_operasional_mulai', 'label' => 'Jam buka', 'type' => 'number', 'min' => 0, 'max' => 23, 'default' => $jamOperasionalMulai, 'placeholder' => '0-23'],
            ['name' => 'jam_operasional_selesai', 'label' => 'Jam tutup', 'type' => 'number', 'min' => 0, 'max' => 23, 'default' => $jamOperasionalSelesai, 'placeholder' => '0-23'],
            ['name' => 'harga', 'label' => 'Harga rendah', 'type' => 'number', 'min' => 0, 'default' => $item?->harga ?? null, 'placeholder' => 'Harga rendah'],
            ['name' => 'harga_max', 'label' => 'Harga tinggi', 'type' => 'number', 'min' => 0, 'default' => $item?->harga_max ?? null, 'placeholder' => 'Harga tinggi'],
            ['name' => 'foto_path', 'label' => 'Foto usaha/produk', 'type' => 'file', 'accept' => 'image/*', 'current_path' => 'foto_path'],
            ['name' => 'lokasi_maps', 'label' => 'Lokasi Google Maps', 'type' => 'text'],
            ['name' => 'produk_jasa', 'label' => 'Produk/Jasa yang dijual', 'type' => 'textarea', 'rows' => 4],
            ['name' => 'deskripsi', 'label' => 'Deskripsi', 'type' => 'textarea', 'rows' => 6],
            ['name' => 'keterangan_tambahan', 'label' => 'Keterangan tambahan', 'type' => 'textarea', 'rows' => 3],
        ];
    }

    private function showFields(ProdukUmkm $item): array
    {
        return [
            ['name' => 'nama_produk', 'label' => 'Nama usaha', 'type' => 'text'],
            ['name' => 'nama_pemilik', 'label' => 'Nama pemilik', 'type' => 'text'],
            ['name' => 'jenis_usaha', 'label' => 'Jenis usaha', 'type' => 'text'],
            ['name' => 'alamat', 'label' => 'Alamat (RT/Dusun)', 'type' => 'text'],
            ['name' => 'no_whatsapp', 'label' => 'Nomor WhatsApp', 'type' => 'text'],
            ['name' => 'nama_kontak', 'label' => 'Nama kontak WhatsApp', 'type' => 'text'],
            ['name' => 'formatted_jam_operasional', 'label' => 'Jam Operasional', 'type' => 'text'],
            ['name' => 'harga_range', 'label' => 'Harga', 'type' => 'text'],
            ['name' => 'foto_path', 'label' => 'Foto usaha/produk', 'type' => 'file', 'current_path' => 'foto_path'],
            ['name' => 'lokasi_maps', 'label' => 'Lokasi Google Maps', 'type' => 'text'],
            ['name' => 'produk_jasa', 'label' => 'Produk/Jasa yang dijual', 'type' => 'text'],
            ['name' => 'deskripsi', 'label' => 'Deskripsi', 'type' => 'text'],
            ['name' => 'keterangan_tambahan', 'label' => 'Keterangan tambahan', 'type' => 'text'],
        ];
    }

    public function index()
    {
        $produkUmkm = ProdukUmkm::latest()->get();

        return view('admin.resources.index', [
            'resource' => $this->resource(),
            'items' => $produkUmkm,
            'columns' => $this->columns(),
        ]);
    }

    public function create()
    {
        return view('admin.resources.form', [
            'resource' => $this->resource(),
            'fields' => $this->fields(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        ProdukUmkm::create($data);

        return redirect()->route('admin.produk-umkm.index')
            ->with('success', 'Produk UMKM berhasil ditambahkan.');
    }

    public function show(ProdukUmkm $produkUmkm)
    {
        return view('admin.resources.show', [
            'resource' => $this->resource(),
            'item' => $produkUmkm,
            'fields' => $this->showFields($produkUmkm),
        ]);
    }

    public function edit(ProdukUmkm $produkUmkm)
    {
        return view('admin.resources.form', [
            'resource' => $this->resource(),
            'fields' => $this->fields($produkUmkm),
            'item' => $produkUmkm,
        ]);
    }

    public function update(Request $request, ProdukUmkm $produkUmkm)
    {
        $data = $this->validatedData($request, $produkUmkm);

        $produkUmkm->update($data);

        return redirect()->route('admin.produk-umkm.index')
            ->with('success', 'Produk UMKM berhasil diperbarui.');
    }

    public function destroy(ProdukUmkm $produkUmkm)
    {
        $this->deletePhoto($produkUmkm->foto_path);
        $produkUmkm->delete();

        return redirect()->route('admin.produk-umkm.index')
            ->with('success', 'Produk UMKM berhasil dihapus.');
    }

    private function validatedData(Request $request, ?ProdukUmkm $produkUmkm = null): array
    {
        $data = $request->validate([
            'nama_produk' => ['required', 'string', 'max:150'],
            'nama_pemilik' => ['nullable', 'string', 'max:150'],
            'jenis_usaha' => ['nullable', 'string', 'max:150'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'harga' => ['nullable', 'integer', 'min:0'],
            'harga_max' => ['nullable', 'integer', 'min:0'],
            'foto_path' => ['nullable', 'image', 'max:4096'],
            'no_whatsapp' => ['nullable', 'string', 'max:20'],
            'nama_kontak' => ['nullable', 'string', 'max:150'],
            'jam_operasional_mulai' => ['nullable', 'integer', 'min:0', 'max:23'],
            'jam_operasional_selesai' => ['nullable', 'integer', 'min:0', 'max:23'],
            'produk_jasa' => ['nullable', 'string'],
            'lokasi_maps' => ['nullable', 'string', 'max:255'],
            'keterangan_tambahan' => ['nullable', 'string'],
        ]);

        if ($data['jam_operasional_mulai'] !== null && $data['jam_operasional_selesai'] !== null) {
            $data['jam_operasional'] = sprintf('%02d - %02d', $data['jam_operasional_mulai'], $data['jam_operasional_selesai']);
        } elseif ($data['jam_operasional_mulai'] !== null) {
            $data['jam_operasional'] = sprintf('%02d -', $data['jam_operasional_mulai']);
        } elseif ($data['jam_operasional_selesai'] !== null) {
            $data['jam_operasional'] = sprintf('- %02d', $data['jam_operasional_selesai']);
        } else {
            $data['jam_operasional'] = null;
        }

        unset($data['jam_operasional_mulai'], $data['jam_operasional_selesai']);

        $data = array_merge($data, [
            'harga' => $data['harga'] ?? 0,
        ]);

        if ($request->hasFile('foto_path')) {
            if ($produkUmkm) {
                $this->deletePhoto($produkUmkm->foto_path);
            }

            $data['foto_path'] = $request->file('foto_path')->store('produk-umkm', 'public');
        } else {
            unset($data['foto_path']);
        }

        return $data;
    }

    private function splitOperatingHours(?string $jamOperasional): array
    {
        if (! $jamOperasional || ! str_contains($jamOperasional, '-')) {
            return [null, null];
        }

        $parts = array_map('trim', explode('-', $jamOperasional, 2));
        $hours = array_map(function (?string $part) {
            if ($part === null) {
                return null;
            }

            if (preg_match('/^(\d{1,2})/', $part, $matches)) {
                $hour = (int) $matches[1];
                return $hour >= 0 && $hour <= 23 ? (string) $hour : null;
            }

            return null;
        }, $parts);

        return [$hours[0] ?? null, $hours[1] ?? null];
    }

    private function deletePhoto(?string $path): void
    {
        if (! $path || str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '/')) {
            return;
        }

        Storage::disk('public')->delete($path);
    }
}
