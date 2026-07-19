# Use Case Diagram Portal Alumni FTI

## Tujuan

Use Case Diagram menggambarkan interaksi antara aktor dengan fungsi Portal Alumni FTI. Diagram disusun berdasarkan route, middleware, komponen Livewire, controller, dan operasi yang tersedia pada implementasi aplikasi.

Sumber diagram: [`01-use-case-diagram.puml`](./01-use-case-diagram.puml).

## Aktor

| Aktor | Definisi | Hak akses utama |
| --- | --- | --- |
| Pengunjung | Pengguna yang belum melakukan autentikasi | Mengakses layanan publik, mendaftar, login, mengisi tracer study, dan mengirim pesan kontak |
| Alumni | Pengguna terautentikasi dengan role `alumni` | Seluruh layanan publik, dashboard alumni, pembaruan profil, pengajuan lowongan, forum, dan notifikasi |
| Admin | Pengguna terautentikasi dengan role `admin` | Dashboard admin, pengelolaan data dan konten, verifikasi lowongan, ekspor data, moderasi forum, dan pengaturan situs |

## Kelompok Use Case

### Autentikasi

- Mendaftar akun alumni dengan mencari dan memverifikasi NIM yang sudah tersedia pada data alumni.
- Login menggunakan email atau NIM.
- Logout untuk mengakhiri sesi terautentikasi.

### Layanan Publik

- Melihat Beranda.
- Melihat Profil dan Struktur Organisasi.
- Melihat, mencari, dan memfilter Data Alumni serta membuka detail alumni berdasarkan slug.
- Melihat Berita & Agenda serta detail berita.
- Melihat Karier & Kolaborasi serta detail lowongan yang disetujui dan masih aktif.
- Melihat Galeri yang sudah dipublikasikan admin.
- Melihat Kontak dan FAQ serta mengirim pesan kontak.
- Mengisi Tracer Study. Sistem memeriksa duplikasi berdasarkan email dan, untuk alumni yang login, berdasarkan `user_id`.

### Layanan Alumni

- Melihat ringkasan kelengkapan profil dan status pengajuan lowongan pada dashboard.
- Memperbarui profil dan daftar prestasi.
- Mengajukan lowongan dengan status awal `pending`.
- Melihat status lowongan yang pernah diajukan.
- Membaca, mengirim, dan membalas pesan forum.
- Melihat serta menandai notifikasi lowongan.

### Administrasi

- Melihat statistik pada dashboard admin.
- Mengelola slider Beranda.
- Mengelola profil organisasi, kanal kontak, logo, visi, misi, dan linimasa.
- Mengelola struktur organisasi.
- Mengelola serta mengekspor data alumni.
- Mengelola program Karier & Kolaborasi.
- Menyetujui atau menolak pengajuan lowongan.
- Mengelola dan mempublikasikan berita serta mengunggah gambar editor.
- Mengelola Galeri dan status publikasinya.
- Mengelola Testimoni dan FAQ.
- Mencari, memfilter, menghapus, dan mengekspor respons Tracer Study.
- Berpartisipasi sekaligus memoderasi Forum Alumni.
- Mengatur tema dan identitas situs.

## Penjelasan Relasi

- `<<include>>` digunakan ketika proses selalu memerlukan proses lain. Contohnya, pendaftaran selalu menyertakan verifikasi NIM dan pengisian tracer study selalu menyertakan pemeriksaan duplikasi.
- `<<extend>>` digunakan untuk tindakan lanjutan atau opsional. Contohnya, pengguna dapat membuka detail alumni dari direktori, sedangkan admin dapat memilih menyetujui atau menolak lowongan.

## Catatan Kesesuaian Implementasi

Menu publik menggunakan istilah **Berita & Agenda**, tetapi komponen admin yang tersedia saat ini hanya melakukan CRUD terhadap `NewsArticle`. Model dan data `EventAgenda` tersedia dan ditampilkan pada halaman publik, tetapi belum ada komponen admin untuk mengelolanya. Karena diagram harus sesuai implementasi, fungsi “Kelola Agenda” tidak dicantumkan sebagai use case admin.

Istilah **Alumni Unggulan** juga tidak digunakan. Alumni pada Beranda dan Karier ditampilkan menggunakan kriteria objektif `employment_status = Bekerja`.
