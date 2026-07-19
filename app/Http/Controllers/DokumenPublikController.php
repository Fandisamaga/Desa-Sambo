<?php

namespace App\Http\Controllers;

use App\Models\DokumenPublik;
use Illuminate\Http\Request;

class DokumenPublikController extends Controller
{
    private function resource(): array
    {
        return [
            'title' => 'Dokumen Publik',
            'singular' => 'dokumen',
            'route' => 'admin.dokumen-publik',
            'description' => 'Kelola dokumen publik yang dapat diakses masyarakat.',
        ];
    }

    private function columns(): array
    {
        return [
            ['label' => 'Dokumen', 'key' => 'judul_dokumen', 'secondary' => 'file_path'],
            ['label' => 'Tahun', 'key' => 'tahun'],
            ['label' => 'Diperbarui', 'key' => 'updated_at', 'type' => 'date'],
        ];
    }

    private function fields(): array
    {
        return [
            ['name' => 'judul_dokumen', 'label' => 'Judul dokumen', 'type' => 'text', 'required' => true],
            ['name' => 'tahun', 'label' => 'Tahun', 'type' => 'number', 'min' => 1900, 'required' => true],
            ['name' => 'file_path', 'label' => 'Path file', 'type' => 'text', 'required' => true],
        ];
    }

    public function index()
    {
        $dokumenPublik = DokumenPublik::latest('tahun')->paginate(10);

        return view('admin.resources.index', [
            'resource' => $this->resource(),
            'items' => $dokumenPublik,
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
            'judul_dokumen' => ['required', 'string', 'max:200'],
            'file_path' => ['required', 'string', 'max:255'],
            'tahun' => ['required', 'integer', 'min:1900'],
        ]);

        DokumenPublik::create($data);

        return redirect()->route('admin.dokumen-publik.index')
            ->with('success', 'Dokumen publik berhasil ditambahkan.');
    }

    public function show(DokumenPublik $dokumenPublik)
    {
        return view('admin.resources.show', [
            'resource' => $this->resource(),
            'item' => $dokumenPublik,
            'fields' => $this->fields(),
        ]);
    }

    public function edit(DokumenPublik $dokumenPublik)
    {
        return view('admin.resources.form', [
            'resource' => $this->resource(),
            'fields' => $this->fields(),
            'item' => $dokumenPublik,
        ]);
    }

    public function update(Request $request, DokumenPublik $dokumenPublik)
    {
        $data = $request->validate([
            'judul_dokumen' => ['required', 'string', 'max:200'],
            'file_path' => ['required', 'string', 'max:255'],
            'tahun' => ['required', 'integer', 'min:1900'],
        ]);

        $dokumenPublik->update($data);

        return redirect()->route('admin.dokumen-publik.index')
            ->with('success', 'Dokumen publik berhasil diperbarui.');
    }

    public function destroy(DokumenPublik $dokumenPublik)
    {
        $dokumenPublik->delete();

        return redirect()->route('admin.dokumen-publik.index')
            ->with('success', 'Dokumen publik berhasil dihapus.');
    }
}
