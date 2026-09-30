# portal-sekolah

Public marketing site for **Sekolah Harapan Bangsa** (SMK). Laravel **13.34** / PHP **8.3.28** on Laragon (Windows).

A read-only public site: ~18 named routes, 3 controllers, no auth, no API, no admin, no forms that write. The only model is `User`. `User` and the three stock migrations are unused scaffolding.

**Not a git repository** — no branches, commits, or PR conventions.

## Commands

| Task | Command |
|---|---|
| Full dev stack (serve + queue + vite) | `php artisan dev` |
| List the processes `dev` would run | `php artisan dev:list` |
| App server only | `php artisan serve` |
| Tests | `php artisan test` |
| One test | `php artisan test --filter=ExampleTest` |
| Format / lint | `vendor/bin/pint` (`--test` to check only) |
| Tailing logs | `php artisan pail` |
| List routes | `php artisan route:list` |
| Build assets for production | `npm.cmd run build` |

`php artisan dev` comes from `laravel/pao` and runs `serve` + `queue:listen --tries=1 --timeout=0` + `npm run dev` in one process.

## Where the content lives (most important)

**There is no database behind this site yet.** All four content types are hardcoded, and each is a single, well-marked swap point:

- **Teacher profiles** → `config/guru.php`. View reads `config('guru')` directly. Also the single source of the headmaster's identity.
- **Headmaster welcome text** → `config/sambutan.php` (`sapaan`, `paragraf[]`, `motto`) — **prose only**. The name, degree, role, and photo are deliberately *not* there: `x-sambutan-kepala-sekolah` resolves them from `config('guru')` via `firstWhere('jabatan', 'Kepala Sekolah')`. Never add a second copy of the name there, or `/profil/guru-dan-staf` and the beranda will disagree.
- **Program Expertise / jurusan** → `config/program.php`. Fields: `slug`, `singkat`, `nama`, `deskripsi`, `kompetensi[]`, `peluang_kerja`.
- **School advantages / keunggulan** → `config/keunggulan.php` (`ikon`, `judul`, `deskripsi`). `ikon` holds only a **key**, never SVG markup — the SVG lives in `components/ikon.blade.php` so the config stays pure data. Known keys: `piala`, `perisai`, `toga`, `perkakas`, `hadiah`, `koper`, `bendera`, `buku`. An unknown key falls back to the `buku` path rather than rendering nothing.
- **News / berita** → `BeritaController::dummy()` (a private static method), *not* a config file. `terbaru($limit)` sorts by `tanggal` desc, so beranda and the berita index stay consistent. Fields: `slug`, `judul`, `kategori`, `gambar`, `ringkasan`, `isi`, `penulis`, `tanggal` (`Y-m-d` string, not a Carbon instance).

Each file carries a comment saying to replace it with a model query and **keep the field names identical** so the views don't change. Follow that instruction when the tables appear.

**Program slugs are duplicated**: `config/program.php` and the `$menuProgram` array in `partials/navbar.blade.php` list the same six jurusan independently. Adding a program means editing both, or it won't appear in the menu.

Photos and news images are generated placeholders, not real images. Both tools need the **GD extension** and a hardcoded font path `C:/Windows/Fonts/arialbd.ttf`, and overwrite files of the same name, so real images can just be dropped in to replace them:

- `php tools/make-placeholder-foto.php` — 640×640 PNG per entry in `config/guru.php` → `public/images/guru/`
- `php tools/make-placeholder-foto-berita.php` — 1600×1000 PNG per entry in the berita list → `public/images/berita/`

`x-kartu-berita` degrades to a category-colored gradient when `gambar` is absent or the file is gone (`is_file()` check), so a missing image never renders broken. New categories fall back to a slate badge rather than rendering unstyled.

## Routing conventions

`routes/web.php` is annotated in Indonesian. The rules that matter:

- **Always use named routes.** Never hardcode a URL in a view — `route('nama.route')`.
- `profil.*` pages live in a `Route::prefix('profil')->name('profil.')` group.
- Static pages are one-liners: `Route::view('/galeri', 'galeri')->name('galeri')`.
- `{slug}` params are constrained to `'[a-z0-9]+(?:-[a-z0-9]+)*'`. **Ordering is load-bearing:** `berita.index` is declared before `/berita/{slug}` so a path like `/berita/pengumuman` is never swallowed as a news slug. Keep new `index`/`show` pairs in that order.
- Missing slugs `abort_if(..., 404)` in the controller, not in the view.

