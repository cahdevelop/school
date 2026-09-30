<?php

/*
|--------------------------------------------------------------------------
|Sambutan Kepala Sekolah
|--------------------------------------------------------------------------
|Sumber teks sambutan untuk bagian beranda.
|
|Saat tabel `sambutan` tersedia, ganti isi file ini dengan query model dan
|sisakan nama field yang sama agar view tidak perlu berubah.
|
|Nama, gelar, jabatan, dan foto kepala sekolah SENGAJA TIDAK disimpan di
|sini. Semuanya diambil dari config('guru') dengan memilih entri yang
|jabatannya 'Kepala Sekolah', supaya ada hanya satu sumber kebenaran.
|
*/

$p1 = 'Terima kasih atas kepercayaan yang Bapak dan Ibu berikan kepada kami. '
    .'Kami ingin setiap siswa pulang dengan dua hal: kompetensi yang bisa '
    .'dipakai, dan karakter yang jadi miliknya sendiri.';

$p2 = 'Enam program keahlian yang kami buka tidak berdiri sendiri. Anak-anak '
    .'belajar memakai alat, berdiskusi, dan mencoba hal yang gagal. Semua itu '
    .'terjadi bersama praktik nyata di luar kelas, dibimbing oleh tenaga '
    .'pendidik yang juga pernah menjadi siswa di tempat yang sama.';

$p3 = 'Utama kami bukan nilai di atas kertas, melainkan kebiasaan yang terbawa '
    .'pulang ke rumah. Kami berharap langkah pertama setelah lulus nanti '
    .'dipilih dengan sadar, bukan sekadar ikut teman.';

$teks = [$p1, $p2, $p3];

return [

    /*
     * Baris pembuka, ditampilkan sebagai satu paragraf penuh.
     */
    'sapaan' => 'Assalamu\'alaikum warahmatullahi wabarakatuh, dan salam sejahtera untuk kita semua.',

    /*
     * Isi sambutan. Tiap entri jadi satu paragraf sendiri, sehingga jarak
     * antarparagraf diatur dari CSS, bukan dari baris kosong di dalam teks.
     */
    'paragraf' => $teks,

    /*
     * Motto sekolah, ditampilkan sebagai kutipan penutup dengan garis
     * aksen di sisi kiri.
     */
    'motto' => 'Berprestasi, Berkarakter, Mengabdi.',

];
