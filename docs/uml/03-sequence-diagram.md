# Sequence Diagram Portal Alumni FTI

Sequence Diagram menggambarkan urutan pesan antaraktor, antarmuka, komponen Livewire/controller, model, layanan framework, storage, dan database. Seluruh diagram diselaraskan dengan Activity Diagram dan implementasi aplikasi.

| No. | Diagram | Objek utama |
| --- | --- | --- |
| 1 | [Registrasi Alumni](./sequence/01-registrasi-alumni.puml) | Register, AlumniProfile, User, Auth, Database |
| 2 | [Login Pengguna](./sequence/02-login.puml) | Login, AlumniProfile, Auth, Database |
| 3 | [Direktori dan Detail Alumni](./sequence/03-direktori-dan-detail-alumni.puml) | Alumni Index, AlumniProfile, Database |
| 4 | [Tracer Study](./sequence/04-tracer-study.puml) | TracerStudy Index, Auth, AlumniProfile, TracerStudyResponse |
| 5 | [Pembaruan Profil](./sequence/05-pembaruan-profil.puml) | UpdateProfile, Auth, AlumniProfile, Storage |
| 6 | [Pengajuan dan Verifikasi Lowongan](./sequence/06-pengajuan-dan-verifikasi-lowongan.puml) | SubmitJob, JobApproval, CareerOpportunity |
| 7 | [Forum Alumni](./sequence/07-forum-alumni.puml) | ForumChat, ChatMessage, Database |
| 8 | [Pengelolaan Data Alumni](./sequence/08-pengelolaan-data-alumni.puml) | AlumniManager, AlumniProfile, ExportController, XLSXWriter |
| 9 | [Pengelolaan Konten](./sequence/09-pengelolaan-konten.puml) | Komponen admin, model konten/SiteSetting, halaman publik |
| 10 | [Pengelolaan Galeri](./sequence/10-pengelolaan-galeri.puml) | MediaManager, Storage, GalleryItem, Gallery Index |

## Pola Arsitektur pada Sequence Diagram

- `boundary` merupakan halaman Blade/Livewire yang berinteraksi dengan aktor.
- `control` merupakan komponen Livewire, controller, atau layanan yang mengatur proses.
- `entity` merupakan model Eloquent yang merepresentasikan data aplikasi.
- `database` merupakan penyimpanan relasional MySQL pada lingkungan aplikasi.
- `collections` digunakan untuk storage berkas publik.

Diagram forum mengikuti implementasi `wire:poll.2s`. Walaupun proyek memiliki fondasi broadcasting, pengiriman pesan forum saat ini belum melakukan dispatch event WebSocket pada alur `send()`.
