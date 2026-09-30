<?php

/*
 * Membuat foto placeholder untuk tenaga pendidik.
 * Jalankan sekali dari root proyek:  php tools/make-placeholder-foto.php
 *
 * File hasil understatement placeholder, bukan foto asli. Ganti dengan foto
 * asli dengan menimpa file bernama sama di public/images/guru/.
 */

$root = dirname(__DIR__);
$target = $root.'/public/images/guru';

if (! is_dir($target)) {
    mkdir($target, 0755, true);
}

$guru = require $root.'/config/guru.php';

$latar = [
    [0xE2, 0xE8, 0xF0],
    [0xDD, 0xE7, 0xEF],
    [0xE8, 0xE4, 0xF0],
    [0xE0, 0xEC, 0xE6],
    [0xF0, 0xE8, 0xE2],
    [0xE6, 0xE8, 0xEE],
];

$font = 'C:/Windows/Fonts/arialbd.ttf';
$ukuran = 640;

foreach ($guru as $i => $orang) {
    $img = imagecreatetruecolor($ukuran, $ukuran);
    imageantialias($img, true);

    [$r, $g, $b] = $latar[$i % count($latar)];

    $warnaLatar = imagecolorallocate($img, $r, $g, $b);
    $warnaSiluet = imagecolorallocate($img, 0x94, 0xA3, 0xB8);
    $warnaTeks = imagecolorallocate($img, 0xFF, 0xFF, 0xFF);

    imagefilledrectangle($img, 0, 0, $ukuran, $ukuran, $warnaLatar);

    // Siluet: kepala dan bahu.
    imagefilledellipse($img, (int) ($ukuran / 2), (int) ($ukuran * 0.38), (int) ($ukuran * 0.30), (int) ($ukuran * 0.30), $warnaSiluet);
    imagefilledellipse($img, (int) ($ukuran / 2), (int) ($ukuran * 0.95), (int) ($ukuran * 0.62), (int) ($ukuran * 0.52), $warnaSiluet);

    // Inisial.
    $parts = preg_split('/[ ,.]+/', trim($orang['nama']));
    $inisial = mb_strtoupper(mb_substr($parts[0], 0, 1).mb_substr($parts[1] ?? '', 0, 1));

    $kotak = (int) ($ukuran * 0.30);
    $xKotak = (int) (($ukuran - $kotak) / 2);
    $yKotak = (int) (($ukuran - $kotak) / 2) + (int) ($ukuran * 0.22);

    imagefilledrectangle($img, $xKotak, $yKotak, $xKotak + $kotak, $yKotak + $kotak, $warnaSiluet);

    $ukuranTeks = 76;
    $box = imagettfbbox($ukuranTeks, 0, $font, $inisial);
    $lebarTeks = $box[2] - $box[0];
    $tinggiTeks = $box[1] - $box[7];

    imagettftext(
        $img,
        $ukuranTeks,
        0,
        (int) ($xKotak + ($kotak - $lebarTeks) / 2) - $box[0],
        (int) ($yKotak + ($kotak + $tinggiTeks) / 2) - $box[1],
        $warnaTeks,
        $font,
        $inisial
    );

    $path = $target.'/'.$orang['foto'];
    imagepng($img, $path, 8);
    imagedestroy($img);

    echo 'dibuat: '.$path.PHP_EOL;
}
