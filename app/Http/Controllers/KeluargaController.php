<?php

namespace App\Http\Controllers;

use App\Models\KartuKeluarga;
use Illuminate\Http\Request;

class KeluargaController extends Controller
{
    /**
     * Menampilkan seluruh data KK.
     */
    public function index()
    {
        $data = KartuKeluarga::latest()->paginate(10);

        return view('kartu-keluarga.index', compact('data'));
    }

    /**
     * Form tambah data.
     */
    public function create()
    {
        return view('kartu-keluarga.create');
    }

    /**
     * Simpan data.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_kk' => 'required|digits:16|unique:kartu_keluarga,no_kk',
            'alamat' => 'required|string',
            'rt' => 'nullable|max:3',
            'rw' => 'required|max:3',
            'dusun' => 'required|max:100',
        ]);

        KartuKeluarga::create($validated);

        return redirect()
            ->route('kartu-keluarga.index')
            ->with('success', 'Data KK berhasil ditambahkan.');
    }

    /**
     * Detail data.
     */
    public function show(KartuKeluarga $kartuKeluarga)
    {
        return view('kartu-keluarga.show', compact('kartuKeluarga'));
    }

    /**
     * Form edit.
     */
    public function edit(KartuKeluarga $kartuKeluarga)
    {
        return view('kartu-keluarga.edit', compact('kartuKeluarga'));
    }

    /**
     * Update data.
     */
    public function update(Request $request, KartuKeluarga $kartuKeluarga)
    {
        $validated = $request->validate([
            'no_kk' => 'required|digits:16|unique:kartu_keluarga,no_kk,' . $kartuKeluarga->id,
            'alamat' => 'required|string',
            'rt' => 'nullable|max:3',
            'rw' => 'required|max:3',
            'dusun' => 'required|max:100',
        ]);

        $kartuKeluarga->update($validated);

        return redirect()
            ->route('kartu-keluarga.index')
            ->with('success', 'Data KK berhasil diperbarui.');
    }

    /**
     * Hapus data.
     */
    public function destroy(KartuKeluarga $kartuKeluarga)
    {
        $kartuKeluarga->delete();

        return redirect()
            ->route('kartu-keluarga.index')
            ->with('success', 'Data KK berhasil dihapus.');
    }
}