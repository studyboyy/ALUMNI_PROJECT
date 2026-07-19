# Activity Diagram Portal Alumni FTI

Activity Diagram menjelaskan urutan aktivitas, keputusan, dan perpindahan tanggung jawab antara pengguna dengan sistem. Diagram dipisahkan berdasarkan proses agar tetap terbaca ketika dimasukkan ke dokumen skripsi.

| No. | Diagram | Cakupan |
| --- | --- | --- |
| 1 | [Registrasi Alumni](./activity/01-registrasi-alumni.puml) | Pencarian NIM, pemeriksaan akun, transaksi pembuatan akun, dan login otomatis |
| 2 | [Login](./activity/02-login.puml) | Resolusi email/NIM, autentikasi, pemeriksaan role, dan pengalihan dashboard |
| 3 | [Layanan Publik](./activity/03-layanan-publik.puml) | Beranda, Profil, Data Alumni, Berita & Agenda, Karier, Galeri, dan Kontak |
| 4 | [Tracer Study](./activity/04-tracer-study.puml) | Prefill profil, validasi, pemeriksaan duplikasi, dan penyimpanan respons |
| 5 | [Pembaruan Profil](./activity/05-pembaruan-profil.puml) | Pengubahan profil, foto, pekerjaan, dan daftar prestasi |
| 6 | [Pengajuan dan Verifikasi Lowongan](./activity/06-pengajuan-dan-verifikasi-lowongan.puml) | Pengajuan alumni, status pending, keputusan admin, dan publikasi |
| 7 | [Forum Alumni](./activity/07-forum-alumni.puml) | Membaca, mengirim, membalas, polling pesan, dan moderasi admin |
| 8 | [Pengelolaan Data Alumni](./activity/08-pengelolaan-data-alumni.puml) | Tambah, ubah, hapus, cari, dan ekspor data alumni |
| 9 | [Pengelolaan Konten](./activity/09-pengelolaan-konten.puml) | Sinkronisasi Beranda, Profil, Kontak, Berita, Organisasi, Program, Testimoni, FAQ, dan Tema |
| 10 | [Pengelolaan Galeri](./activity/10-pengelolaan-galeri.puml) | Upload, publikasi, penghapusan, dan tampilan Galeri publik |

## Catatan Pemodelan

- Swimlane menunjukkan pihak yang bertanggung jawab terhadap aktivitas.
- Percabangan menggambarkan validasi, status data, dan pilihan tindakan pengguna.
- Activity Diagram mengikuti perilaku aktual komponen Livewire dan controller.
- Forum dimodelkan menggunakan polling dua detik sesuai view saat ini, bukan sebagai WebSocket real-time penuh.
- Pengelolaan Agenda tidak digambarkan sebagai aktivitas admin karena CRUD `EventAgenda` belum tersedia pada implementasi.
