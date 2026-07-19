# Use Case Diagram Detail

Use Case Diagram overview tetap tersedia pada [01-use-case-diagram.puml](../01-use-case-diagram.puml). Untuk kebutuhan pembahasan skripsi, diagram tersebut dipecah menjadi lima diagram detail:

| No. | Diagram | Fokus |
| --- | --- | --- |
| 1 | [Pengunjung](./usecase/01-pengunjung.puml) | Seluruh layanan yang dapat diakses tanpa login |
| 2 | [Alumni](./usecase/02-alumni.puml) | Dashboard, profil, lowongan, forum, notifikasi, dan tracer study |
| 3 | [Admin](./usecase/03-admin.puml) | Dashboard, CRUD konten, pengelolaan alumni, approval, ekspor, dan moderasi |
| 4 | [Autentikasi dan Tracer Study](./usecase/04-autentikasi-dan-tracer.puml) | Registrasi NIM, login berdasarkan role, logout, dan pencegahan duplikasi tracer |
| 5 | [Sinkronisasi Admin–Pengguna](./usecase/05-sinkronisasi-admin-pengguna.puml) | Pemetaan menu admin terhadap tampilan pengguna sesuai revisi dosen |

Diagram detail ini merupakan turunan dari route dan komponen Livewire aktual. Use case yang belum didukung kode tidak ditambahkan, khususnya CRUD Agenda pada panel admin.
