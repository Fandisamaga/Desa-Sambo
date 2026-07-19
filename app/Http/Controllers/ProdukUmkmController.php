<?php

namespace App\Http\Controllers;

use App\Models\ProdukUmkm;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProdukUmkmController extends Controller
{
    public function index()
    {
        $produkUmkm = ProdukUmkm::latest()->get();

        return view('produk-umkm.index', compact('produkUmkm'));
    }

    public function create()
    {
        return view('produk-umkm.create');
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

        return redirect()->route('produk-umkm.index')
            ->with('success', 'Produk UMKM berhasil ditambahkan.');
    }

    public function show(ProdukUmkm $produkUmkm)
    {
        return view('produk-umkm.show', compact('produkUmkm'));
    }

    public function edit(ProdukUmkm $produkUmkm)
    {
        return view('produk-umkm.edit', compact('produkUmkm'));
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

        return redirect()->route('produk-umkm.index')
            ->with('success', 'Produk UMKM berhasil diperbarui.');
    }

    public function destroy(ProdukUmkm $produkUmkm)
    {
        $produkUmkm->delete();

        return redirect()->route('produk-umkm.index')
            ->with('success', 'Produk UMKM berhasil dihapus.');
    }
}