## Blade conventions

Every page does `@extends('layouts.app')` and fills `@section('konten')`. `layouts/app.blade.php` branches on whether a `@section('hero')` exists:

- **Home page** supplies both `hero` and `konten` → sticky hero + `<main>` with negative top margin that scrolls up to cover the photo.
- **Inner pages** supply only `konten` → navbar is included with `['solid' => true]` and `main` is a plain wrapper.

Inner pages conventionally start with `<x-page-hero :l-breadcrumb="..." />`. Reusable components live in `resources/views/components/`: `page-hero`, `kartu-guru`, `kartu-berita`, `sambutan-kepala-sekolah`, `mengapa-sekolah`, `ikon`.

`beranda.blade.php` is the only page that supplies `@section('hero')`. Its `@section('konten')` holds three sibling sections in this order: `x-sambutan-kepala-sekolah`, then `x-mengapa-sekolah`, then the Berita Sekolah grid. Don't nest them or reorder — the welcome is a white band between the hero and the slate page background.

## Front end

- **Tailwind v4 via `@tailwindcss/vite`. There is no `tailwind.config.js`** — theme tokens go in the `@theme` block in `resources/css/app.css`.
- Fonts come from `laravel-vite-plugin`'s `bunny('Instrument Sans', { weights: [400,500,600] })` in `vite.config.js`. Change weights there, not in CSS.
- Vite's only inputs are `resources/css/app.css` and `resources/js/app.js`. Register any new entrypoint in the `input` array before referencing it from Blade.
- Alpine is the only JS framework. `resources/js/app.js` boots Alpine, then calls the hero scroll animation and `pasangReveal()` from `resources/js/reveal.js` (a separate module, imported — **not** a Vite input; don't add it to `vite.config.js`). Elements hidden with `x-show` need `x-cloak` (the `[x-cloak]` rule in `app.css` exists because Alpine isn't ready at first paint).

### Scroll reveal

`resources/js/reveal.js` animates elements once as they enter the viewport (`IntersectionObserver`, threshold `0.01`, `rootMargin: 0px 0px -12% 0px`).

Directions: `left`, `right`, `up`, `down`. **The value names the side the element comes *from*, not the way it travels** — `up` starts below and moves up, `down` starts above and moves down. They look interchangeable in the markup but produce opposite motion; `up` uses a positive `translateY`, `down` a negative one (`calc(var(--reveal-jarak-y) * -1)`).

There are **two** attributes, and picking the wrong one is the most common way to make the animation feel sluggish:

| Attribute | Watched by JS? | Use for |
|---|---|---|
| `data-reveal` | yes, individually | independent items — Berita cards, the welcome photo |
| `data-reveal-group` | yes, as one unit | a container whose children must cascade |
| `data-reveal-item` | **no** | children of a group; only their group lights them up |

**Never put `data-reveal` on each line of a sequential block.** Each line would then be observed on its own, so a line that scrolls into view late still carries its full `--reveal-delay` and waits that long again — a double delay. On mobile the welcome column is taller than the viewport, so the last paragraph would visibly stall. Use `data-reveal-group` on the column and `data-reveal-item` on each line; the group fires once and every line starts from the same instant.

In `sambutan-kepala-sekolah`: the group wraps the text column (9 items, `left`, 70ms apart, 0–560ms), and the photo beside it is a plain `data-reveal="right"`. Directions **match** their column. Don't cross them — crossing was tried and reads as two things sliding through each other. The Berita header and cards use `up`. `mengapa-sekolah` uses one group wrapping header *and* grid, every child `down`, so the whole section unfurls top-to-bottom from a single trigger.

Two rules that are easy to break:

