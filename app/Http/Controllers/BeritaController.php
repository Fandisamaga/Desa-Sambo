<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\KategoriBerita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    /**
     * Menampilkan daftar berita
     */
    public function index()
    {
        $berita = Berita::with('kategori')
            ->latest()
            ->paginate(10);

        return view('berita.index', compact('berita'));
    }

    /**
     * Form tambah berita
     */
    public function create()
    {
        $kategori = KategoriBerita::orderBy('nama_kategori')->get();

        return view('berita.create', compact('kategori'));
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

        Berita::create($validated);

        return redirect()
            ->route('berita.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    /**
     * Detail berita
     */
    public function show(Berita $berita)
    {
        $berita->load('kategori');

        return view('berita.show', compact('berita'));
    }

    /**
     * Form edit berita
     */
    public function edit(Berita $berita)
    {
        $kategori = KategoriBerita::orderBy('nama_kategori')->get();

        return view('berita.edit', compact('berita', 'kategori'));
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

        $berita->update($validated);

        return redirect()
            ->route('berita.index')
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
            ->route('berita.index')
            ->with('success', 'Berita berhasil dihapus.');
    }
}