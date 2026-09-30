/*
 * ------------------------------------------------------------------
 * Scroll reveal
 *
 * Elemen beratribut `data-reveal` mulai transparan dan bergeser sedikit,
 * lalu kembali normal saat masuk viewport. Dipakai di section Sambutan
 * Kepala Sekolah dan header Berita.
 *
 * Dua hal yang sengaja dijaga:
 *
 * 1. State hidden-nya dikunci di balik kelas `js-reveal` yang ditambahkan
 *    oleh JS. Kalau JS gagal dimuat atau di-block, elemen TIDAK PERNAH
 *    tersembunyi. Konten harus tetap terbaca apa adanya; animasi hanyalah
 *    tambahan, bukan syarat agar konten ada.
 *
 * 2. Transformasi tidak pernah menempel pada leluhur navbar. Foto hero dan
 *    hero itu sendiri dikecualikan dari modul ini, karena `transform` pada
 *    leluhur membuat `position: fixed` navbar dihitung terhadap leluhur itu
 *    dan bukan terhadap viewport. Semua elemen di sini ada di dalam <main>,
 *    jadi navbar aman.
 *
 * Arah masuk diambil dari nilai atribut:
 *   data-reveal="left"  -> masuk dari kiri
 *   data-reveal="right" -> masuk dari kanan
 *   data-reveal="up"    -> masuk dari bawah
 *
 * Jeda antar-elemen lewat `style="--reveal-delay: 120ms"`.
 * ------------------------------------------------------------------
 */

/*
 * Kapan animasi dimulai.
 *
 * AMBANG sengaja dibuat sangat kecil. Nilai lama 0.15 membuat elemen baru
 * memicu saat 15% areanya terlihat, padahal saat itu elemen sudah sampai
 * bagian bawah layar. Animasi yang telat dibaca pengguna sebagai lambat,
 * bukan sebagai gerak halus.
 */
const AMBANG = 0.01;

/*
 * Margin bawah negatif: pemicu saat tepi ATAS elemen menyentuh 88% tinggi
 * viewport, jadi animasi sudah berjalan sebelum elemen sampai di pandangan
 * mata. Angka ini yang bikin elemen terasa nempel dengan scroll, bukan
 * menyusul di belakang.
 */
const MARGIN_AWARAT = '0px 0px -12% 0px';

const kurangiGerak = window.matchMedia('(prefers-reduced-motion: reduce)');

/*
 * Satu elemen grup dinyalakan: dirinya sendiri, lalu seluruh
 * `data-reveal-item` di dalamnya. Ini yang membuat baris-baris welcome
 * masuk berurutan dari titik waktu yang sama.
 */
function nyalakan(el) {
    el.classList.add('is-revealed');

    el.querySelectorAll('[data-reveal-item]').forEach((item) => {
        item.classList.add('is-revealed');
    });
}

function pasangReveal() {
    /*
     * `data-reveal-item` sengaja TIDAK masuk daftar ini. Item milik grup
     * hanya dinyalakan oleh grupnya; kalau ikut dipantau, item yang baru
     * masuk viewport belakangan akan menyala sendiri, masih membawa jeda
     * yang sudah tidak relevan.
     */
    const elemen = Array.from(
        document.querySelectorAll('[data-reveal], [data-reveal-group]')
    );

    if (elemen.length === 0) {
        return;
    }

    // Tanpa IntersectionObserver, atau pengguna meminta gerak minimal, semua
    // elemen langsung ditampilkan. Tidak ada yang tertahan transparan.
    if (kurangiGerak.matches || ! ('IntersectionObserver' in window)) {
        elemen.forEach(nyalakan);

        return;
    }

    // Kelas yang mengaktifkan state awal. Sebelum kelas ini ada, semua
    // elemen normal dan terlihat.
    document.documentElement.classList.add('js-reveal');

    const pengamat = new IntersectionObserver((entri) => {
        entri.forEach((e) => {
            if (! e.isIntersecting) {
                return;
            }

            nyalakan(e.target);

            // Sekali saja. Kalau tidak, elemen akan dianimasikan ulang
            // setiap kali pengguna menggulir balik ke atas.
            pengamat.unobserve(e.target);
        });
    }, {
        threshold: AMBANG,
        rootMargin: MARGIN_AWARAT,
    });

    elemen.forEach((el) => pengamat.observe(el));

    // Kalau pengguna menyalakan reduced motion setelah halaman termuat,
    // elemen yang belum muncul ikut ditampilkan.
    kurangiGerak.addEventListener('change', (e) => {
        if (! e.matches) {
            return;
        }

        elemen.forEach((el) => {
            nyalakan(el);
            pengamat.unobserve(el);
        });
    });
}

export default pasangReveal;
