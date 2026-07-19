<?php

namespace Tests\Feature;

use App\Models\Apbdes;
use App\Models\ArsipSurat;
use App\Models\Berita;
use App\Models\DokumenPublik;
use App\Models\KartuKeluarga;
use App\Models\KategoriBerita;
use App\Models\KategoriSurat;
use App\Models\Penduduk;
use App\Models\Pengaduan;
use App\Models\ProdukUmkm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCrudViewsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_crud_views_are_connected_to_resource_routes(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $kategoriBerita = KategoriBerita::create(['nama_kategori' => 'Kabar Desa', 'slug' => 'kabar-desa']);
        $berita = Berita::create([
            'kategori_berita_id' => $kategoriBerita->id,
            'judul' => 'Musyawarah Desa',
            'slug' => 'musyawarah-desa',
            'konten' => 'Konten berita desa.',
            'status' => 'publish',
        ]);

        $produk = ProdukUmkm::create(['nama_produk' => 'Kopi Sambo', 'harga' => 25000]);
        $apbdes = Apbdes::create(['tahun' => 2026, 'pendapatan' => 1000000, 'belanja' => 750000]);

        $kategoriSurat = KategoriSurat::create(['nama_kategori' => 'Domisili']);
        $kartuKeluarga = KartuKeluarga::create([
            'no_kk' => '1234567890123456',
            'alamat' => 'Dusun Sambo',
            'rt' => '001',
            'rw' => '002',
            'dusun' => 'Sambo',
        ]);
        $penduduk = Penduduk::create([
            'kartu_keluarga_id' => $kartuKeluarga->id,
            'nik' => '1234567890123456',
            'nama_lengkap' => 'Warga Sambo',
            'tempat_lahir' => 'Sambo',
            'tanggal_lahir' => '2000-01-01',
            'jenis_kelamin' => 'Laki-laki',
            'agama' => 'Islam',
            'pendidikan' => 'SMA',
            'pekerjaan' => 'Petani',
            'status_kawin' => 'Belum kawin',
            'status_keluarga' => 'Anak',
        ]);
        $arsipSurat = ArsipSurat::create([
            'kategori_surat_id' => $kategoriSurat->id,
            'penduduk_id' => $penduduk->id,
            'nomor_surat' => '001/DS/VII/2026',
            'tanggal_surat' => '2026-07-19',
            'perihal' => 'Surat Domisili',
            'file_path' => 'arsip/domisili.pdf',
        ]);

        $pengaduan = Pengaduan::create([
            'nama_pengirim' => 'Warga',
            'kontak_pengirim' => '08123456789',
            'isi_aduan' => 'Lampu jalan perlu diperbaiki.',
            'status' => 'pending',
        ]);
        $dokumen = DokumenPublik::create([
            'judul_dokumen' => 'Laporan Desa',
            'file_path' => 'dokumen/laporan.pdf',
            'tahun' => 2026,
        ]);

        $this->actingAs($admin)->get(route('admin.dashboard'))->assertOk();
        $this->actingAs($admin)->get(route('admin.layanan.index'))->assertRedirect('/admin/pengaduan');

        foreach ([
            'admin.berita' => $berita,
            'admin.kategori-berita' => $kategoriBerita,
            'admin.produk-umkm' => $produk,
            'admin.apbdes' => $apbdes,
            'admin.kategori-surat' => $kategoriSurat,
            'admin.kartu-keluarga' => $kartuKeluarga,
            'admin.penduduk' => $penduduk,
            'admin.arsip-surat' => $arsipSurat,
            'admin.pengaduan' => $pengaduan,
            'admin.dokumen-publik' => $dokumen,
        ] as $route => $model) {
            $this->actingAs($admin)->get(route($route . '.index'))->assertOk();
            $this->actingAs($admin)->get(route($route . '.create'))->assertOk();
            $this->actingAs($admin)->get(route($route . '.show', $model))->assertOk();
            $this->actingAs($admin)->get(route($route . '.edit', $model))->assertOk();
        }
    }
}
