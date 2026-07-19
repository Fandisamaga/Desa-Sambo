<?php

namespace App\Http\Controllers;

use App\Models\ArsipSurat;
use App\Models\KategoriSurat;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ArsipSuratController extends Controller
{
    private function resource(): array
    {
        return [
            'title' => 'Arsip Surat',
            'singular' => 'arsip surat',
            'route' => 'admin.arsip-surat',
            'description' => 'Kelola arsip surat yang diterbitkan desa.',
        ];
    }

    private function columns(): array
    {
        return [
            ['label' => 'Nomor surat', 'key' => 'nomor_surat', 'secondary' => 'perihal'],
            ['label' => 'Kategori', 'key' => 'kategoriSurat.nama_kategori'],
            ['label' => 'Penduduk', 'key' => 'penduduk.nama_lengkap'],
            ['label' => 'Tanggal', 'key' => 'tanggal_surat', 'type' => 'date'],
        ];
    }

    private function fields(): array
    {
        $kategori = KategoriSurat::orderBy('nama_kategori')->pluck('nama_kategori', 'id')->toArray();
        $penduduk = Penduduk::orderBy('nama_lengkap')->get()->mapWithKeys(fn (Penduduk $item) => [
            $item->id => $item->nik . ' - ' . $item->nama_lengkap,
        ])->toArray();

        return [
            ['name' => 'kategori_surat_id', 'label' => 'Kategori surat', 'type' => 'select', 'options' => $kategori, 'required' => true],
            ['name' => 'penduduk_id', 'label' => 'Penduduk', 'type' => 'select', 'options' => $penduduk, 'required' => true],
            ['name' => 'nomor_surat', 'label' => 'Nomor surat', 'type' => 'text', 'required' => true],
            ['name' => 'tanggal_surat', 'label' => 'Tanggal surat', 'type' => 'date', 'required' => true],
            ['name' => 'perihal', 'label' => 'Perihal', 'type' => 'text', 'required' => true],
            ['name' => 'file_path', 'label' => 'Path file', 'type' => 'text', 'required' => true],
            ['name' => 'keterangan', 'label' => 'Keterangan', 'type' => 'textarea', 'rows' => 5],
        ];
    }

    public function index()
    {
        $arsipSurat = ArsipSurat::with(['kategoriSurat', 'penduduk'])->latest()->get();

        return view('admin.resources.index', [
            'resource' => $this->resource(),
            'items' => $arsipSurat,
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
            'kategori_surat_id' => ['required', 'exists:kategori_surat,id'],
            'penduduk_id' => ['required', 'exists:penduduk,id'],
            'nomor_surat' => ['required', 'string', 'max:100', 'unique:arsip_surat,nomor_surat'],
            'tanggal_surat' => ['required', 'date'],
            'perihal' => ['required', 'string', 'max:200'],
            'keterangan' => ['nullable', 'string'],
            'file_path' => ['required', 'string', 'max:255'],
        ]);

        ArsipSurat::create($data);

        return redirect()->route('admin.arsip-surat.index')
            ->with('success', 'Arsip surat berhasil ditambahkan.');
    }

    public function show(ArsipSurat $arsipSurat)
    {
        $arsipSurat->load(['kategoriSurat', 'penduduk']);

        return view('admin.resources.show', [
            'resource' => $this->resource(),
            'item' => $arsipSurat,
            'fields' => $this->fields(),
        ]);
    }

    public function edit(ArsipSurat $arsipSurat)
    {
        return view('admin.resources.form', [
            'resource' => $this->resource(),
            'fields' => $this->fields(),
            'item' => $arsipSurat,
        ]);
    }

    public function update(Request $request, ArsipSurat $arsipSurat)
    {
        $data = $request->validate([
            'kategori_surat_id' => ['required', 'exists:kategori_surat,id'],
            'penduduk_id' => ['required', 'exists:penduduk,id'],
            'nomor_surat' => ['required', 'string', 'max:100', Rule::unique('arsip_surat', 'nomor_surat')->ignore($arsipSurat->id)],
            'tanggal_surat' => ['required', 'date'],
            'perihal' => ['required', 'string', 'max:200'],
            'keterangan' => ['nullable', 'string'],
            'file_path' => ['required', 'string', 'max:255'],
        ]);

        $arsipSurat->update($data);

        return redirect()->route('admin.arsip-surat.index')
            ->with('success', 'Arsip surat berhasil diperbarui.');
    }

    public function destroy(ArsipSurat $arsipSurat)
    {
        $arsipSurat->delete();

        return redirect()->route('admin.arsip-surat.index')
            ->with('success', 'Arsip surat berhasil dihapus.');
    }
}
