<?php

namespace App\Http\Controllers;

use App\Models\KategoriBerita;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriBeritaController extends Controller
{
    /**
     * Menampilkan seluruh kategori berita.
     */
    public function index()
    {
        $kategori = KategoriBerita::latest()->paginate(10);

        return view('kategori-berita.index', compact('kategori'));
    }

    /**
     * Form tambah kategori.
     */
    public function create()
    {
        return view('kategori-berita.create');
    }

    /**
     * Simpan kategori.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|max:100|unique:kategori_berita,nama_kategori',
        ]);

        KategoriBerita::create([
            'nama_kategori' => $request->nama_kategori,
            'slug' => Str::slug($request->nama_kategori),
        ]);

        return redirect()
            ->route('kategori-berita.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Detail kategori.
     */
    public function show(KategoriBerita $kategoriBerita)
    {
        return view('kategori-berita.show', compact('kategoriBerita'));
    }

    /**
     * Form edit kategori.
     */
    public function edit(KategoriBerita $kategoriBerita)
    {
        return view('kategori-berita.edit', compact('kategoriBerita'));
    }

    /**
     * Update kategori.
     */
    public function update(Request $request, KategoriBerita $kategoriBerita)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|max:100|unique:kategori_berita,nama_kategori,' . $kategoriBerita->id,
        ]);

        $kategoriBerita->update([
            'nama_kategori' => $request->nama_kategori,
            'slug' => Str::slug($request->nama_kategori),
        ]);

        return redirect()
            ->route('kategori-berita.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Hapus kategori.
     */
    public function destroy(KategoriBerita $kategoriBerita)
    {
        $kategoriBerita->delete();

        return redirect()
            ->route('kategori-berita.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}