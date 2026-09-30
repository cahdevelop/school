<?php

/*
 * Membuat gambar placeholder untuk section "Kegiatan & Karya Peserta Didik".
 * Jalankan sekali dari root proyek:  php tools/make-placeholder-foto-kegiatan.php
 *
 * Daftar gambarnya DIBACA dari config/kegiatan.php, bukan ditulis ulang di
 * sini. Jadi begitu ada kegiatan baru di config, jalankan ulang script ini
 * dan gambarnya langsung ikut terbit. Tidak ada daftar kedua yang bisa
 * tertinggal.
 *
 * File hasil semuanya placeholder, bukan foto asli. Ganti dengan foto asli
 * dengan menimpa file bernama sama di public/images/kegiatan/. Untuk video,
 * ganti dengan thumbnail 16:9 dari YouTube.
 *
 * Kalau sebuah file dihapus, kartu otomatis memakai gradien kategori, jadi
 * halaman tetap rapi tanpa gambar sama sekali.
 */

$root = dirname(__DIR__);
$target = $root.'/public/images/kegiatan';

if (! is_dir($target)) {
    mkdir($target, 0755, true);
}

$kegiatan = require $root.'/config/kegiatan.php';

/*
 * Paletnya sengaja sama dengan peta warna di dalam
 * resources/views/components/kegiatan-karya.blade.php, jadi warna fallback
 * dan warna placeholder terasa berasal dari satu sistem, bukan dua.
 * Ink: [0x00-0xFF] merah, hijau, biru.
 */
$gaya = [
    'Praktikum' => ['latar' => [0xE0, 0xEF, 0xFA], 'tinta' => [0x0C, 0x4A, 0x6E]],
    'Pameran Karya' => ['latar' => [0xFE, 0xF0, 0xD5], 'tinta' => [0x92, 0x54, 0x0F]],
    'Prestasi' => ['latar' => [0xD8, 0xEF, 0xE3], 'tinta' => [0x14, 0x5A, 0x40]],
];

/*
 * 16:10, sama dengan aspect-[16/10] pada kartu dan panel sorotan. Kalau
 * rasionya tidak sama, object-cover akan memotong sisipan.
 */
$lebar = 1600;
$tinggi = 1000;
$font = 'C:/Windows/Fonts/arialbd.ttf';

if (! is_file($font)) {
    fwrite(STDERR, 'Font tidak ditemukan: '.$font.PHP_EOL);
    exit(1);
}

foreach ($kegiatan as $item) {
    $nama = $item['gambar'] ?? null;

    if (! is_string($nama) || $nama === '') {
        continue;
    }

    $kategori = $item['kategori'] ?? '';
    $video = ($item['tipe'] ?? '') === 'video';
    $judul = (string) ($item['judul'] ?? '');

    // Kategori yang belum punya entri di palet tetap dapat gambar.
    $warna = $gaya[$kategori] ?? ['latar' => [0xE9, 0xEE, 0xF4], 'tinta' => [0x33, 0x41, 0x55]];

    $img = imagecreatetruecolor($lebar, $tinggi);
    imageantialias($img, true);

    [$r, $g, $b] = $warna['latar'];
    [$tr, $tg, $tb] = $warna['tinta'];

    // Latar miring lembut, bukan warna rata, supaya tidak terlihat "%placeholder".
    imagefilledrectangle($img, 0, 0, $lebar, $tinggi, imagecolorallocate($img, $r, $g, $b));

    $susun = imagecolorallocatealpha($img, $tr, $tg, $tb, 96);
    $susun2 = imagecolorallocatealpha($img, $tr, $tg, $tb, 104);
    imagefilledellipse($img, (int) ($lebar * 0.18), (int) ($tinggi * 0.24), 900, 900, $susun);
    imagefilledellipse($img, (int) ($lebar * 0.86), (int) ($tinggi * 0.86), 1100, 1100, $susun2);

    $tebal = imagecolorallocate($img, $tr, $tg, $tb);
    $putih = imagecolorallocate($img, 0xFF, 0xFF, 0xFF);

    /*
     * Inisial diambil dari judul, sama seperti kartu. Kalau dari kategori,
     * "Praktikum" dan "Prestasi" akan menghasilkan inisial yang sama dan
     * semua gambarnya jadi kembar.
     */
    $inisial = strtoupper(mb_substr($judul, 0, 2));

    $ukuran = 150;
    $box = imagettfbbox($ukuran, 0, $font, $inisial);
    imagettftext(
        $img,
        $ukuran,
        0,
        96 - $box[6],
        (int) ($tinggi * 0.62),
        $tebal,
        $font,
        $inisial
    );

    // Label jenis media. Video diberi label sendiri supaya bedanya kelihatan
    // sudah di thumbnail, sebelum kursor sampai ke kartu.
    $label = $video ? 'VIDEO' : mb_strtoupper($kategori !== '' ? $kategori : 'Foto');

    $ukuran2 = 46;
    $box2 = imagettfbbox($ukuran2, 0, $font, $label);
    imagettftext(
        $img,
        $ukuran2,
        0,
        96 - $box2[6],
        (int) ($tinggi * 0.72),
        $putih,
        $font,
        $label
    );

    // Garis aksen tipis di bawah glif.
    $y0 = (int) ($tinggi * 0.66);
    imagefilledrectangle($img, 96, $y0, 96 + 220, $y0 + 8, $tebal);

    $path = $target.'/'.$nama;
    imagepng($img, $path, 8);
    imagedestroy($img);

    echo 'dibuat: '.$path.PHP_EOL;
}
