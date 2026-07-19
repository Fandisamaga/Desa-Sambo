<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    private function resource(): array
    {
        return [
            'title' => 'Pengaduan Masyarakat',
            'singular' => 'pengaduan',
            'route' => 'admin.pengaduan',
            'description' => 'Kelola laporan dan tindak lanjut pengaduan masyarakat.',
        ];
    }

    private function columns(): array
    {
        return [
            ['label' => 'Pengirim', 'key' => 'nama_pengirim', 'secondary' => 'kontak_pengirim'],
            ['label' => 'Status', 'key' => 'status', 'type' => 'badge'],
            ['label' => 'Masuk', 'key' => 'created_at', 'type' => 'date'],
        ];
    }

    private function fields(): array
    {
        return [
            ['name' => 'nama_pengirim', 'label' => 'Nama pengirim', 'type' => 'text', 'required' => true],
            ['name' => 'kontak_pengirim', 'label' => 'Kontak pengirim', 'type' => 'text', 'required' => true],
            ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => ['pending' => 'Pending', 'diproses' => 'Diproses', 'selesai' => 'Selesai', 'ditolak' => 'Ditolak'], 'default' => 'pending', 'required' => true],
            ['name' => 'isi_aduan', 'label' => 'Isi aduan', 'type' => 'textarea', 'rows' => 7, 'required' => true],
            ['name' => 'catatan_admin', 'label' => 'Catatan admin', 'type' => 'textarea', 'rows' => 5],
        ];
    }

    public function index()
    {
        $pengaduan = Pengaduan::latest()->paginate(10);

        return view('admin.resources.index', [
            'resource' => $this->resource(),
            'items' => $pengaduan,
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
            'nama_pengirim' => ['required', 'string', 'max:100'],
            'kontak_pengirim' => ['required', 'string', 'max:50'],
            'isi_aduan' => ['required', 'string'],
            'status' => ['required', 'in:pending,diproses,selesai,ditolak'],
            'catatan_admin' => ['nullable', 'string'],
        ]);

        Pengaduan::create($data);

        return redirect()->route('admin.pengaduan.index')
            ->with('success', 'Pengaduan berhasil ditambahkan.');
    }

    public function show(Pengaduan $pengaduan)
    {
        return view('admin.resources.show', [
            'resource' => $this->resource(),
            'item' => $pengaduan,
            'fields' => $this->fields(),
        ]);
    }

    public function edit(Pengaduan $pengaduan)
    {
        return view('admin.resources.form', [
            'resource' => $this->resource(),
            'fields' => $this->fields(),
            'item' => $pengaduan,
        ]);
    }

    public function update(Request $request, Pengaduan $pengaduan)
    {
        $data = $request->validate([
            'nama_pengirim' => ['required', 'string', 'max:100'],
            'kontak_pengirim' => ['required', 'string', 'max:50'],
            'isi_aduan' => ['required', 'string'],
            'status' => ['required', 'in:pending,diproses,selesai,ditolak'],
            'catatan_admin' => ['nullable', 'string'],
        ]);

        $pengaduan->update($data);

        return redirect()->route('admin.pengaduan.index')
            ->with('success', 'Pengaduan berhasil diperbarui.');
    }

    public function destroy(Pengaduan $pengaduan)
    {
        $pengaduan->delete();

        return redirect()->route('admin.pengaduan.index')
            ->with('success', 'Pengaduan berhasil dihapus.');
    }
}
