# Entity Relationship Diagram Detail

ERD lengkap tetap tersedia pada [05-entity-relationship-diagram.puml](../05-entity-relationship-diagram.puml). Untuk pembahasan skripsi per modul, ERD dipecah menjadi:

| No. | Diagram | Fokus |
| --- | --- | --- |
| 1 | [Pengguna dan Alumni](./erd/01-pengguna-alumni.puml) | Akun, role, NIM, dan profil alumni |
| 2 | [Karier dan Tracer Study](./erd/02-karier-tracer.puml) | Pengajuan/approval lowongan dan respons tracer |
| 3 | [Forum](./erd/03-forum.puml) | Pesan, pengirim, dan relasi balasan |
| 4 | [Konten Situs](./erd/04-konten-situs.puml) | Berita, agenda, Galeri, organisasi, program, testimoni, FAQ, kontak, dan setting |
| 5 | [Bisnis Lengkap](./erd/05-bisnis-lengkap.puml) | Ringkasan seluruh entitas bisnis dan foreign key |

ERD detail mempertahankan aturan database aktual: kolom nullable, unique key, foreign key, dan aturan penghapusan relasi.
