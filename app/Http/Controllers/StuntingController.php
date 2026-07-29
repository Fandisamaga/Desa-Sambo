<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\Stunting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StuntingController extends Controller
{
    private function resource(): array
    {
        return [
            'title' => 'Stunting',
            'singular' => 'stunting',
            'route' => 'admin.stunting',
            'description' => 'Kelola data stunting berdasarkan penduduk yang terdaftar.',
        ];
    }

    private function columns(): array
    {
        return [
            ['label' => 'NIK', 'key' => 'penduduk.nik'],
            ['label' => 'Nama', 'key' => 'penduduk.nama_lengkap'],
            ['label' => 'Tanggal diagnosa', 'key' => 'tanggal_diagnosa', 'type' => 'date'],
            ['label' => 'Keterangan', 'key' => 'keterangan'],
        ];
    }

    private function fields(): array
    {
        $pendudukOptions = Penduduk::query()
            ->orderBy('nama_lengkap')
            ->get()
            ->mapWithKeys(fn (Penduduk $item) => [
                $item->id => $item->nik . ' - ' . $item->nama_lengkap,
            ])
            ->toArray();

        return [
            ['name' => 'penduduk_id', 'label' => 'Pilih anak/penderita', 'type' => 'select', 'options' => $pendudukOptions, 'required' => true],
            ['name' => 'tanggal_diagnosa', 'label' => 'Tanggal diagnosa', 'type' => 'date', 'required' => true],
            ['name' => 'keterangan', 'label' => 'Keterangan tambahan', 'type' => 'textarea', 'rows' => 4],
        ];
    }

    public function index()
    {
        $items = Stunting::with('penduduk')->latest()->get();

        return view('admin.resources.index', [
            'resource' => $this->resource(),
            'items' => $items,
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
            'penduduk_id' => ['required', 'exists:penduduk,id'],
            'tanggal_diagnosa' => ['required', 'date'],
            'keterangan' => ['nullable', 'string'],
        ]);

        Stunting::create($data);

        return redirect()->route('admin.stunting.index')
            ->with('success', 'Data stunting berhasil ditambahkan.');
    }

    public function show(Stunting $stunting)
    {
        return view('admin.resources.show', [
            'resource' => $this->resource(),
            'item' => $stunting,
            'fields' => [
                ['name' => 'penduduk.nik', 'label' => 'NIK', 'type' => 'text'],
                ['name' => 'penduduk.nama_lengkap', 'label' => 'Nama', 'type' => 'text'],
                ['name' => 'penduduk.tempat_lahir', 'label' => 'Tempat lahir', 'type' => 'text'],
                ['name' => 'penduduk.tanggal_lahir', 'label' => 'Tanggal lahir', 'type' => 'date'],
                ['name' => 'penduduk.jenis_kelamin', 'label' => 'Jenis kelamin', 'type' => 'text'],
                ['name' => 'penduduk.agama', 'label' => 'Agama', 'type' => 'text'],
                ['name' => 'penduduk.pendidikan', 'label' => 'Pendidikan', 'type' => 'text'],
                ['name' => 'penduduk.status_kawin', 'label' => 'Status kawin', 'type' => 'text'],
                ['name' => 'penduduk.status_keluarga', 'label' => 'Status keluarga', 'type' => 'text'],
                ['name' => 'tanggal_diagnosa', 'label' => 'Tanggal diagnosa', 'type' => 'date'],
                ['name' => 'keterangan', 'label' => 'Keterangan tambahan', 'type' => 'text'],
            ],
        ]);
    }

    public function edit(Stunting $stunting)
    {
        return view('admin.resources.form', [
            'resource' => $this->resource(),
            'fields' => $this->fields(),
            'item' => $stunting,
        ]);
    }

    public function update(Request $request, Stunting $stunting)
    {
        $data = $request->validate([
            'penduduk_id' => ['required', 'exists:penduduk,id'],
            'tanggal_diagnosa' => ['required', 'date'],
            'keterangan' => ['nullable', 'string'],
        ]);

        $stunting->update($data);

        return redirect()->route('admin.stunting.index')
            ->with('success', 'Data stunting berhasil diperbarui.');
    }

    public function destroy(Stunting $stunting)
    {
        $stunting->delete();

        return redirect()->route('admin.stunting.index')
            ->with('success', 'Data stunting berhasil dihapus.');
    }
}
