<?php

namespace App\Http\Controllers;

use App\Models\Apbdes;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ApbdesController extends Controller
{
    public function index()
    {
        $apbdes = Apbdes::latest('tahun')->get();

        return view('apbdes.index', compact('apbdes'));
    }

    public function create()
    {
        return view('apbdes.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tahun' => ['required', 'integer', 'min:1900', Rule::unique('apbdes', 'tahun')],
            'pendapatan' => ['nullable', 'integer', 'min:0'],
            'belanja' => ['nullable', 'integer', 'min:0'],
            'penerimaan_pembiayaan' => ['nullable', 'integer', 'min:0'],
            'pengeluaran_pembiayaan' => ['nullable', 'integer', 'min:0'],
        ]);

        $data = array_merge($data, [
            'pendapatan' => $data['pendapatan'] ?? 0,
            'belanja' => $data['belanja'] ?? 0,
            'penerimaan_pembiayaan' => $data['penerimaan_pembiayaan'] ?? 0,
            'pengeluaran_pembiayaan' => $data['pengeluaran_pembiayaan'] ?? 0,
        ]);

        Apbdes::create($data);

        return redirect()->route('apbdes.index')
            ->with('success', 'Data APBDes berhasil ditambahkan.');
    }

    public function show(Apbdes $apbde)
    {
        return view('apbdes.show', compact('apbde'));
    }

    public function edit(Apbdes $apbde)
    {
        return view('apbdes.edit', compact('apbde'));
    }

    public function update(Request $request, Apbdes $apbde)
    {
        $data = $request->validate([
            'tahun' => ['required', 'integer', 'min:1900', Rule::unique('apbdes', 'tahun')->ignore($apbde->id)],
            'pendapatan' => ['nullable', 'integer', 'min:0'],
            'belanja' => ['nullable', 'integer', 'min:0'],
            'penerimaan_pembiayaan' => ['nullable', 'integer', 'min:0'],
            'pengeluaran_pembiayaan' => ['nullable', 'integer', 'min:0'],
        ]);

        $data = array_merge($data, [
            'pendapatan' => $data['pendapatan'] ?? 0,
            'belanja' => $data['belanja'] ?? 0,
            'penerimaan_pembiayaan' => $data['penerimaan_pembiayaan'] ?? 0,
            'pengeluaran_pembiayaan' => $data['pengeluaran_pembiayaan'] ?? 0,
        ]);

        $apbde->update($data);

        return redirect()->route('apbdes.index')
            ->with('success', 'Data APBDes berhasil diperbarui.');
    }

    public function destroy(Apbdes $apbde)
    {
        $apbde->delete();

        return redirect()->route('apbdes.index')
            ->with('success', 'Data APBDes berhasil dihapus.');
    }
}
