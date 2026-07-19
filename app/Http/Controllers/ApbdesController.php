<?php

namespace App\Http\Controllers;

use App\Models\Apbdes;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ApbdesController extends Controller
{
    private function resource(): array
    {
        return [
            'title' => 'APBDes',
            'singular' => 'data APBDes',
            'route' => 'admin.apbdes',
            'description' => 'Kelola data anggaran pendapatan dan belanja desa.',
        ];
    }

    private function columns(): array
    {
        return [
            ['label' => 'Tahun', 'key' => 'tahun'],
            ['label' => 'Pendapatan', 'key' => 'pendapatan', 'type' => 'money'],
            ['label' => 'Belanja', 'key' => 'belanja', 'type' => 'money'],
            ['label' => 'Diperbarui', 'key' => 'updated_at', 'type' => 'date'],
        ];
    }

    private function fields(): array
    {
        return [
            ['name' => 'tahun', 'label' => 'Tahun', 'type' => 'number', 'min' => 1900, 'required' => true],
            ['name' => 'pendapatan', 'label' => 'Pendapatan', 'type' => 'number', 'min' => 0, 'default' => 0],
            ['name' => 'belanja', 'label' => 'Belanja', 'type' => 'number', 'min' => 0, 'default' => 0],
            ['name' => 'penerimaan_pembiayaan', 'label' => 'Penerimaan pembiayaan', 'type' => 'number', 'min' => 0, 'default' => 0],
            ['name' => 'pengeluaran_pembiayaan', 'label' => 'Pengeluaran pembiayaan', 'type' => 'number', 'min' => 0, 'default' => 0],
        ];
    }

    public function index()
    {
        $apbdes = Apbdes::latest('tahun')->get();

        return view('admin.resources.index', [
            'resource' => $this->resource(),
            'items' => $apbdes,
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

        return redirect()->route('admin.apbdes.index')
            ->with('success', 'Data APBDes berhasil ditambahkan.');
    }

    public function show(Apbdes $apbde)
    {
        return view('admin.resources.show', [
            'resource' => $this->resource(),
            'item' => $apbde,
            'fields' => $this->fields(),
        ]);
    }

    public function edit(Apbdes $apbde)
    {
        return view('admin.resources.form', [
            'resource' => $this->resource(),
            'fields' => $this->fields(),
            'item' => $apbde,
        ]);
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

        return redirect()->route('admin.apbdes.index')
            ->with('success', 'Data APBDes berhasil diperbarui.');
    }

    public function destroy(Apbdes $apbde)
    {
        $apbde->delete();

        return redirect()->route('admin.apbdes.index')
            ->with('success', 'Data APBDes berhasil dihapus.');
    }
}
