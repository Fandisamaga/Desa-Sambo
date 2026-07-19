<?php

namespace App\Http\Controllers;

use App\Models\KategoriSurat;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KategoriSuratController extends Controller
{
    public function index()
    {
        $kategoriSurat = KategoriSurat::latest()->get();

        return view('kategori-surat.index', compact('kategoriSurat'));
    }

    public function create()
    {
        return view('kategori-surat.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_kategori' => ['required', 'string', 'max:100', 'unique:kategori_surat,nama_kategori'],
        ]);

        KategoriSurat::create($data);

        return redirect()->route('kategori-surat.index')
            ->with('success', 'Kategori surat berhasil ditambahkan.');
    }

    public function show(KategoriSurat $kategoriSurat)
    {
        return view('kategori-surat.show', compact('kategoriSurat'));
    }

    public function edit(KategoriSurat $kategoriSurat)
    {
        return view('kategori-surat.edit', compact('kategoriSurat'));
    }

    public function update(Request $request, KategoriSurat $kategoriSurat)
    {
        $data = $request->validate([
            'nama_kategori' => ['required', 'string', 'max:100', Rule::unique('kategori_surat', 'nama_kategori')->ignore($kategoriSurat->id)],
        ]);

        $kategoriSurat->update($data);

        return redirect()->route('kategori-surat.index')
            ->with('success', 'Kategori surat berhasil diperbarui.');
    }

    public function destroy(KategoriSurat $kategoriSurat)
    {
        $kategoriSurat->delete();

        return redirect()->route('kategori-surat.index')
            ->with('success', 'Kategori surat berhasil dihapus.');
    }
}
