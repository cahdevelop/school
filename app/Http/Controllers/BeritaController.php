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
                'judul' => 'Penerimaan Siswa Baru Tahun Ajaran 2026/2027 Telah Dibuka',
                'kategori' => 'PPDB',
                'gambar' => 'penerimaan-siswa-baru.png',
                'ringkasan' => 'Pendaftaran gelombang pertama resmi dibuka dengan kuota terbatas dan jalur beasiswa prestasi kejuruan unggulan.',
                'isi' => 'Sekolah Harapan Bangsa (SMK) resmi membuka Penerimaan Peserta Didik Baru (PPDB) Tahun Ajaran 2026/2027. Tersedia 6 program keahlian unggulan berstandar industri dengan fasilitas laboratorium modern dan kemitraan penyaluran kerja terpercaya. Calon peserta didik dapat mendaftar secara daring melalui portal resmi SPMB atau langsung datang ke sekretariat pendaftaran.',
                'penulis' => 'Panitia PPDB',
                'tanggal' => '2026-10-28',
                'waktu_baca' => '3 mnt baca',
            ],
            [
                'slug' => 'siswa-smk-raih-emas-lks-cyber-security',
                'judul' => 'Siswa SMK Harapan Bangsa Raih Medali Emas LKS Tingkat Provinsi',
                'kategori' => 'Prestasi',
                'gambar' => 'lks-cyber-security.png',
                'ringkasan' => 'Prestasi gemilang diraih siswa program keahlian TKJ dalam bidang Cyber Security & Network Systems.',
                'isi' => 'Kontingen SMK Harapan Bangsa berhasil menorehkan prestasi membanggakan pada ajang Lomba Kompetensi Siswa (LKS) Kejuruan tingkat provinsi tahun 2026. Melalui persaingan ketat selama 3 hari menghadapi 45 perwakilan sekolah terbaik, tim Cyber Security kami sukses meraih Juara 1 dan berhak mewakili provinsi ke tingkat nasional.',
                'penulis' => 'Humas Sekolah',
                'tanggal' => '2026-10-24',
                'waktu_baca' => '4 mnt baca',
            ],
            [
                'slug' => 'kemitraan-industri-dan-sinkronisasi-kurikulum',
                'judul' => 'Sinkronisasi Kurikulum & MoU Bersama 15 Mitra Industri Nasional',
                'kategori' => 'Kegiatan',
                'gambar' => 'kunjungan-industri.png',
                'ringkasan' => 'Langkah nyata memastikan kompetensi lulusan selaras 100% dengan kebutuhan dunia usaha dan dunia industri modern.',
                'isi' => 'Guna memastikan keterserapan lulusan di dunia kerja, SMK Harapan Bangsa menandatangani nota kesepahaman (MoU) dan menyelenggarakan lokakarya sinkronisasi kurikulum bersama 15 mitra industri skala nasional. Kerja sama ini mencakup kelas industri, magang kerja bersertifikat, hingga rekrutmen langsung sebelum kelulusan.',
                'penulis' => 'BKK & Kemitraan',
                'tanggal' => '2026-10-18',
                'waktu_baca' => '3 mnt baca',
            ],
            [
                'slug' => 'pentas-karya-siswa',
                'judul' => 'Pameran Karya Inovasi Teknologi & Desain Kreatif Siswa 2026',
                'kategori' => 'Kegiatan',
                'gambar' => 'pentas-karya-siswa.png',
                'ringkasan' => 'Ratusan karya produk jadi siswa dari perakitan server, produk kuliner, hingga desain grafis dipamerkan ke publik.',
                'isi' => 'Pentas Karya dan Gelar Produk Kreatif Kejuruan 2026 berlangsung meriah di aula utama sekolah. Acara tahunan ini menjadi etalase hasil praktikum nyata para peserta didik, mulai dari prototype IoT, kemasan produk DKV, hingga olahan kuliner berstandar hotel berbintang.',
                'penulis' => 'Humas Sekolah',
                'tanggal' => '2026-10-14',
                'waktu_baca' => '3 mnt baca',
            ],
            [
                'slug' => 'tips-sukses-uji-kompetensi-keahlian-ukk',
                'judul' => 'Panduan & Tips Sukses Menghadapi Uji Kompetensi Keahlian (UKK)',
                'kategori' => 'Edukasi',
                'gambar' => 'tips-ukk-nasional.png',
                'ringkasan' => 'Simak strategi dan persiapan mental serta teknis bagi siswa kelas XII agar meraih sertifikasi kompetensi berstandar BNSP.',
                'isi' => 'Uji Kompetensi Keahlian (UKK) merupakan fase krusial bagi siswa SMK untuk membuktikan keahlian profesionalnya di hadapan assesor industri independen. Para guru produktif merangkum 5 kiat jitu dalam mempersiapkan portofolio, simulasi praktik, dan wawancara teknis agar lulus dengan predikat sangat kompeten.',
                'penulis' => 'Tim Kurikulum',
                'tanggal' => '2026-10-06',
                'waktu_baca' => '5 mnt baca',
            ],
            [
                'slug' => 'tim-volei-raih-juara-dua',
                'judul' => 'Tim Bola Voli Sekolah Raih Juara 2 Turnamen Pelajar Tingkat Regional',
                'kategori' => 'Prestasi',
                'gambar' => 'tim-volei-juara-dua.png',
                'ringkasan' => 'Perjuangan pantang menyerah tim bola voli membawa pulang piala perak setelah pertandingan final yang ketat.',
                'isi' => 'Tim bola voli putra SMK Harapan Bangsa berhasil meraih posisi runner-up pada Turnamen Pelajar Regional 2026 yang diikuti oleh 32 tim perwakilan sekolah menengah. Semangat sportivitas dan kekompakan tim menjadi inspirasi bagi seluruh warga sekolah.',
                'penulis' => 'Kesiswaan',
                'tanggal' => '2026-09-26',
                'waktu_baca' => '2 mnt baca',
            ],
        ];
    }
}
