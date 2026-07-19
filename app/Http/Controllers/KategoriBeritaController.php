<?php

namespace App\Http\Controllers;

use App\Models\KategoriBerita;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriBeritaController extends Controller
{
    private function resource(): array
    {
        return [
            'title' => 'Kategori Berita',
            'singular' => 'kategori',
            'route' => 'admin.kategori-berita',
            'description' => 'Kelola kategori untuk pengelompokan berita.',
        ];
    }

    private function columns(): array
    {
        return [
            ['label' => 'Kategori', 'key' => 'nama_kategori', 'secondary' => 'slug'],
            ['label' => 'Dibuat', 'key' => 'created_at', 'type' => 'date'],
        ];
    }

    private function fields(): array
    {
        return [
            ['name' => 'nama_kategori', 'label' => 'Nama kategori', 'type' => 'text', 'required' => true],
        ];
    }

    /**
     * Menampilkan seluruh kategori berita.
     */
    public function index()
    {
        $kategori = KategoriBerita::latest()->paginate(10);

        return view('admin.resources.index', [
            'resource' => $this->resource(),
            'items' => $kategori,
            'columns' => $this->columns(),
        ]);
    }

    /**
     * Form tambah kategori.
     */
    public function create()
    {
        return view('admin.resources.form', [
            'resource' => $this->resource(),
            'fields' => $this->fields(),
        ]);
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
            ->route('admin.kategori-berita.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Detail kategori.
     */
    public function show(KategoriBerita $kategoriBerita)
    {
        return view('admin.resources.show', [
            'resource' => $this->resource(),
            'item' => $kategoriBerita,
            'fields' => [
                ['name' => 'nama_kategori', 'label' => 'Nama kategori', 'type' => 'text'],
                ['name' => 'slug', 'label' => 'Slug', 'type' => 'text'],
            ],
        ]);
    }

    /**
     * Form edit kategori.
     */
    public function edit(KategoriBerita $kategoriBerita)
    {
        return view('admin.resources.form', [
            'resource' => $this->resource(),
            'fields' => $this->fields(),
            'item' => $kategoriBerita,
        ]);
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
            ->route('admin.kategori-berita.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Hapus kategori.
     */
    public function destroy(KategoriBerita $kategoriBerita)
    {
        $kategoriBerita->delete();

        return redirect()
            ->route('admin.kategori-berita.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
