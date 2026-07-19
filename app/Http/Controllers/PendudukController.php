<?php

namespace App\Http\Controllers;

use App\Models\KartuKeluarga;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PendudukController extends Controller
{
    private function resource(): array
    {
        return [
            'title' => 'Penduduk',
            'singular' => 'penduduk',
            'route' => 'admin.penduduk',
            'description' => 'Kelola biodata penduduk yang terhubung dengan kartu keluarga.',
        ];
    }

    private function columns(): array
    {
        return [
            ['label' => 'Nama', 'key' => 'nama_lengkap', 'secondary' => 'nik'],
            ['label' => 'KK', 'key' => 'kartuKeluarga.no_kk'],
            ['label' => 'Jenis kelamin', 'key' => 'jenis_kelamin'],
            ['label' => 'Status keluarga', 'key' => 'status_keluarga'],
        ];
    }

    private function fields(): array
    {
        $kartuKeluarga = KartuKeluarga::orderBy('no_kk')->get()->mapWithKeys(fn (KartuKeluarga $item) => [
            $item->id => $item->no_kk . ' - ' . $item->dusun,
        ])->toArray();

        return [
            ['name' => 'kartu_keluarga_id', 'label' => 'Kartu keluarga', 'type' => 'select', 'options' => $kartuKeluarga, 'required' => true],
            ['name' => 'nik', 'label' => 'NIK', 'type' => 'text', 'required' => true],
            ['name' => 'nama_lengkap', 'label' => 'Nama lengkap', 'type' => 'text', 'required' => true],
            ['name' => 'tempat_lahir', 'label' => 'Tempat lahir', 'type' => 'text', 'required' => true],
            ['name' => 'tanggal_lahir', 'label' => 'Tanggal lahir', 'type' => 'date', 'required' => true],
            ['name' => 'jenis_kelamin', 'label' => 'Jenis kelamin', 'type' => 'select', 'options' => ['Laki-laki' => 'Laki-laki', 'Perempuan' => 'Perempuan'], 'required' => true],
            ['name' => 'agama', 'label' => 'Agama', 'type' => 'text', 'required' => true],
            ['name' => 'pendidikan', 'label' => 'Pendidikan', 'type' => 'text', 'required' => true],
            ['name' => 'pekerjaan', 'label' => 'Pekerjaan', 'type' => 'text', 'required' => true],
            ['name' => 'status_kawin', 'label' => 'Status kawin', 'type' => 'text', 'required' => true],
            ['name' => 'status_keluarga', 'label' => 'Status keluarga', 'type' => 'text', 'required' => true],
        ];
    }

    public function index()
    {
        $penduduks = Penduduk::with('kartuKeluarga')->latest()->get();

        return view('admin.resources.index', [
            'resource' => $this->resource(),
            'items' => $penduduks,
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
            'kartu_keluarga_id' => ['required', 'exists:kartu_keluarga,id'],
            'nik' => ['required', 'string', 'max:16', 'unique:penduduk,nik'],
            'nama_lengkap' => ['required', 'string', 'max:150'],
            'tempat_lahir' => ['required', 'string', 'max:100'],
            'tanggal_lahir' => ['required', 'date'],
            'jenis_kelamin' => ['required', 'string', 'max:20'],
            'agama' => ['required', 'string', 'max:50'],
            'pendidikan' => ['required', 'string', 'max:100'],
            'pekerjaan' => ['required', 'string', 'max:100'],
            'status_kawin' => ['required', 'string', 'max:50'],
            'status_keluarga' => ['required', 'string', 'max:50'],
        ]);

        Penduduk::create($data);

        return redirect()->route('admin.penduduk.index')
            ->with('success', 'Data penduduk berhasil ditambahkan.');
    }

    public function show(Penduduk $penduduk)
    {
        $penduduk->load('kartuKeluarga');

        return view('admin.resources.show', [
            'resource' => $this->resource(),
            'item' => $penduduk,
            'fields' => $this->fields(),
        ]);
    }

    public function edit(Penduduk $penduduk)
    {
        return view('admin.resources.form', [
            'resource' => $this->resource(),
            'fields' => $this->fields(),
            'item' => $penduduk,
        ]);
    }

    public function update(Request $request, Penduduk $penduduk)
    {
        $data = $request->validate([
            'kartu_keluarga_id' => ['required', 'exists:kartu_keluarga,id'],
            'nik' => ['required', 'string', 'max:16', Rule::unique('penduduk', 'nik')->ignore($penduduk->id)],
            'nama_lengkap' => ['required', 'string', 'max:150'],
            'tempat_lahir' => ['required', 'string', 'max:100'],
            'tanggal_lahir' => ['required', 'date'],
            'jenis_kelamin' => ['required', 'string', 'max:20'],
            'agama' => ['required', 'string', 'max:50'],
            'pendidikan' => ['required', 'string', 'max:100'],
            'pekerjaan' => ['required', 'string', 'max:100'],
            'status_kawin' => ['required', 'string', 'max:50'],
            'status_keluarga' => ['required', 'string', 'max:50'],
        ]);

        $penduduk->update($data);

        return redirect()->route('admin.penduduk.index')
            ->with('success', 'Data penduduk berhasil diperbarui.');
    }

    public function destroy(Penduduk $penduduk)
    {
        $penduduk->delete();

        return redirect()->route('admin.penduduk.index')
            ->with('success', 'Data penduduk berhasil dihapus.');
    }
}
