<?php

namespace App\Http\Controllers;

use App\Models\KartuKeluarga;
use Illuminate\Http\Request;

class KeluargaController extends Controller
{
    private function resource(): array
    {
        return [
            'title' => 'Kartu Keluarga',
            'singular' => 'kartu keluarga',
            'route' => 'admin.kartu-keluarga',
            'description' => 'Kelola data kartu keluarga penduduk desa.',
        ];
    }

    private function columns(): array
    {
        return [
            ['label' => 'Nomor KK', 'key' => 'no_kk', 'secondary' => 'alamat'],
            ['label' => 'Dusun', 'key' => 'dusun'],
            ['label' => 'RT', 'key' => 'rt'],
            ['label' => 'RW', 'key' => 'rw'],
        ];
    }

    private function fields(): array
    {
        return [
            ['name' => 'no_kk', 'label' => 'Nomor KK', 'type' => 'text', 'required' => true],
            ['name' => 'dusun', 'label' => 'Dusun', 'type' => 'text', 'required' => true],
            ['name' => 'rt', 'label' => 'RT', 'type' => 'text'],
            ['name' => 'rw', 'label' => 'RW', 'type' => 'text', 'required' => true],
            ['name' => 'alamat', 'label' => 'Alamat', 'type' => 'textarea', 'rows' => 5, 'required' => true],
        ];
    }

    /**
     * Menampilkan seluruh data KK.
     */
    public function index()
    {
        $data = KartuKeluarga::latest()->paginate(10);

        return view('admin.resources.index', [
            'resource' => $this->resource(),
            'items' => $data,
            'columns' => $this->columns(),
        ]);
    }

    /**
     * Form tambah data.
     */
    public function create()
    {
        return view('admin.resources.form', [
            'resource' => $this->resource(),
            'fields' => $this->fields(),
        ]);
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
            ->route('admin.kartu-keluarga.index')
            ->with('success', 'Data KK berhasil ditambahkan.');
    }

    /**
     * Detail data.
     */
    public function show(KartuKeluarga $kartuKeluarga)
    {
        return view('admin.resources.show', [
            'resource' => $this->resource(),
            'item' => $kartuKeluarga,
            'fields' => $this->fields(),
        ]);
    }

    /**
     * Form edit.
     */
    public function edit(KartuKeluarga $kartuKeluarga)
    {
        return view('admin.resources.form', [
            'resource' => $this->resource(),
            'fields' => $this->fields(),
            'item' => $kartuKeluarga,
        ]);
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
            ->route('admin.kartu-keluarga.index')
            ->with('success', 'Data KK berhasil diperbarui.');
    }

    /**
     * Hapus data.
     */
    public function destroy(KartuKeluarga $kartuKeluarga)
    {
        $kartuKeluarga->delete();

        return redirect()
            ->route('admin.kartu-keluarga.index')
            ->with('success', 'Data KK berhasil dihapus.');
    }
}
