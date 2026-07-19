<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PendudukController extends Controller
{
    public function index()
    {
        $penduduks = Penduduk::with('kartuKeluarga')->latest()->get();

        return view('penduduk.index', compact('penduduks'));
    }

    public function create()
    {
        return view('penduduk.create');
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

        return redirect()->route('penduduk.index')
            ->with('success', 'Data penduduk berhasil ditambahkan.');
    }

    public function show(Penduduk $penduduk)
    {
        return view('penduduk.show', compact('penduduk'));
    }

    public function edit(Penduduk $penduduk)
    {
        return view('penduduk.edit', compact('penduduk'));
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

        return redirect()->route('penduduk.index')
            ->with('success', 'Data penduduk berhasil diperbarui.');
    }

    public function destroy(Penduduk $penduduk)
    {
        $penduduk->delete();

        return redirect()->route('penduduk.index')
            ->with('success', 'Data penduduk berhasil dihapus.');
    }
}