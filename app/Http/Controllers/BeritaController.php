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
            ['label' => 'Judul', 'key' => 'judul'],
            ['label' => 'Status', 'key' => 'status', 'type' => 'badge'],
            ['label' => 'Tanggal upload', 'key' => 'tanggal_upload', 'type' => 'date'],
        ];
    }

    private function fields(): array
    {
        return [
            ['name' => 'judul', 'label' => 'Judul', 'type' => 'text', 'required' => true],
            ['name' => 'tanggal_upload', 'label' => 'Tanggal upload', 'type' => 'date', 'required' => true, 'default' => now()->toDateString()],
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
        return view('admin.resources.form', [
            'resource' => $this->resource(),
            'fields' => $this->fields(),
        ]);
    }

    /**
     * Simpan berita
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|max:255',
            'tanggal_upload' => 'required|date',
            'konten' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|in:draft,publish',
        ]);

        $validated['kategori_berita_id'] = $this->defaultKategoriBeritaId();
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
        return view('admin.resources.show', [
            'resource' => $this->resource(),
            'item' => $berita,
            'fields' => $this->fields(),
        ]);
    }

    /**
     * Form edit berita
     */
    public function edit(Berita $berita)
    {
        return view('admin.resources.form', [
            'resource' => $this->resource(),
            'fields' => $this->fields(),
            'item' => $berita,
        ]);
    }
    /**
     * Update berita
     */
    public function update(Request $request, Berita $berita)
    {
        $validated = $request->validate([
            'judul' => 'required|max:255',
            'tanggal_upload' => 'required|date',
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

    private function defaultKategoriBeritaId(): int
    {
        return KategoriBerita::firstOrCreate(
            ['slug' => 'berita-desa'],
            ['nama_kategori' => 'Berita Desa'],
        )->id;
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
