<?php

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\ProgramController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
| Semua halaman memakai named route. Jangan pernah menulis URL manual di
| dalam view — panggil route('nama.route') supaya tautan ikut berubah
| otomatis bila path suatu halaman dirombak.
*/

Route::get('/', [BerandaController::class, 'index'])->name('beranda');

/*
 * Halaman profil dikelompokkan dengan prefix + name prefix, sehingga
 * seluruh URL berada di bawah /profil dan seluruh nama di bawah profil.*
 */
Route::prefix('profil')->name('profil.')->group(function () {
    Route::view('/', 'profil.sekolah')->name('sekolah');
    Route::view('/visi-misi', 'profil.visi-misi')->name('visi-misi');
    Route::view('/sejarah', 'profil.sejarah')->name('sejarah');
    Route::view('/guru-dan-staf', 'profil.guru-staf')->name('guru-staf');
    Route::view('/fasilitas', 'profil.fasilitas')->name('fasilitas');
});

/*
 * berita.index dideklarasikan lebih dulu agar aman terhadap {slug} di bawah.
 * {slug} dibatasi hanya huruf kecil, angka, dan tanda hubung supaya path
 * seperti /berita/pengumuman tidak pernah tertangkap sebagai berita.
 */
Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');

Route::get('/berita/{slug}', [BeritaController::class, 'show'])
    ->where('slug', '[a-z0-9]+(?:-[a-z0-9]+)*')
    ->name('berita.show');

Route::view('/galeri', 'galeri')->name('galeri');
Route::view('/pengumuman', 'pengumuman')->name('pengumuman');
Route::view('/ppdb', 'ppdb')->name('ppdb');
Route::view('/kontak', 'kontak')->name('kontak');

/*
 * Menu utama navbar: Beranda, Program Keahlian, Tenaga Pendidik, BKK,
 * Tracer Study, dan SPMB.
 */
Route::get('/program', [ProgramController::class, 'index'])->name('program.index');

Route::get('/program/{slug}', [ProgramController::class, 'show'])
    ->where('slug', '[a-z0-9]+(?:-[a-z0-9]+)*')
    ->name('program.show');

Route::view('/bkk', 'bkk')->name('bkk');
Route::view('/tracer-study', 'tracer-study')->name('tracer-study');
Route::view('/spmb', 'spmb')->name('spmb');
