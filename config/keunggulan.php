<?php

/*
|--------------------------------------------------------------------------
| Keunggulan Sekolah
|--------------------------------------------------------------------------
| Sumber data untuk section "Mengapa Sekolah Menjadi Pilihan?".
|
| Saat tabel `keunggulan` tersedia, ganti isi file ini dengan query model dan
| sisakan nama field yang sama agar view tidak perlu berubah.
|
| Field `ikon` hanya berisi KUNCI, bukan SVG-nya. SVG-nya hidup di
| resources/views/components/ikon.blade.php supaya file ini tetap data murni
| dan tidak bercampur dengan markup.
|
| Kunci ikon yang dikenal: piala, perisai, toga, perkakas, hadiah, koper,
| bendera, buku. Kunci yang tidak dikenal akan memakai ikon cadangan, bukan
| membuat halaman kosong.
|
*/

return [

    [
        'ikon' => 'piala',
        'judul' => 'Juara Acer Smart School',
        'deskripsi' => 'Pengakuan Acer atas kelas yang memakai teknologi dengan sengaja, bukan sekadar mempamerkannya.',
    ],

    [
        'ikon' => 'perisai',
        'judul' => 'Terakreditasi A',
        'deskripsi' => 'Standar mutu yang sudah diaudit, jadi orang tua tahu persis apa yang mereka dapat.',
    ],

    [
        'ikon' => 'toga',
        'judul' => 'Pengajar Kompeten',
        'deskripsi' => 'Guru yang siap di bidangnya dan terus memperbarui cara mengajar mengikuti zaman.',
    ],

    [
        'ikon' => 'perkakas',
        'judul' => 'Fasilitas Lengkap',
        'deskripsi' => 'Laboratorium, workshop, dan ruang praktik yang benar-benar dipakai siswa, bukan hanya difoto.',
    ],

    [
        'ikon' => 'hadiah',
        'judul' => 'Program Beasiswa',
        'deskripsi' => 'Jalur bantuan biaya bagi siswa berprestasi, agar kemampuan tidak berhenti di sisi biaya.',
    ],

    [
        'ikon' => 'koper',
        'judul' => 'Alumni Berkualitas',
        'deskripsi' => 'Lulusan yang sudah bekerja di bidangnya dan tetap menjadi bagian penting jaringan sekolah.',
    ],

    [
        'ikon' => 'bendera',
        'judul' => 'Prestasi',
        'deskripsi' => 'Penghargaan tingkat kota dan provinsi, di bidang akademik maupun olahraga dan seni.',
    ],

    [
        'ikon' => 'buku',
        'judul' => 'Kurikulum Merdeka',
        'deskripsi' => 'Pembelajaran berbasis proyek dengan ruang bagi siswa mengembangkan kekuatan masing-masing.',
    ],

];