1. **The hidden state is gated behind `.js-reveal` on `<html>`, added by JS only after confirming `IntersectionObserver` exists.** Without JS the CSS never applies, so content is always visible. Don't move `opacity: 0` out from under that class, or the whole section vanishes when JS is blocked. The `prefers-reduced-motion` block in `app.css` also forces everything visible — and it lists `[data-reveal-item]` too, since a group item must stay visible even if its group never fires.
2. **Put `data-reveal` on a wrapper, never on `x-kartu-berita` itself.** The card has its own `hover:-translate-y-1`; reveal also uses `transform`, so attaching both to one element makes them fight and the hover lift dies. That's why `beranda.blade.php` wraps each card in a plain `<div>`.

### Reveal tuning — why these exact numbers

Motion lives in four `:root` custom properties in `app.css`, so any section can retune itself via inline `style` without touching the global values:

| Property | Default | Meaning |
|---|---|---|
| `--reveal-ease` | `cubic-bezier(0.16, 1, 0.3, 1)` | expo-out; the long tail is what reads as "smooth" |
| `--reveal-dur` | `0.72s` | default for large elements (the 4:5 photo) |
| `--reveal-jarak-x` | `1.5rem` | horizontal travel |
| `--reveal-jarak-y` | `1.1rem` | vertical travel |

The welcome text column overrides the first three: `--reveal-dur: 560ms; --reveal-jarak-x: 0.75rem`. `mengapa-sekolah` overrides only the vertical pair: `--reveal-dur: 1s; --reveal-jarak-y: 1rem` — a slow 1s ease is what "top-to-bottom, gentle" actually means, and the short travel keeps it from reading as a fall.

**What drives the "sluggish" feeling is the ratio of distance to duration, not duration alone.** Two rounds of complaints about it, both real:

- **Round 1** (whole block slid in): travel was `2.5rem` over `0.9s`, and `threshold: 0.15` meant a tall photo was already at the bottom of the screen before it started. Now `1.5rem` / `0.72s` / `0.01`.
- **Round 2** (line-by-line): a short sentence line travelling `1.5rem` over `0.72s` looks like it is *jumping*. Small elements need a shorter distance *and* a shorter duration, hence the column-local `0.75rem` / `560ms`.

Don't raise distance or duration to "make it more dramatic" — a long slide is exactly what makes it feel slow. Don't lower them without also lowering the other; that ratio is the whole lever.

**Stagger: 70ms** for the 9 welcome lines, **60ms** for the 8 keunggulan cards. Below ~50ms the elements move so close together the sequence is unreadable and collapses back into one block; above ~100ms it becomes a queue, each element visibly waiting for the last to finish. The goal is "one by one", not "one at a time".

A long `--reveal-dur` and a stagger compound: 9 elements at 1s and 60ms apart finishes at ~1.5s, and that is the honest cost of "slow and gentle" across a whole section. It's a deliberate trade, not an oversight — trim the stagger, not the easing, if it ever feels too slow.

### Hero CSS invariants — easy to break silently

`app.css` and `layouts/app.blade.php` document these at length. The non-obvious ones:

1. **Never put `transform`/`filter`/`will-change` on the hero photo or any ancestor of the navbar.** It makes `position: fixed` resolve against that ancestor instead of the viewport, and the navbar detaches. The hero is `position: sticky` with `height: 90svh` — **exactly** 90svh, not `min-height`, or it gets cropped. The photo never moves; `<main>` is what covers it (z-20, negative margin, opaque `bg-slate-50`).
   This is also why `reveal.js` is a separate module: nothing in it may ever target an element that wraps the navbar. Everything it animates lives inside `<main>`, which is a *sibling* of the navbar, so it's safe.
2. **Navbar and hero must be siblings, never nested.** The navbar transitions `absolute` → `fixed` under Alpine; nesting it inside the hero breaks the effect.
3. All motion must respect the `prefers-reduced-motion: reduce` block at the bottom of `app.css`.

## Windows / PowerShell traps

- **`npm` is blocked** — PowerShell resolves it to `C:\Program Files\nodejs\npm.ps1` and the execution policy won't run it (hangs). Always use **`npm.cmd`**: `npm.cmd install`, `npm.cmd run dev`, `npm.cmd run build`.
- `php`, `composer`, and `vendor/bin/pint` work directly — no `.bat` workaround.
- `php artisan dev` shells out to `npm run dev` internally, so it works; but manual npm calls need `npm.cmd`.

