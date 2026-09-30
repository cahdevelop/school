<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

class BeritaController extends Controller
{
    public function index(): View
    {
        return view('berita.index', [
            'berita' => $this->terbaru(),
        ]);
    }

    /**
     * Daftar berita dari yang terbaru ke yang lama.
     *
     * Diurutkan berdasarkan tanggal, bukan urutan array, supaya beranda dan
     * halaman berita selalu konsisten begitu datanya digantikan model.
     */
    public function terbaru(int $limit = 0): Collection
    {
        $berita = Collection::make(self::dummy())
            ->sortByDesc('tanggal')
            ->values();

        return $limit > 0 ? $berita->take($limit) : $berita;
    }

    public function show(string $slug): View
    {
        $berita = $this->terbaru()->firstWhere('slug', $slug);

        abort_if($berita === null, 404, 'Berita tidak ditemukan.');

        return view('berita.show', [
            'berita' => $berita,
            'terbaru' => $this->terbaru()
                ->reject(fn (array $item) => $item['slug'] === $slug)
                ->take(3)
                ->values(),
        ]);
    }

    /**
     * Data berita sementara.
     *
     * TODO: ganti dengan model, contoh Berita::query()->latest()->paginate(9),
     *       begitu tabel `berita` tersedia. Yang perlu berubah hanya method ini.
     *
     * Field `gambar` berisi nama file di dalam public/images/berita/.
     * File placeholder dibuat oleh tools/make-placeholder-foto-berita.php.
     * Kalau file-nya dihapus, kartu otomatis memakai gradien kategori.
     *
     * @return array<int, array<string, string>>
     */
    private static function dummy(): array
    {
        return [
            [
                'slug' => 'penerimaan-siswa-baru-2026-2027',
                'judul' => 'Penerimaan Siswa Baru Tahun Ajaran 2026/2027',
                'kategori' => 'PPDB',
                'gambar' => 'penerimaan-siswa-baru.png',
                'ringkasan' => 'Pendaftaran gelombang pertama dibuka mulai 1 November dengan kuota terbatas.',
                'isi' => 'Sekolah membuka pendaftaran siswa baru untuk tahun ajaran 2026/2027. Gelombang pertama berlangsung mulai 1 November hingga 15 Desember dengan kuota 120 kursi untuk SD, 90 kursi untuk SMP, dan 60 kursi untuk SMA.',
                'penulis' => 'Panitia PPDB',
                'tanggal' => '2026-10-28',
            ],
            [
                'slug' => 'tim-volei-raih-juara-dua',
                'judul' => 'Tim Volei Raih Juara Dua Turnamen Provincial',
                'kategori' => 'Prestasi',
                'gambar' => 'tim-volei-juara-dua.png',
                'ringkasan' => 'Tim volei membawa pulang medali perak pada turnamen provincial 2026.',
                'isi' => 'Tim volei sekolah meraih medali perak pada turnamen provincial yang diikuti 32 sekolah. Pertandingan final berakhir ketat dengan skor 15-17, 25-19, dan 22-20.',
                'penulis' => 'Humas Sekolah',
                'tanggal' => '2026-10-21',
            ],
            [
                'slug' => 'pentas-karya-siswa',
                'judul' => 'Pentas Karya Siswa 2026',
                'kategori' => 'Kegiatan',
                'gambar' => 'pentas-karya-siswa.png',
                'ringkasan' => 'Pameran karya siswa ditampilkan di aula sekolah.',
                'isi' => 'Pentas karya siswa berlangsung di aula sekolah dan menampilkan karya dari seluruh jenjang pendidikan.',
                'penulis' => 'Humas Sekolah',
                'tanggal' => '2026-10-14',
            ],
        ];
    }
}
