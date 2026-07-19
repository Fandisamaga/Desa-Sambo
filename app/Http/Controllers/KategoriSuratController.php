<?php

namespace App\Http\Controllers;

use App\Models\KategoriSurat;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KategoriSuratController extends Controller
{
    private function resource(): array
    {
        return [
            'title' => 'Kategori Surat',
            'singular' => 'kategori',
            'route' => 'admin.kategori-surat',
            'description' => 'Kelola kategori arsip surat layanan desa.',
        ];
    }

    private function columns(): array
    {
        return [
            ['label' => 'Kategori', 'key' => 'nama_kategori'],
            ['label' => 'Dibuat', 'key' => 'created_at', 'type' => 'date'],
        ];
    }

    private function fields(): array
    {
        return [
            ['name' => 'nama_kategori', 'label' => 'Nama kategori', 'type' => 'text', 'required' => true],
        ];
    }

    public function index()
    {
        $kategoriSurat = KategoriSurat::latest()->get();

        return view('admin.resources.index', [
            'resource' => $this->resource(),
            'items' => $kategoriSurat,
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
            'nama_kategori' => ['required', 'string', 'max:100', 'unique:kategori_surat,nama_kategori'],
        ]);

        KategoriSurat::create($data);

        return redirect()->route('admin.kategori-surat.index')
            ->with('success', 'Kategori surat berhasil ditambahkan.');
    }

    public function show(KategoriSurat $kategoriSurat)
    {
        return view('admin.resources.show', [
            'resource' => $this->resource(),
            'item' => $kategoriSurat,
            'fields' => $this->fields(),
        ]);
    }

    public function edit(KategoriSurat $kategoriSurat)
    {
        return view('admin.resources.form', [
            'resource' => $this->resource(),
            'fields' => $this->fields(),
            'item' => $kategoriSurat,
        ]);
    }

    public function update(Request $request, KategoriSurat $kategoriSurat)
    {
        $data = $request->validate([
            'nama_kategori' => ['required', 'string', 'max:100', Rule::unique('kategori_surat', 'nama_kategori')->ignore($kategoriSurat->id)],
        ]);

        $kategoriSurat->update($data);

        return redirect()->route('admin.kategori-surat.index')
            ->with('success', 'Kategori surat berhasil diperbarui.');
    }

    public function destroy(KategoriSurat $kategoriSurat)
    {
        $kategoriSurat->delete();

        return redirect()->route('admin.kategori-surat.index')
            ->with('success', 'Kategori surat berhasil dihapus.');
    }
}
