# portal-sekolah

Public marketing site for **Sekolah Harapan Bangsa** (SMK). Laravel **13.34** (`^13.17` in `composer.json`) / PHP **8.3** on Laragon (Windows).

A read-only public site: 18 named routes, 3 controllers, no auth, no API, no admin, no forms that write. The only model is `User`; `User` and the three stock migrations are unused scaffolding. Git repo on `main`, remote `origin`.

## Commands

| Task | Command |
|---|---|
| Full dev stack (serve + queue + vite) | `php artisan dev` |
| List the processes `dev` would run | `php artisan dev:list` |
| Tests **with cached config cleared first** | `composer test` |
| One test | `php artisan test --filter=ExampleTest` |
| Format / lint | `vendor/bin/pint` (`--test` to check only) |
| Tailing logs | `php artisan pail` |
| List routes | `php artisan route:list` |
| Build assets for production | `npm.cmd run build` |

`php artisan dev` and `dev:list` come from `laravel/pao` (dev dependency) and run `serve` + `queue:listen --tries=1 --timeout=0` + `npm run dev` in one process. No PHPStan/Rector/Pest, no `npm test`, no CI (`.github/` does not exist), no `opencode.json`. Pint runs the default Laravel preset (no `pint.json`); `.editorconfig` is LF / 4-space / UTF-8.

## Windows / PowerShell traps

- **`npm` is blocked** — PowerShell resolves it to `C:\Laragon\bin\nodejs\node-v22\npm.ps1` and the execution policy won't run it (hangs). Always use **`npm.cmd`**: `npm.cmd install`, `npm.cmd run dev`, `npm.cmd run build`. `php`, `composer`, and `vendor/bin/pint` work directly.
- `php artisan dev` shells out to `npm run dev` internally, so it works; manual npm calls need `npm.cmd`.

## Artisan output is JSON, not prose (`laravel/pao`)

When it detects an agent session `laravel/pao` rebinds console output, strips ANSI, and collapses results into one NDJSON line. This **is** the passing result:

```json
{"tool":"phpunit","result":"passed","tests":2,"passed":2,"assertions":2,"duration_ms":225}
```

`vendor/bin/pint --test` likewise prints `{"tool":"pint","result":"passed"}`. Do not go hunting for a broken reporter. It's skipped when already running unit tests. Read the env vars from `$_SERVER`:

- `$env:PAO_DISABLE='1'` → human-readable output (needed for `php artisan about`, `route:list`, etc.)
- `$env:PAO_FORCE='1'` → force the agent path on

## `public/hot` — read this before debugging blank pages

`public/hot` is Laravel's Vite dev-server marker and **it currently exists** (`http://[::1]:5173`). `Vite::isRunningHot()` is just `is_file(public_path('/hot'))`, so its mere presence makes `@vite` emit tags pointing at that URL instead of reading `public/build/manifest.json` — so a built `public/build/` is dead weight while the marker is there.

Consequences:
- If the Vite dev server isn't running, **every page renders with no CSS and no JS** while looking like a Tailwind bug. This is the single most misleading failure in the repo.
- To serve from built assets instead: `npm.cmd run build`, and **delete `public/hot`**. The marker is created by `npm run dev` and removed on clean shutdown; a crashed dev server leaves it behind.
- `php artisan serve` alone never builds anything.
- Both `public/hot` and `public/build` are gitignored, so building doesn't dirty the repo.

## Where the content lives (most important)

**There is no database behind this site yet.** All five content types are hardcoded, and each is a single, well-marked swap point:

- **Teacher profiles** → `config/guru.php` (6 entries). View reads `config('guru')` directly. Also the single source of the headmaster's identity.
- **Headmaster welcome text** → `config/sambutan.php` (`sapaan`, `paragraf[]`, `motto`) — **prose only**. The name, degree, role, and photo are deliberately *not* there: `x-sambutan-kepala-sekolah` resolves them from `config('guru')` via `firstWhere('jabatan', 'Kepala Sekolah')`. Never add a second copy of the name there, or `/profil/guru-dan-staf` and the beranda will disagree.
- **Program Expertise / jurusan** → `config/program.php` (6 entries). Fields: `slug`, `singkat`, `nama`, `deskripsi`, `kompetensi[]`, `peluang_kerja`.
- **School advantages / keunggulan** → `config/keunggulan.php` (8 entries; `ikon`, `judul`, `deskripsi`).
- **Student activities & works** → `config/kegiatan.php` (7 entries). Fields: `tipe` (`video`|`foto`), `kategori`, `judul`, `ringkasan`, `gambar`, `tanggal`, `tautan`. One flat list: `x-kegiatan-karya` sorts by `tanggal` desc, takes `first()` as the featured panel and `slice(1)` as the grid, so file order never decides what is featured. **`tautan` is `null` for `foto` and that is valid** — the card renders with no link rather than a dead one. The `tautan` values currently in the file are `CONTOH-…` placeholders; replace before publishing.
- **News / berita** → `BeritaController::dummy()` (a private static method), *not* a config file. `terbaru($limit)` sorts by `tanggal` desc so beranda and the berita index stay consistent. Fields: `slug`, `judul`, `kategori`, `gambar`, `ringkasan`, `isi`, `penulis`, `tanggal` (`Y-m-d` string, not a Carbon instance).

