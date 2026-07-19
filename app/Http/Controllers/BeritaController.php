<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\KategoriBerita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    private function resource(): array
    {
        return [
            'title' => 'Berita Desa',
            'singular' => 'berita',
            'route' => 'admin.berita',
            'description' => 'Kelola publikasi berita untuk website desa.',
        ];
    }

    private function columns(): array
    {
        return [
            ['label' => 'Judul', 'key' => 'judul', 'secondary' => 'kategori.nama_kategori'],
            ['label' => 'Status', 'key' => 'status', 'type' => 'badge'],
            ['label' => 'Dibuat', 'key' => 'created_at', 'type' => 'date'],
        ];
    }

    private function fields($kategori): array
    {
        return [
            ['name' => 'kategori_berita_id', 'label' => 'Kategori', 'type' => 'select', 'options' => $kategori->pluck('nama_kategori', 'id')->toArray(), 'required' => true],
            ['name' => 'judul', 'label' => 'Judul', 'type' => 'text', 'required' => true],
            ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => ['draft' => 'Draft', 'publish' => 'Publish'], 'required' => true, 'default' => 'draft'],
            ['name' => 'thumbnail', 'label' => 'Thumbnail', 'type' => 'file', 'accept' => 'image/*', 'current_path' => 'thumbnail_path'],
            ['name' => 'konten', 'label' => 'Konten', 'type' => 'textarea', 'rows' => 10, 'required' => true],
        ];
    }

    /**
     * Menampilkan daftar berita
     */
    public function index()
    {
        $berita = Berita::with('kategori')
            ->latest()
            ->paginate(10);

        return view('admin.resources.index', [
            'resource' => $this->resource(),
            'items' => $berita,
            'columns' => $this->columns(),
        ]);
    }

    /**
     * Form tambah berita
     */
    public function create()
    {
        $kategori = KategoriBerita::orderBy('nama_kategori')->get();

        return view('admin.resources.form', [
            'resource' => $this->resource(),
            'fields' => $this->fields($kategori),
        ]);
    }

    /**
     * Simpan berita
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_berita_id' => 'required|exists:kategori_berita,id',
            'judul' => 'required|max:255',
            'konten' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|in:draft,publish',
        ]);

        $validated['slug'] = Str::slug($request->judul);

        if (Berita::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] .= '-' . time();
        }

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail_path'] = $request->file('thumbnail')
                ->store('berita', 'public');
        }

        unset($validated['thumbnail']);

        Berita::create($validated);

        return redirect()
            ->route('admin.berita.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    /**
     * Detail berita
     */
    public function show(Berita $berita)
    {
        $berita->load('kategori');

        $kategori = KategoriBerita::orderBy('nama_kategori')->get();

        return view('admin.resources.show', [
            'resource' => $this->resource(),
            'item' => $berita,
            'fields' => $this->fields($kategori),
        ]);
    }

    /**
     * Form edit berita
     */
    public function edit(Berita $berita)
    {
        $kategori = KategoriBerita::orderBy('nama_kategori')->get();

        return view('admin.resources.form', [
            'resource' => $this->resource(),
            'fields' => $this->fields($kategori),
            'item' => $berita,
        ]);
    }
    /**
     * Update berita
     */
    public function update(Request $request, Berita $berita)
    {
        $validated = $request->validate([
            'kategori_berita_id' => 'required|exists:kategori_berita,id',
            'judul' => 'required|max:255',
            'konten' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|in:draft,publish',
        ]);

        $slug = Str::slug($request->judul);

        if (
            Berita::where('slug', $slug)
                ->where('id', '!=', $berita->id)
                ->exists()
        ) {
            $slug .= '-' . time();
        }

        $validated['slug'] = $slug;

        if ($request->hasFile('thumbnail')) {

            if (
                $berita->thumbnail_path &&
                Storage::disk('public')->exists($berita->thumbnail_path)
            ) {
                Storage::disk('public')->delete($berita->thumbnail_path);
            }

            $validated['thumbnail_path'] = $request
                ->file('thumbnail')
                ->store('berita', 'public');
        }

        unset($validated['thumbnail']);

        $berita->update($validated);

        return redirect()
            ->route('admin.berita.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }
    
    /**
     * Hapus berita
     */
    public function destroy(Berita $berita)
    {
        if (
            $berita->thumbnail_path &&
            Storage::disk('public')->exists($berita->thumbnail_path)
        ) {
            Storage::disk('public')->delete($berita->thumbnail_path);
        }

        $berita->delete();

        return redirect()
            ->route('admin.berita.index')
            ->with('success', 'Berita berhasil dihapus.');
    }
}
