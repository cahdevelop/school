<?php

/*
 * Membuat gambar placeholder untuk berita.
 * Jalankan sekali dari root proyek:  php tools/make-placeholder-foto-berita.php
 *
 * File hasil semuanya placeholder, bukan foto asli. Ganti dengan foto asli
 * dengan menimpa file bernama sama di public/images/berita/.
 *
 * Kalau sebuah file dihapus, kartu berita otomatis memakai gradien kategori,
 * jadi halaman tetap rapi tanpa gambar sama sekali.
 */

$root = dirname(__DIR__);
$target = $root.'/public/images/berita';

if (! is_dir($target)) {
    mkdir($target, 0755, true);
}

$gambar = [
    'penerimaan-siswa-baru.png' => [
        'latar' => [0xF3, 0xE4, 0xBE],
        'tinta' => [0x92, 0x54, 0x0F],
        'glif' => ['PPDB', '2026/2027'],
    ],
    'tim-volei-juara-dua.png' => [
        'latar' => [0xD7, 0xE9, 0xE0],
        'tinta' => [0x14, 0x5A, 0x40],
        'glif' => ['PRESTASI', 'JUARA 2'],
    ],
    'pentas-karya-siswa.png' => [
        'latar' => [0xD8, 0xE4, 0xF2],
        'tinta' => [0x1B, 0x44, 0x77],
        'glif' => ['KEGIATAN', 'KARYA'],
    ],
    'lks-cyber-security.png' => [
        'latar' => [0xDC, 0xF0, 0xE4],
        'tinta' => [0x15, 0x60, 0x3E],
        'glif' => ['PRESTASI', 'EMAS LKS'],
    ],
    'kunjungan-industri.png' => [
        'latar' => [0xDB, 0xE8, 0xFA],
        'tinta' => [0x1E, 0x40, 0xAF],
        'glif' => ['INDUSTRI', 'KEMITRAAN'],
    ],
    'tips-ukk-nasional.png' => [
        'latar' => [0xF5, 0xEA, 0xFA],
        'tinta' => [0x70, 0x1A, 0x75],
        'glif' => ['EDUKASI', 'TIPS UKK'],
    ],
];

$lebar = 1600;
$tinggi = 1000;
$font = 'C:/Windows/Fonts/arialbd.ttf';

foreach ($gambar as $nama => $gaya) {
    $img = imagecreatetruecolor($lebar, $tinggi);
    imageantialias($img, true);

    [$r, $g, $b] = $gaya['latar'];
    [$tr, $tg, $tb] = $gaya['tinta'];

    // Latar miring lembut, bukan warna rata, supaya tidak terlihat "%placeholder".
    $latar = imagecolorallocate($img, $r, $g, $b);
    imagefilledrectangle($img, 0, 0, $lebar, $tinggi, $latar);

    $susun = imagecolorallocatealpha($img, $tr, $tg, $tb, 96);
    $susun2 = imagecolorallocatealpha($img, $tr, $tg, $tb, 104);

    // Dua lingkaran besar overlap untuk efek spotlight lembut.
    imagefilledellipse($img, (int) ($lebar * 0.18), (int) ($tinggi * 0.24), 900, 900, $susun);
    imagefilledellipse($img, (int) ($lebar * 0.86), (int) ($tinggi * 0.86), 1100, 1100, $susun2);

    $garis = imagecolorallocatealpha($img, $tr, $tg, $tb, 88);
    for ($i = 0; $i < 9; $i++) {
        $y = (int) ($tinggi * (0.18 + $i * 0.09));
        imagefilledrectangle($img, 0, $y, $lebar, $y + 3, $garis);
    }

    $tebal = imagecolorallocate($img, $tr, $tg, $tb);
    $putih = imagecolorallocate($img, 0xFF, 0xFF, 0xFF);

    // Glif besar di kiri bawah sebagai penanda visual.
    $ukuran = 132;
    $box = imagettfbbox($ukuran, 0, $font, $gaya['glif'][0]);
    imagettftext(
        $img,
        $ukuran,
        0,
        96 - $box[6],
        (int) ($tinggi * 0.62),
        $tebal,
        $font,
        $gaya['glif'][0]
    );

    $ukuran2 = 58;
    imagettftext(
        $img,
        $ukuran2,
        0,
        96,
        (int) ($tinggi * 0.72),
        $putih,
        $font,
        $gaya['glif'][1]
    );

    // Garis aksen tipis di bawah glif.
    $x0 = 96;
    $y0 = (int) ($tinggi * 0.66);
    imagefilledrectangle($img, $x0, $y0, $x0 + 220, $y0 + 8, $tebal);

    $path = $target.'/'.$nama;
    imagepng($img, $path, 8);
    imagedestroy($img);

    echo 'dibuat: '.$path.PHP_EOL;
}