Each file carries a comment saying to replace it with a model query and **keep the field names identical** so the views don't change. Follow that instruction when the tables appear.

**Program slugs are duplicated**: `config/program.php` and the `$menuProgram` array in `partials/navbar.blade.php` list the same six jurusan independently. Adding a program means editing both, or it won't appear in the menu.

Photos and news images are generated placeholders, not real images. Both tools need the **GD extension** (present) and a hardcoded font path `C:/Windows/Fonts/arialbd.ttf`, and overwrite files of the same name, so real images can just be dropped in to replace them:

- `php tools/make-placeholder-foto.php` — 640×640 PNG per entry in `config/guru.php` → `public/images/guru/`
- `php tools/make-placeholder-foto-kegiatan.php` — 1600×1000 PNG per entry in `config/kegiatan.php` → `public/images/kegiatan/`. It reads the config rather than carrying its own list, so a new entry gets an image on re-run.

`x-kartu-berita` degrades to a category-colored gradient when `gambar` is absent or the file is gone (`is_file()` check), so a missing image never renders broken. New categories fall back to a slate badge rather than rendering unstyled.

The hero photo is **`public/images/baground.png`** — the misspelling is load-bearing, it's hardcoded in `layouts/app.blade.php`. Don't "fix" it without renaming the file too.

## Routing conventions

`routes/web.php` is annotated in Indonesian. The rules that matter:

- **Always use named routes.** Never hardcode a URL in a view — `route('nama.route')`. (Currently zero hardcoded `href="/..."` in `resources/views/`; keep it that way.)
- `profil.*` pages live in a `Route::prefix('profil')->name('profil.')` group.
- Static pages are one-liners: `Route::view('/galeri', 'galeri')->name('galeri')`.
- `{slug}` params are constrained to `'[a-z0-9]+(?:-[a-z0-9]+)*'`. **Ordering is load-bearing:** `berita.index` and `program.index` are declared before their `{slug}` siblings so a path like `/berita/pengumuman` is never swallowed as a news slug. Keep new `index`/`show` pairs in that order.
- Missing slugs `abort_if(..., 404)` in the controller, not in the view.

## Blade conventions

Every page does `@extends('layouts.app')` and fills `@section('konten')`. `layouts/app.blade.php` branches on whether a `@section('hero')` exists:

- **Home page** supplies both `hero` and `konten` → sticky hero + `<main>` with negative top margin that scrolls up to cover the photo.
- **Inner pages** supply only `konten` → navbar is included with `['solid' => true]` and `main` is a plain wrapper.

Inner pages conventionally start with `<x-page-hero :l-breadcrumb="..." />`. Reusable components live in `resources/views/components/`: `page-hero`, `kartu-guru`, `kartu-berita`, `sambutan-kepala-sekolah`, `mengapa-sekolah`, `kegiatan-karya`, `ikon`.

`beranda.blade.php` is the only page that supplies `@section('hero')`. Its `@section('konten')` holds four sibling sections in this order: `x-sambutan-kepala-sekolah`, `x-mengapa-sekolah`, `x-kegiatan-karya`, then the Berita Sekolah grid. Don't nest them or reorder — the welcome is a white band between the hero and the slate page background, and the section backgrounds alternate white → slate-50 → white → slate-50 on purpose.

## Front end

