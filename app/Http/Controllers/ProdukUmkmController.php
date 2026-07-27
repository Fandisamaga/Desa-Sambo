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

    private function fields(): array
    {
        return [
            ['name' => 'nama_produk', 'label' => 'Nama usaha', 'type' => 'text', 'required' => true],
            ['name' => 'nama_pemilik', 'label' => 'Nama pemilik', 'type' => 'text'],
            ['name' => 'jenis_usaha', 'label' => 'Jenis usaha', 'type' => 'text'],
            ['name' => 'alamat', 'label' => 'Alamat (RT/Dusun)', 'type' => 'text'],
            ['name' => 'no_whatsapp', 'label' => 'Nomor WhatsApp', 'type' => 'text'],
            ['name' => 'nama_kontak', 'label' => 'Nama kontak WhatsApp', 'type' => 'text'],
            ['name' => 'jam_operasional', 'label' => 'Jam operasional', 'type' => 'text'],
            ['name' => 'harga', 'label' => 'Harga mulai dari', 'type' => 'number', 'min' => 0, 'default' => 0],
            ['name' => 'foto_path', 'label' => 'Foto usaha/produk', 'type' => 'file', 'accept' => 'image/*', 'current_path' => 'foto_path'],
            ['name' => 'lokasi_maps', 'label' => 'Lokasi Google Maps', 'type' => 'text'],
            ['name' => 'produk_jasa', 'label' => 'Produk/Jasa yang dijual', 'type' => 'textarea', 'rows' => 4],
            ['name' => 'deskripsi', 'label' => 'Deskripsi', 'type' => 'textarea', 'rows' => 6],
            ['name' => 'keterangan_tambahan', 'label' => 'Keterangan tambahan', 'type' => 'textarea', 'rows' => 3],
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
            'fields' => $this->fields(),
        ]);
    }

    public function edit(ProdukUmkm $produkUmkm)
    {
        return view('admin.resources.form', [
            'resource' => $this->resource(),
            'fields' => $this->fields(),
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
            'foto_path' => ['nullable', 'image', 'max:4096'],
            'no_whatsapp' => ['nullable', 'string', 'max:20'],
            'nama_kontak' => ['nullable', 'string', 'max:150'],
            'jam_operasional' => ['nullable', 'string', 'max:100'],
            'produk_jasa' => ['nullable', 'string'],
            'lokasi_maps' => ['nullable', 'string', 'max:255'],
            'keterangan_tambahan' => ['nullable', 'string'],
        ]);

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

    private function deletePhoto(?string $path): void
    {
        if (! $path || str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '/')) {
            return;
        }

        Storage::disk('public')->delete($path);
    }
}
