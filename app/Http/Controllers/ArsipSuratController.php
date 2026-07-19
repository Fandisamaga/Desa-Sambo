<?php

namespace App\Http\Controllers;

use App\Models\ArsipSurat;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ArsipSuratController extends Controller
{
    public function index()
    {
        $arsipSurat = ArsipSurat::with(['kategoriSurat', 'penduduk'])->latest()->get();

        return view('arsip-surat.index', compact('arsipSurat'));
    }

    public function create()
    {
        return view('arsip-surat.create');
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

        return redirect()->route('arsip-surat.index')
            ->with('success', 'Arsip surat berhasil ditambahkan.');
    }

    public function show(ArsipSurat $arsipSurat)
    {
        return view('arsip-surat.show', compact('arsipSurat'));
    }

    public function edit(ArsipSurat $arsipSurat)
    {
        return view('arsip-surat.edit', compact('arsipSurat'));
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

        return redirect()->route('arsip-surat.index')
            ->with('success', 'Arsip surat berhasil diperbarui.');
    }

    public function destroy(ArsipSurat $arsipSurat)
    {
        $arsipSurat->delete();

        return redirect()->route('arsip-surat.index')
            ->with('success', 'Arsip surat berhasil dihapus.');
    }
}
