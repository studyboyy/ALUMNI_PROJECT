# Entity Relationship Diagram Portal Alumni FTI

Entity Relationship Diagram menggambarkan struktur data bisnis Portal Alumni FTI setelah seluruh migration aplikasi diterapkan. ERD berisi 14 entitas bisnis dan enam relasi foreign key.

Sumber diagram: [05-entity-relationship-diagram.puml](./05-entity-relationship-diagram.puml).

## Entitas

| Entitas | Fungsi |
| --- | --- |
| `users` | Menyimpan akun admin dan alumni |
| `alumni_profiles` | Menyimpan identitas akademik, pekerjaan, kontak, dan profil alumni |
| `career_opportunities` | Menyimpan lowongan yang diajukan alumni dan diverifikasi admin |
| `chat_messages` | Menyimpan pesan forum dan referensi balasan |
| `tracer_study_responses` | Menyimpan respons tracer study pengunjung atau alumni |
| `news_articles` | Menyimpan berita yang dapat diterbitkan sebagai konten publik |
| `event_agendas` | Menyimpan agenda kegiatan mendatang |
| `gallery_items` | Menyimpan metadata media Galeri dan status publikasi |
| `organization_members` | Menyimpan pengurus organisasi alumni |
| `work_programs` | Menyimpan program kerja, karier, dan kolaborasi |
| `testimonials` | Menyimpan testimoni alumni untuk Beranda |
| `faq_items` | Menyimpan pertanyaan dan jawaban yang sering diajukan |
| `contact_messages` | Menyimpan pesan yang dikirim melalui halaman Kontak |
| `site_settings` | Menyimpan konfigurasi dinamis seperti hero, profil, kontak, logo, dan tema |

## Relasi dan Kardinalitas

| Entitas induk | Entitas anak | Kardinalitas | Foreign key | Aturan penghapusan |
| --- | --- | --- | --- | --- |
| `users` | `alumni_profiles` | 0..1 ke 0..1 | `alumni_profiles.user_id` | Cascade |
| `users` | `chat_messages` | 1 ke 0..* | `chat_messages.user_id` | Cascade |
| `chat_messages` | `chat_messages` | 0..1 ke 0..* | `chat_messages.reply_to_id` | Set null |
| `users` | `tracer_study_responses` | 0..1 ke 0..* | `tracer_study_responses.user_id` | Set null |
| `users` | `career_opportunities` | 0..1 ke 0..* | `career_opportunities.submitted_by` | Set null |
| `users` | `career_opportunities` | 0..1 ke 0..* | `career_opportunities.approved_by` | Set null |

## Aturan Data Penting

- `users.email`, `alumni_profiles.nim`, `alumni_profiles.slug`, `career_opportunities.slug`, `news_articles.slug`, `event_agendas.slug`, `tracer_study_responses.email`, dan `site_settings.key` bersifat unik.
- `alumni_profiles.user_id` bersifat nullable karena profil dapat tersedia sebelum alumni membuat akun.
- Secara logika aplikasi, satu akun hanya memiliki satu profil alumni melalui relasi Eloquent `hasOne`. Migration saat ini belum memberikan unique index fisik pada `user_id`, sehingga label `UQ-logical` dipakai pada diagram.
- `tracer_study_responses.user_id` nullable karena tracer study dapat diisi tanpa login.
- Email tracer study bersifat unik untuk mencegah pengisian berulang.
- `career_opportunities.approval_status` memiliki nilai domain `pending`, `approved`, atau `rejected`.
- Lowongan hanya tampil kepada pengguna ketika berstatus `approved` dan `closes_at` belum lewat.
- Galeri dan berita menggunakan `published_at` nullable sebagai status publikasi.
- Kolom `alumni_profiles.is_featured` sudah dihapus. Alumni bekerja dipilih secara objektif melalui `employment_status = Bekerja`.

## Entitas Tanpa Foreign Key

Sebagian entitas konten tidak memiliki foreign key karena bersifat konten global yang dikelola admin. Entitas tersebut adalah `news_articles`, `event_agendas`, `gallery_items`, `organization_members`, `work_programs`, `testimonials`, `faq_items`, `contact_messages`, dan `site_settings`.

## Tabel Infrastruktur yang Tidak Ditampilkan

ERD tidak menampilkan tabel bawaan framework karena tidak merepresentasikan domain bisnis skripsi:

- `password_reset_tokens`
- `sessions`
- `cache` dan `cache_locks`
- `jobs`, `job_batches`, dan `failed_jobs`

Tabel tersebut tetap digunakan Laravel untuk autentikasi, session, cache, dan antrean, tetapi bukan bagian dari pengelolaan data alumni.
