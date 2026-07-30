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
use Illuminate\Support\Facades\Route;
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
            'tanggal_upload' => '2026-07-19',
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
            $this->actingAs($admin)->get(route($route . '.show', $model))->assertOk();

            if ($route === 'admin.pengaduan') {
                $this->actingAs($admin)->get(route($route . '.create'))->assertRedirect(route($route . '.index'));
                $this->actingAs($admin)->get(route($route . '.edit', $model))->assertRedirect(route($route . '.show', $model));
            } else {
                $this->actingAs($admin)->get(route($route . '.create'))->assertOk();
                $this->actingAs($admin)->get(route($route . '.edit', $model))->assertOk();
            }
        }

        $this->assertFalse(Route::has('admin.kategori-berita.index'));

        $this->actingAs($admin)
            ->get(route('admin.berita.create'))
            ->assertOk()
            ->assertDontSee('Kategori');

        $this->actingAs($admin)
            ->post(route('admin.berita.store'), [
                'judul' => 'Berita Baru Tanpa Pilih Kategori',
                'tanggal_upload' => '2026-07-30',
                'konten' => 'Konten berita baru.',
                'status' => 'publish',
            ])
            ->assertRedirect(route('admin.berita.index'));

        $this->assertDatabaseHas('berita', [
            'judul' => 'Berita Baru Tanpa Pilih Kategori',
            'kategori_berita_id' => KategoriBerita::where('slug', 'berita-desa')->value('id'),
        ]);
    }

    public function test_public_berita_page_displays_published_news(): void
    {
        $kategoriBerita = KategoriBerita::create(['nama_kategori' => 'Kabar Desa', 'slug' => 'kabar-desa']);

        $publishedBerita = Berita::create([
            'kategori_berita_id' => $kategoriBerita->id,
            'judul' => 'Musyawarah Desa',
            'slug' => 'musyawarah-desa',
            'konten' => 'Warga dan perangkat desa membahas program prioritas.',
            'status' => 'publish',
            'tanggal_upload' => '2026-07-19',
        ]);

        $draftBerita = Berita::create([
            'kategori_berita_id' => $kategoriBerita->id,
            'judul' => 'Catatan Internal',
            'slug' => 'catatan-internal',
            'konten' => 'Belum dipublikasikan.',
            'status' => 'draft',
            'tanggal_upload' => '2026-07-20',
        ]);

        $this->get(route('berita'))
            ->assertOk()
            ->assertSee('Berita Desa Sambo')
            ->assertSee('Musyawarah Desa')
            ->assertSee('19 Juli 2026')
            ->assertSee(route('berita.detail', $publishedBerita->slug), false)
            ->assertDontSee('Kategori')
            ->assertDontSee('Kabar Desa')
            ->assertDontSee('Catatan Internal');

        $this->get(route('berita.detail', $publishedBerita->slug))
            ->assertOk()
            ->assertSee('Warga dan perangkat desa membahas program prioritas.')
            ->assertDontSee('Kabar Desa');

        $this->get(route('berita.detail', $draftBerita->slug))->assertNotFound();
    }

    public function test_public_layanan_page_records_pengaduan(): void
    {
        $this->get(route('layanan'))
            ->assertOk()
            ->assertSee('Layanan Pengaduan Desa Sambo')
            ->assertSee('Pengaduan masuk')
            ->assertDontSee('Surat Pengantar');

        $this->post(route('layanan.pengaduan.store'), [
            'nama_pengirim' => 'Warga Sambo',
            'kontak_pengirim' => '081234567890',
            'isi_aduan' => 'Lampu jalan di dusun satu perlu diperbaiki.',
        ])->assertRedirect(route('layanan.pengaduan'));

        $this->assertDatabaseHas('pengaduan', [
            'nama_pengirim' => 'Warga Sambo',
            'kontak_pengirim' => '081234567890',
            'status' => 'pending',
            'catatan_admin' => null,
        ]);
    }

    public function test_public_ppid_page_displays_dokumen_publik_records(): void
    {
        DokumenPublik::create([
            'judul_dokumen' => 'Laporan Desa',
            'file_path' => 'dokumen/laporan.pdf',
            'tahun' => 2026,
        ]);

        $this->get(route('ppid'))
            ->assertOk()
            ->assertSee('PPID Desa Sambo')
            ->assertSee('Laporan Desa')
            ->assertSee('Dokumen tahun 2026')
            ->assertSee('/storage/dokumen/laporan.pdf', false);
    }
}