## Artisan output is JSON, not prose (`laravel/pao`)

`laravel/pao` is a dev dependency. When it detects an agent session it rebinds console output, strips ANSI, and collapses results into one NDJSON line. This **is** the passing result:

```json
{"tool":"phpunit","result":"passed","tests":2,"passed":2,"assertions":2,"duration_ms":225}
```

`vendor/bin/pint --test` likewise prints `{"tool":"pint","result":"passed"}`. Do not go hunting for a broken reporter. It's skipped when already running unit tests. Read the env vars from `$_SERVER`:

- `$env:PAO_DISABLE='1'` → human-readable output (needed for `php artisan about`, `route:list`, etc.)
- `$env:PAO_FORCE='1'` → force the agent path on

## Database

SQLite at `database/database.sqlite`. `.env` sets `SESSION_DRIVER`, `CACHE_STORE`, and `QUEUE_CONNECTION` all to `database`, so the `sessions`, `cache`, and `jobs` tables must exist — run `php artisan migrate` if the file is ever recreated.

`public/storage` is **NOT LINKED** (`php artisan about` confirms it). No feature uses it yet; run `php artisan storage:link` before adding any file upload.

**Run `php artisan config:clear` after editing anything in `config/`.** This bites hard here because site content lives in config files — cached config silently serves stale content. `composer test` does this for you before `artisan test`.

## Tests

Effectively no coverage: `tests/Feature/ExampleTest.php` and `tests/Unit/ExampleTest.php` are the stock stubs, and the only assertion is that `GET /` returns 200. Don't assume the suite protects any behavior. The feature test **will** catch a broken `@vite` setup or a fatal in the home page, so it's a cheap smoke check.

`phpunit.xml` uses **in-memory SQLite** (`DB_DATABASE=:memory:`), `array` cache/session, and `sync` queue — the suite never touches the dev database file. `Tests\TestCase` is bare: there is **no** `RefreshDatabase` trait, so add `use RefreshDatabase;` to any test that hits the database.

## Conventions

- Skeleton-style bootstrapping, no `app/Http/Kernel.php`. Middleware/exceptions go in `bootstrap/app.php`; providers in `bootstrap/providers.php`. `AppServiceProvider` is empty.
- `bootstrap/app.php` registers **only** `routes/web.php` and `routes/console.php`. There is no `routes/api.php` — add one there before assuming API routes resolve. The exception handler already renders JSON for `api/*` and `expectsJson()` requests.
- Pint runs the default Laravel preset (no `pint.json`).
- **All UI copy is Indonesian**, and all code comments are too — match that when you add files. `APP_LOCALE` is still `en` in `.env` and there is no `lang/` directory; copy is hardcoded in Blade, not translated. Don't start localizing without asking.
- `APP_NAME` is still `Laravel` in `.env`; the real name lives only in the navbar partial.

## `public/hot` — read this before debugging blank pages

`public/hot` is Laravel's Vite dev-server marker. `Vite::isRunningHot()` is just `is_file(public_path('/hot'))`, so **its mere existence** makes `@vite` emit script/link tags pointing at the URL inside it (currently `http://[::1]:5173`) instead of reading `public/build/manifest.json`.

Consequences:
- If the Vite dev server isn't running, **every page renders with no CSS and no JS** while looking like a Tailwind bug. Delete `public/hot` to fall back to the built assets in `public/build/` (which are present and current).
- The marker is created by `npm run dev` and removed on clean shutdown. A crashed dev server can leave it behind.
- `php artisan serve` alone never builds anything — if you only ever run the server, delete `public/hot` and use `npm.cmd run build`.

## Other notes

- `CLAUDE.md` holds Laravel's stock Boost bootstrap stub, not real project guidance. Prefer this file; don't follow `CLAUDE.md`'s instruction to install Boost unless the user asks. Installing it (`composer require laravel/boost --dev` + `php artisan boost:install`) **rewrites `AGENTS.md`** — merge back anything it drops.
- No static analysis: no PHPStan, Rector, or Pest. Plain PHPUnit 12.
- No CI config (`.github/` does not exist) and no `opencode.json`.
