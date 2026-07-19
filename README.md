# Portal Alumni FTI

Portal alumni berbasis Laravel dan Livewire untuk mengelola direktori alumni, tracer study, berita dan agenda, karier dan kolaborasi, galeri, serta komunikasi alumni.

## Teknologi

- PHP 8.3 dan Laravel 13
- Livewire 4 dan Blade
- Tailwind CSS 4 dan Vite 8
- MySQL untuk pengembangan lokal
- Pest untuk pengujian

## Instalasi Lokal

```bash
composer install
npm install
copy .env.example .env
php artisan key:generate
```

Atur koneksi database pada `.env`, kemudian jalankan:

```bash
php artisan migrate:fresh --seed
php artisan storage:link
npm run build
composer run dev
```

`composer run dev` menjalankan server Laravel, queue worker, dan Vite secara bersamaan.

## Akun Seeder

- Admin: `admin@alumni-fti.ac.id`
- Password admin: `Admin123!`
- Password seluruh akun alumni hasil seeder: `Alumni123!`

Seeder membuat 8 alumni dengan akun dan 20 profil alumni tanpa akun. Email akun alumni dapat dilihat pada tabel `users`.

## Pengujian dan Pemeriksaan Kode

```bash
composer test
npm run build
```

Test menggunakan SQLite sementara dan tidak memerlukan database MySQL lokal. Layout Vite dinonaktifkan pada lingkungan test sehingga test dapat dijalankan sebelum frontend dibangun.

## Struktur Menu dan Sinkronisasi

| Halaman pengguna | Pengelolaan admin |
| --- | --- |
| Beranda | Kelola Beranda, Beranda — Testimoni, Beranda — FAQ |
| Profil | Kelola Profil, Profil — Struktur Organisasi |
| Data Alumni | Kelola Data Alumni |
| Tracer Study | Kelola Tracer Study |
| Berita & Agenda | Kelola Berita & Agenda |
| Karier & Kolaborasi | Karier & Kolaborasi — Program, Karier & Kolaborasi — Lowongan |
| Galeri | Kelola Galeri |
| Kontak | Data kontak pada Kelola Profil |

Data pada halaman pengguna dan admin menggunakan tabel yang sama. Perubahan admin langsung menjadi sumber tampilan publik sesuai status publikasi masing-masing konten.

## Catatan Alumni Sudah Bekerja

Aplikasi tidak menggunakan penilaian subjektif "Alumni Unggulan". Bagian alumni pada Beranda dan Karier menggunakan kategori objektif `employment_status = Bekerja`, dan direktori menampilkannya sebagai "Sudah Bekerja".