- **Tailwind v4 via `@tailwindcss/vite`. There is no `tailwind.config.js`** — theme tokens go in the `@theme` block in `resources/css/app.css`.
- Fonts come from `laravel-vite-plugin`'s `bunny('Instrument Sans', { weights: [400,500,600] })` in `vite.config.js`. Change weights there, not in CSS.
- Vite's only inputs are `resources/css/app.css` and `resources/js/app.js`. Register any new entrypoint in the `input` array before referencing it from Blade.
- Alpine is the only JS framework. `resources/js/app.js` boots Alpine, then calls the hero scroll animation and `pasangReveal()` from `resources/js/reveal.js` (a separate module, imported — **not** a Vite input; don't add it to `vite.config.js`). Elements hidden with `x-show` need `x-cloak` (the `[x-cloak]` rule in `app.css` exists because Alpine isn't ready at first paint).
- `resources/js/bootstrap.js` and `resources/views/welcome.blade.php` are **dead** leftovers from the skeleton — nothing imports or routes them. Leave them or delete them; don't treat either as an entrypoint.

### Scroll reveal

`resources/js/reveal.js` animates elements once as they enter the viewport (`IntersectionObserver`, threshold `0.01`, `rootMargin: 0px 0px -12% 0px`). Currently used in exactly four places: `beranda.blade.php` (Berita header + cards), `components/mengapa-sekolah.blade.php`, `components/sambutan-kepala-sekolah.blade.php`, and `components/kegiatan-karya.blade.php`.

Directions: `left`, `right`, `up`, `down`. **The value names the side the element comes *from*, not the way it travels** — `up` starts below and moves up, `down` starts above and moves down. They look interchangeable in the markup but produce opposite motion.

There are **three** attributes, and picking the wrong one is the most common way to make the animation feel sluggish:

| Attribute | Watched by JS? | Use for |
|---|---|---|
| `data-reveal` | yes, individually | independent items — Berita cards, the welcome photo |
| `data-reveal-group` | yes, as one unit | a container whose children must cascade |
| `data-reveal-item` | **no** | children of a group; only their group lights them up |

**Never put `data-reveal` on each line of a sequential block.** Each line would then be observed on its own, so a line that scrolls into view late still carries its full `--reveal-delay` and waits that long again — a double delay. On mobile the welcome column is taller than the viewport, so the last paragraph would visibly stall. Use `data-reveal-group` on the column and `data-reveal-item` on each line; the group fires once and every line starts from the same instant.

**Put `data-reveal` on a wrapper, never on `x-kartu-berita` itself.** The card has its own `hover:-translate-y-1`; reveal also uses `transform`, so attaching both to one element makes them fight and the hover lift dies.

**Match reveal direction to the column it sits in.** In `sambutan-kepala-sekolah` the text group enters `left` and the photo beside it enters `right`, so both drift the way your eye reads (left→right). Crossing them was tried and reads as two things sliding through each other.

Three rules that are easy to break:

1. **The hidden state is gated behind `.js-reveal` on `<html>`, added by JS only after confirming `IntersectionObserver` exists.** Without JS the CSS never applies, so content is always visible. Don't move `opacity: 0` out from under that class, or the whole section vanishes when JS is blocked. The `prefers-reduced-motion` block in `app.css` also forces everything visible — and it lists `[data-reveal-item]` too, since a group item must stay visible even if its group never fires.
2. **Any new motion must respect the `prefers-reduced-motion: reduce` block at the bottom of `app.css`** — and components pair Tailwind's `motion-reduce:` variants alongside it.
3. **Don't retune motion by raising distance or duration.** What reads as "sluggish" is the *ratio* of travel to duration, not duration alone; a long slide is exactly what feels slow. Motion lives in four `:root` custom properties in `app.css` (`--reveal-ease`, `--reveal-dur`, `--reveal-jarak-x`, `--reveal-jarak-y`) so a section can retune itself via inline `style` without touching global values. Stagger stays between ~50ms and ~100ms: below that the sequence collapses into one block, above it becomes a queue. `app.css` and the four components document the exact numbers and the reasoning — read them before changing any value.
4. **`Collection::slice()` keeps the original keys**, so `$daftar->slice(1)` inside a `@foreach` yields `$index` starting at **1**, not 0. Add `->values()` or every `--reveal-delay` computed from `$index` silently shifts by one step and the first gap lands outside the 50–100ms band. `x-kegiatan-karya` hit exactly this.

### Hero CSS invariants — easy to break silently

`app.css` and `layouts/app.blade.php` document these at length. The non-obvious ones:

