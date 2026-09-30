import Alpine from 'alpinejs';
import pasangReveal from './reveal';

window.Alpine = Alpine;

Alpine.start();

/*
 * ------------------------------------------------------------------
 * Gerak hero
 *
 * FOTO HERO TIDAK DIGESER SAMA SEKALI. Hero-nya yang diam, bukan fotonya
 * yang melambat. Alasannya permintaan eksplisit: background harus terlihat
 * statis di tempat, dan konten dari bawah yang menutupinya.
 *
 * Konsekuensi: scale/translate pada foto dihapus dari CSS juga. Selain
 * karena akan terlihat bergerak melawan arah scroll, `transform` pada
 * leluhur membuat `position: fixed` dihitung terhadap leluhur itu, bukan
 * terhadap viewport.
 *
 * Yang bergerak hanya teks hero: sedikit naik dan memudar sementara konten
 * mulai menutup. Nilainya kecil supaya teks tetap terbaca, dan seluruhnya
 * dimatikan kalau pengguna meminta reduced motion.
 * ------------------------------------------------------------------
 */

// Dz dipakai dalam persen tinggi elemen, jadi 0.1 = 10% dari tinggi hero.
const JALAN_TEKS = 0.1;

// Teks tidak pernah hilang sepenuhnya, masih terbaca saat mulai tertutup.
const TEKS_MIN = 0.4;

const kurangiGerak = window.matchMedia('(prefers-reduced-motion: reduce)');

function pasangGerakHero() {
    const kanvas = document.querySelector('[data-hero]');

    if (!kanvas) {
        return;
    }

    const teks = kanvas.querySelector('[data-hero-teks]');

    if (!teks) {
        return;
    }

    let sudahDijadwalkan = false;

    const gambar = () => {
        sudahDijadwalkan = false;

        if (kurangiGerak.matches) {
            teks.style.opacity = '';
            teks.style.transform = '';

            return;
        }

        const tinggi = kanvas.getBoundingClientRect().height || 1;
        const jarak = Math.min(Math.max(window.scrollY / tinggi, 0), 1);

        teks.style.transform = `translate3d(0, ${(-jarak * JALAN_TEKS * 100).toFixed(2)}%, 0)`;
        teks.style.opacity = Math.max(1 - jarak * (1 - TEKS_MIN), TEKS_MIN).toFixed(3);
    };

    const minta = () => {
        if (sudahDijadwalkan) {
            return;
        }

        sudahDijadwalkan = true;
        window.requestAnimationFrame(gambar);
    };

    window.addEventListener('scroll', minta, { passive: true });
    window.addEventListener('resize', minta, { passive: true });
    kurangiGerak.addEventListener('change', minta);

    gambar();
}

pasangGerakHero();

/*
 * Scroll reveal untuk section di bawah hero. Dipisah ke modul sendiri karena
 * aturan mainannya berbeda total dari hero di atas: hero digerakkan setiap
 * kali scroll, sedangkan reveal hanya sekali saat elemen masuk layar.
 */
pasangReveal();
