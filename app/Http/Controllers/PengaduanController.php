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
            'description' => 'Baca detail laporan masyarakat yang diajukan melalui layanan publik.',
            'can_create' => false,
            'can_edit' => false,
            'can_delete' => true,
        ];
    }

    private function columns(): array
    {
        return [
            ['label' => 'Pengirim', 'key' => 'nama_pengirim', 'secondary' => 'kontak_pengirim'],
            ['label' => 'Masuk', 'key' => 'created_at', 'type' => 'date'],
        ];
    }

    private function fields(): array
    {
        return [
            ['name' => 'nama_pengirim', 'label' => 'Nama pengirim', 'type' => 'text', 'required' => true],
            ['name' => 'kontak_pengirim', 'label' => 'Kontak pengirim', 'type' => 'text', 'required' => true],
            ['name' => 'isi_aduan', 'label' => 'Isi aduan', 'type' => 'textarea', 'rows' => 7, 'required' => true],
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
        return redirect()->route('admin.pengaduan.index');
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.pengaduan.index')
            ->with('info', 'Pengaduan hanya dapat dikirim oleh masyarakat melalui formulir layanan publik.');
    }

    public function storePublic(Request $request)
    {
        $data = $request->validate([
            'nama_pengirim' => ['required', 'string', 'max:100'],
            'kontak_pengirim' => ['required', 'string', 'max:50'],
            'isi_aduan' => ['required', 'string', 'min:10'],
        ]);

        Pengaduan::create([
            ...$data,
            'status' => 'pending',
            'catatan_admin' => null,
        ]);

        return redirect()->route('layanan.pengaduan')
            ->with('success', 'Pengaduan berhasil dikirim dan tersedia untuk dibaca oleh admin desa.');
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
        return redirect()->route('admin.pengaduan.show', $pengaduan);
    }

    public function update(Request $request, Pengaduan $pengaduan)
    {
        return redirect()->route('admin.pengaduan.show', $pengaduan)
            ->with('info', 'Pengaduan hanya dapat dibaca dari panel admin ini.');
    }

    public function destroy(Pengaduan $pengaduan)
    {
        $pengaduan->delete();

        return redirect()->route('admin.pengaduan.index')
            ->with('success', 'Pengaduan berhasil dihapus.');
    }
}
