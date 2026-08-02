<?php

namespace App\Http\Controllers;

use App\Models\DokumenPublik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DokumenPublikController extends Controller
{
    private function resource(): array
    {
        return [
            'title' => 'Dokumen Publik',
            'singular' => 'dokumen',
            'route' => 'admin.dokumen-publik',
            'description' => 'Kelola dokumen publik yang dapat diakses masyarakat.',
        ];
    }

    private function columns(): array
    {
        return [
            ['label' => 'Dokumen', 'key' => 'judul_dokumen', 'secondary' => 'file_path'],
            ['label' => 'Tahun', 'key' => 'tahun'],
            ['label' => 'Diperbarui', 'key' => 'updated_at', 'type' => 'date'],
        ];
    }

    private function fields(): array
    {
        return [
            ['name' => 'judul_dokumen', 'label' => 'Judul dokumen', 'type' => 'text', 'required' => true],
            ['name' => 'tahun', 'label' => 'Tahun', 'type' => 'number', 'min' => 1900, 'required' => true],
            ['name' => 'file_path', 'label' => 'File dokumen', 'type' => 'file', 'accept' => '.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip', 'current_path' => 'file_path', 'required' => true],
        ];
    }

    public function index()
    {
        $dokumenPublik = DokumenPublik::latest('tahun')->paginate(10);

        return view('admin.resources.index', [
            'resource' => $this->resource(),
            'items' => $dokumenPublik,
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
            'judul_dokumen' => ['required', 'string', 'max:200'],
            'file_path' => ['required', 'file', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip', 'max:20480'],
            'tahun' => ['required', 'integer', 'min:1900'],
        ]);

        $data['file_path'] = $this->storeDocumentFile($request->file('file_path'), $data['judul_dokumen']);

        DokumenPublik::create($data);

        return redirect()->route('admin.dokumen-publik.index')
            ->with('success', 'Dokumen publik berhasil ditambahkan.');
    }

    public function show(DokumenPublik $dokumenPublik)
    {
        return view('admin.resources.show', [
            'resource' => $this->resource(),
            'item' => $dokumenPublik,
            'fields' => $this->fields(),
        ]);
    }

    public function edit(DokumenPublik $dokumenPublik)
    {
        return view('admin.resources.form', [
            'resource' => $this->resource(),
            'fields' => $this->fields(),
            'item' => $dokumenPublik,
        ]);
    }

    public function update(Request $request, DokumenPublik $dokumenPublik)
    {
        $data = $request->validate([
            'judul_dokumen' => ['required', 'string', 'max:200'],
            'file_path' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip', 'max:20480'],
            'tahun' => ['required', 'integer', 'min:1900'],
        ]);

        if ($request->hasFile('file_path')) {
            if ($dokumenPublik->file_path && Storage::disk('public')->exists($dokumenPublik->file_path)) {
                Storage::disk('public')->delete($dokumenPublik->file_path);
            }

            $data['file_path'] = $this->storeDocumentFile($request->file('file_path'), $data['judul_dokumen']);
        } elseif ($dokumenPublik->file_path && $dokumenPublik->judul_dokumen !== $data['judul_dokumen']) {
            $data['file_path'] = $this->renameDocumentFile($dokumenPublik->file_path, $data['judul_dokumen']);
        } else {
            unset($data['file_path']);
        }

        $dokumenPublik->update($data);

        return redirect()->route('admin.dokumen-publik.index')
            ->with('success', 'Dokumen publik berhasil diperbarui.');
    }

    public function destroy(DokumenPublik $dokumenPublik)
    {
        if ($dokumenPublik->file_path && Storage::disk('public')->exists($dokumenPublik->file_path)) {
            Storage::disk('public')->delete($dokumenPublik->file_path);
        }

        $dokumenPublik->delete();

        return redirect()->route('admin.dokumen-publik.index')
            ->with('success', 'Dokumen publik berhasil dihapus.');
    }

    private function storeDocumentFile($file, string $title): string
    {
        $baseName = Str::slug($title) ?: 'dokumen-publik';
        $extension = $file->getClientOriginalExtension() ?: $file->extension();
        $filename = sprintf('%s.%s', $baseName, $extension);
        $path = 'dokumen-publik/' . $filename;
        $counter = 1;

        while (Storage::disk('public')->exists($path)) {
            $filename = sprintf('%s-%s.%s', $baseName, $counter++, $extension);
            $path = 'dokumen-publik/' . $filename;
        }

        return $file->storeAs('dokumen-publik', basename($path), 'public');
    }

    private function renameDocumentFile(string $currentPath, string $title): string
    {
        if (! Storage::disk('public')->exists($currentPath)) {
            return $currentPath;
        }

        $extension = pathinfo($currentPath, PATHINFO_EXTENSION) ?: 'pdf';
        $baseName = Str::slug($title) ?: 'dokumen-publik';
        $newFilename = sprintf('%s.%s', $baseName, $extension);
        $newPath = 'dokumen-publik/' . $newFilename;
        $counter = 1;

        while (Storage::disk('public')->exists($newPath) && $newPath !== $currentPath) {
            $newFilename = sprintf('%s-%s.%s', $baseName, $counter++, $extension);
            $newPath = 'dokumen-publik/' . $newFilename;
        }

        if ($newPath !== $currentPath) {
            Storage::disk('public')->move($currentPath, $newPath);
        }

        return $newPath;
    }
}
