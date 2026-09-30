<?php

/*
|--------------------------------------------------------------------------
| Program Keahlian
|--------------------------------------------------------------------------
| Sumber data sementara untuk halaman /program/{slug}.
|
| Saat tabel `program_keahlian` tersedia, ganti isi file ini dengan query
| model dan sisakan nama field yang sama agar view tidak perlu berubah.
|
| Catatan: label resmi tiap jurusan bisa berbeda di tiap sekolah. Pastikan
| nama panjang di sini sudah sesuai dengan dokumen resmi sebelum dipakai.
|
*/

return [

    [
        'slug' => 'kuliner',
        'singkat' => 'Kuliner',
        'nama' => 'Kuliner',
        'deskripsi' => 'Mempelajari penyajian makanan dan minuman sesuai standar higiene, '
            .'mulai dari teknik mengolah bahan hingga penyajian professional.',
        'kompetensi' => [
            'Teknik memotong dan mengolah bahan pangan',
            'Higiene dan sanitasi dapur',
            'Penyajian makanan dan minuman',
            'Pengelolaan dapur dan persediaan bahan',
        ],
        'peluang_kerja' => 'Koki restoran, koki hotel, pastry chef, supervisor dapur.',
    ],

    [
        'slug' => 'dkv',
        'singkat' => 'DKV',
        'nama' => 'Desain Komunikasi Visual',
        'deskripsi' => 'Mempelajari perancangan media visual untuk promosi dan '
            .'penyajian, dari gambar digital hingga produk cetak.',
        'kompetensi' => [
            'Desain grafis dan tata letak',
            'Pengeditan foto dan video',
            'Desain media sosial dan promosi',
            'Produk cetak dan kemasan',
        ],
        'peluang_kerja' => 'Desainer grafis, editor video, art director, product designer.',
    ],

    [
        'slug' => 'tkj',
        'singkat' => 'TKJ',
        'nama' => 'Teknik Komputer dan Jaringan',
        'deskripsi' => 'Mempelajari pembangunan, pengoperasian, dan perbaikan '
            .'infrastruktur jaringan serta perangkat komputer.',
        'kompetensi' => [
            'Perakitan dan perbaikan komputer',
            'Konfigurasi jaringan dan server',
            'Administrasi sistem operasi',
            'Keamanan jaringan dasar',
        ],
        'peluang_kerja' => 'Teknisi komputer, network administrator, help desk, sysadmin.',
    ],

    [
        'slug' => 'ak',
        'singkat' => 'AK',
        'nama' => 'Akuntansi',
        'deskripsi' => 'Mempelajari pencatatan dan pelaporan keuangan, '
            .'serta penggunaan perangkat lunak akuntansi pada mundo kerja.',
        'kompetensi' => [
            'Pencatatan transaksi harian',
            'Penyusunan laporan keuangan',
            'Penggunaan aplikasi akuntansi',
            'Perhitungan pajak dasar',
        ],
        'peluang_kerja' => 'Akuntan, staf keuangan, auditor junior, analis keuangan.',
    ],

    [
        'slug' => 'mp',
        'singkat' => 'MP',
        'nama' => 'Manufaktur dan Pemesinan',
        'deskripsi' => 'Mempelajari proses produksi barang, dari perencanaan, '
            .'pemesinan mesin, hingga kendali mutu hasil kerja.',
        'kompetensi' => [
            'Perencanaan proses produksi',
            'Pemesinan dan permesinan',
            'Gambar teknik dan CAM-CAD dasar',
            'Kendali mutu hasil kerja',
        ],
        'peluang_kerja' => 'Operator mesin, teknisi produksi, quality control, planner.',
    ],

    [
        'slug' => 'bd',
        'singkat' => 'BD',
        'nama' => 'Bisnis Digital',
        'deskripsi' => 'Mempelajari pengelolaan usaha digital, dari pemasaran daring '
            .'hingga pengelolaan konten dan transaksi secara elektronik.',
        'kompetensi' => [
            'Pemasaran digital dan media sosial',
            'Pengelolaan konten dan marketplace',
            'Transaksi dan pembayaran elektronik',
            'Analisis data penjualan sederhana',
        ],
        'peluang_kerja' => 'Digital marketer, content creator, admin marketplace, analis penjualan.',
    ],

];
