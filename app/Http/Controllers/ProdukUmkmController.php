<?php

namespace App\Http\Controllers;

use App\Models\ProdukUmkm;
use Illuminate\Http\Request;

class ProdukUmkmController extends Controller
{
    private function resource(): array
    {
        return [
            'title' => 'Produk UMKM',
            'singular' => 'produk',
            'route' => 'admin.produk-umkm',
            'description' => 'Kelola etalase produk UMKM desa.',
        ];
    }

    private function columns(): array
    {
        return [
            ['label' => 'Produk', 'key' => 'nama_produk', 'secondary' => 'no_whatsapp'],
            ['label' => 'Harga', 'key' => 'harga', 'type' => 'money'],
            ['label' => 'Diperbarui', 'key' => 'updated_at', 'type' => 'date'],
        ];
    }

    private function fields(): array
    {
        return [
            ['name' => 'nama_produk', 'label' => 'Nama produk', 'type' => 'text', 'required' => true],
            ['name' => 'harga', 'label' => 'Harga', 'type' => 'number', 'min' => 0, 'default' => 0],
            ['name' => 'no_whatsapp', 'label' => 'Nomor WhatsApp', 'type' => 'text'],
            ['name' => 'foto_path', 'label' => 'Path foto', 'type' => 'text'],
            ['name' => 'deskripsi', 'label' => 'Deskripsi', 'type' => 'textarea', 'rows' => 6],
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
        $data = $request->validate([
            'nama_produk' => ['required', 'string', 'max:150'],
            'deskripsi' => ['nullable', 'string'],
            'harga' => ['nullable', 'integer', 'min:0'],
            'foto_path' => ['nullable', 'string', 'max:255'],
            'no_whatsapp' => ['nullable', 'string', 'max:20'],
        ]);

        $data = array_merge($data, [
            'harga' => $data['harga'] ?? 0,
        ]);

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
        $data = $request->validate([
            'nama_produk' => ['required', 'string', 'max:150'],
            'deskripsi' => ['nullable', 'string'],
            'harga' => ['nullable', 'integer', 'min:0'],
            'foto_path' => ['nullable', 'string', 'max:255'],
            'no_whatsapp' => ['nullable', 'string', 'max:20'],
        ]);

        $data = array_merge($data, [
            'harga' => $data['harga'] ?? 0,
        ]);

        $produkUmkm->update($data);

        return redirect()->route('admin.produk-umkm.index')
            ->with('success', 'Produk UMKM berhasil diperbarui.');
    }

    public function destroy(ProdukUmkm $produkUmkm)
    {
        $produkUmkm->delete();

        return redirect()->route('admin.produk-umkm.index')
            ->with('success', 'Produk UMKM berhasil dihapus.');
    }
}
