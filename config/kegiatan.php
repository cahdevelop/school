<?php

/*
|--------------------------------------------------------------------------
| Kegiatan & Karya Peserta Didik
|--------------------------------------------------------------------------
| Sumber data untuk section "Kegiatan & Karya Peserta Didik" di beranda.
|
| Saat tabel `kegiatan` tersedia, ganti isi file ini dengan query model dan
| sisakan nama field yang sama agar view tidak perlu berubah. Contoh:
|
|     Kegiatan::query()
|         ->whereIn('tipe', ['video', 'foto'])
|         ->latest('tanggal')
|         ->get();
|
| Section ini sengaja memakai SATU daftar datar, bukan dua daftar terpisah.
| Komponen mengambil entri pertama sebagai media utama (featured) dan sisanya
| menjadi grid, lalu mengurutkan sendiri berdasarkan `tanggal` menurun. Jadi
| urutan di file ini tidak menentukan apa yang jadi sorotan; yang menentukan
| adalah tanggalnya.
|
| Field:
|   tipe      'video' atau 'foto'. Komponen memakai tata letak berbeda untuk
|             keduanya, jadi jangan sampai nilainya ketuker.
|   kategori  Lencana kecil di atas media. Warnanya diambil dari peta di dalam
|             component, dan kategori yang belum terdaftar tetap dapat tampil
|             dengan warna cadangan.
|   judul     Judul kegiatan. Dipakai untuk nama alt dan untuk teks tautan.
|   ringkasan Satu kalimat deskripsi, dipotong maksimal dua baris di kartu.
|   gambar    Nama file di dalam public/images/kegiatan/. Untuk video ini
|             sebaiknya thumbnail 16:9. Kalau file-nya hilang, kartu otomatis
|             memakai gradien kategori, jadi tidak pernah tampil rusak.
|   tanggal   Format Y-m-d, string biasa.
|   tautan    Halaman tujuan, atau null kalau belum ada. Kartu video memakai
|             tautan ini untuk tombol "Tonton di YouTube"; kartu foto tidak
|             punya tautan sama sekali. Nilai null aman: kartu tetap tampil
|             utuh, hanya tanpa tautan.
|
| PENTING: nilai `tautan` di bawah masih PLACEHOLDER dan belum menunjuk ke
| video sungguhan. Ganti dengan ID video asli sebelum situs dipublikasikan.
|
*/

return [

    [
        'tipe' => 'video',
        'kategori' => 'Pameran Karya',
        'judul' => 'Pentas Karya Peserta Didik 2026',
        'ringkasan' => 'Rekap tiga hari pameran karya kelas: installasi, produk jadi, dan panggung pertunjukan seni.',
        'gambar' => 'pentas-karya-2026.png',
        'tanggal' => '2026-10-24',
        'tautan' => 'https://www.youtube.com/watch?v=CONTOH-PENTAS-KARYA-2026',
    ],

    [
        'tipe' => 'foto',
        'kategori' => 'Praktikum',
        'judul' => 'Praktikum Desain Komunikasi Visual',
        'ringkasan' => 'Enam belas poster packaging, dari riset warna sampai fotoproduksi untuk mitra lokal.',
        'gambar' => 'praktikum-dkv.png',
        'tanggal' => '2026-10-17',
        'tautan' => null,
    ],

    [
        'tipe' => 'video',
        'kategori' => 'Praktikum',
        'judul' => 'Montase Proyek Jaringan Server Kelas',
        'ringkasan' => 'Tim Teknik Komputer dan Jaringan merakit server ruang kelas lalu mengukur hasilnya.',
        'gambar' => 'montase-tkj.png',
        'tanggal' => '2026-10-10',
        'tautan' => 'https://www.youtube.com/watch?v=CONTOH-MONTASE-TKJ-2026',
    ],

    [
        'tipe' => 'foto',
        'kategori' => 'Pameran Karya',
        'judul' => 'Pameran Musik Band Sector',
        'ringkasan' => 'Penampilan band Sector angkatan 2026 pada hari penutup pameran karya.',
        'gambar' => 'pameran-musik-mp.png',
        'tanggal' => '2026-10-03',
        'tautan' => null,
    ],

    [
        'tipe' => 'video',
        'kategori' => 'Praktikum',
        'judul' => 'Praktikum Dapur: Menu Musim',
        'ringkasan' => 'Dapur praktik menyiapkan hidangan penjurian akhir bagi peserta didik bidang Kuliner.',
        'gambar' => 'praktikum-kuliner.png',
        'tanggal' => '2026-09-26',
        'tautan' => 'https://www.youtube.com/watch?v=CONTOH-PRAKTIKUM-KULINER-2026',
    ],

    [
        'tipe' => 'foto',
        'kategori' => 'Prestasi',
        'judul' => 'Juara Lomba Poster Urban',
        'ringkasan' => 'Karya dua peserta didik juara pada lomba poster tingkat kabupaten.',
        'gambar' => 'juara-lomba-poster.png',
        'tanggal' => '2026-09-19',
        'tautan' => null,
    ],

    [
        'tipe' => 'video',
        'kategori' => 'Pameran Karya',
        'judul' => 'Sidang Laporan Keuangan',
        'ringkasan' => 'Sidang laporan keuangan sebagai bagian dari pameran karya bidang Akuntansi.',
        'gambar' => 'sidang-laporan-ak.png',
        'tanggal' => '2026-09-12',
        'tautan' => 'https://www.youtube.com/watch?v=CONTOH-SIDANG-AK-2026',
    ],

];
