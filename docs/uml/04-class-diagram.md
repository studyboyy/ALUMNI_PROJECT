# Class Diagram Portal Alumni FTI

Class Diagram menggambarkan struktur kelas aplikasi beserta atribut, operasi, relasi, dan dependensinya. Diagram mencakup model domain, komponen Livewire publik, komponen alumni, komponen admin, controller, middleware, event, dan utilitas ekspor.

Sumber diagram: [04-class-diagram.puml](./04-class-diagram.puml).

## Kelompok Kelas

| Kelompok | Tanggung jawab |
| --- | --- |
| Domain Model | Merepresentasikan data serta query scope dan relasi Eloquent |
| Public & Authentication Components | Menangani halaman publik, login, dan registrasi |
| Alumni Components | Menangani dashboard, profil, lowongan, forum, dan notifikasi alumni |
| Admin Components | Menangani dashboard dan pengelolaan seluruh data/konten admin |
| HTTP, Event & Support | Menangani middleware, endpoint ekspor/upload/API, event, dan pembuatan XLSX |

## Relasi Model Utama

- `User` memiliki nol atau satu `AlumniProfile`. Profil tanpa akun digunakan sebagai data awal untuk registrasi berdasarkan NIM.
- `User` dapat mengirim banyak `ChatMessage`.
- `ChatMessage` dapat membalas satu pesan lain dan dapat memiliki banyak balasan.
- `User` dapat memiliki respons `TracerStudyResponse`; foreign key bersifat nullable agar pengunjung juga dapat mengisi tracer study.
- `User` dapat mengajukan banyak `CareerOpportunity` melalui `submitted_by`.
- Admin sebagai `User` dapat memverifikasi banyak `CareerOpportunity` melalui `approved_by`.

## Notasi

- `+` menunjukkan anggota publik.
- `-` menunjukkan anggota tersembunyi.
- Tanda `?` menunjukkan atribut yang dapat bernilai null.
- Garis asosiasi menunjukkan relasi objek/domain.
- Panah putus-putus menunjukkan ketergantungan komponen terhadap model atau layanan.
- Stereotipe `Model`, `Livewire`, `Controller`, `Middleware`, `Event`, dan `Utility` memperjelas peran kelas.

## Batasan Implementasi

`EventAgenda` merupakan model aktif yang dibaca oleh Beranda, halaman Berita & Agenda, dan Dashboard Admin. Namun, belum terdapat komponen manager admin untuk operasi CRUD agenda. Karena itu diagram tidak menghubungkan `EventAgenda` dengan manager yang belum tersedia.

`ChatMessageSent` tersedia sebagai event broadcasting, tetapi metode `send()` pada forum saat ini belum melakukan dispatch event tersebut. Forum memperbarui pesan menggunakan polling Livewire.