1. **Never put `transform`/`filter`/`will-change` on the hero photo or any ancestor of the navbar.** It makes `position: fixed` resolve against that ancestor instead of the viewport, and the navbar detaches. The hero is `position: sticky` with `height: 90svh` — **exactly** 90svh, not `min-height`, or it gets cropped. The photo never moves; `<main>` is what covers it (z-20, negative margin, opaque `bg-slate-50`).
   This is also why `reveal.js` is a separate module: nothing in it may ever target an element that wraps the navbar. Everything it animates lives inside `<main>`, which is a *sibling* of the navbar, so it's safe.
2. **Navbar and hero must be siblings, never nested.** The navbar transitions `absolute` → `fixed` under Alpine; nesting it inside the hero breaks the effect.

## Database

SQLite at `database/database.sqlite`. `.env` sets `SESSION_DRIVER`, `CACHE_STORE`, and `QUEUE_CONNECTION` all to `database`, so the `sessions`, `cache`, and `jobs` tables must exist — run `php artisan migrate` if the file is ever recreated.

`public/storage` is **NOT LINKED**. No feature uses it yet; run `php artisan storage:link` before adding any file upload.

**Run `php artisan config:clear` after editing anything in `config/`.** This bites hard here because site content lives in config files — cached config silently serves stale content. `composer test` does this for you before `artisan test`.

## Localization trap

`APP_LOCALE` and `APP_FALLBACK_LOCALE` are both `en` and there is **no `lang/` directory**. `x-kartu-berita` therefore renders dates via `Carbon::translatedFormat('d F Y')`, which produces **English month names — "28 October 2026"** on an otherwise all-Indonesian site. Every other string is hardcoded Indonesian in Blade, not translated.

`->locale('id')` fixes it with **no `lang/` files at all** — Carbon bundles its own Indonesian month names (verified: `->locale('id')->translatedFormat('d F Y')` → `28 Oktober 2026`). `x-kegiatan-karya` already does this, so the two components disagree today; `kartu-berita` still needs the one-word change. Half-localized was not fixed unilaterally because the right long-term answer is `APP_LOCALE=id` plus `php artisan lang:publish`, which would affect every `translatedFormat`/`__()` at once — ask before doing that.

## Tests

Effectively no coverage: `tests/Feature/ExampleTest.php` and `tests/Unit/ExampleTest.php` are the stock stubs, and the only assertion is that `GET /` returns 200. Don't assume the suite protects any behavior. The feature test **will** catch a broken `@vite` setup or a fatal in the home page, so it's a cheap smoke check.

`phpunit.xml` uses **in-memory SQLite** (`DB_DATABASE=:memory:`), `array` cache/session, and `sync` queue — the suite never touches the dev database file. `Tests\TestCase` is bare: there is **no** `RefreshDatabase` trait, so add `use RefreshDatabase;` to any test that hits the database.

## Conventions

- Skeleton-style bootstrapping, no `app/Http/Kernel.php`. Middleware/exceptions go in `bootstrap/app.php`; providers in `bootstrap/providers.php`. `AppServiceProvider` is empty.
- `bootstrap/app.php` registers **only** `routes/web.php` and `routes/console.php`. There is no `routes/api.php` — add one there before assuming API routes resolve. The exception handler already renders JSON for `api/*` and `expectsJson()` requests.
- **All UI copy is Indonesian**, and all code comments are too — match that when you add files. Don't start localizing without asking.
- `APP_NAME` is still `Laravel` in `.env`; `x-mengapa-sekolah` works around that with an inline fallback to "Sekolah Harapan Bangsa". The real name lives only in the navbar partial.

## Other notes

- `README.md` is the stock Laravel readme; `CLAUDE.md` holds Laravel's stock Boost bootstrap stub, not real project guidance. Prefer this file; don't follow `CLAUDE.md`'s instruction to install Boost unless the user asks. Installing it (`composer require laravel/boost --dev` + `php artisan boost:install`) **rewrites `AGENTS.md`** — merge back anything it drops.
- `config/keunggulan.php` `ikon` holds only a **key**, never SVG markup — the SVG lives in `components/ikon.blade.php` so the config stays pure data. Known keys: `piala`, `perisai`, `toga`, `perkakas`, `hadiah`, `koper`, `bendera`, `putar`. Note `buku` is **not** an explicit case — it's the `@default` branch, which is the book SVG. Unknown keys also fall back there rather than rendering nothing, so adding an `@case('buku')` without keeping the default would break unknown-key handling. `putar` is the only filled/solid glyph (it needs `fill`, not `stroke`) and is used by `x-kegiatan-karya`.
