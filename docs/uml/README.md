# Dokumentasi UML Portal Alumni FTI

Dokumentasi ini disusun berdasarkan route, middleware, komponen Livewire, controller, model Eloquent, dan migration yang terdapat pada implementasi Portal Alumni FTI.

## Daftar Diagram

| No. | Jenis | Sumber PlantUML | Narasi |
| --- | --- | --- | --- |
| 1 | Use Case Diagram | [Overview](./01-use-case-diagram.puml) dan [diagram detail](./01-use-case-detail.md) | [Narasi overview](./01-use-case-diagram.md) |
| 2 | Activity Diagram | [Folder activity](./activity/) | [02-activity-diagram.md](./02-activity-diagram.md) |
| 3 | Sequence Diagram | [Folder sequence](./sequence/) | [03-sequence-diagram.md](./03-sequence-diagram.md) |
| 4 | Class Diagram | [Overview](./04-class-diagram.puml) dan [diagram detail](./04-class-detail.md) | [Narasi overview](./04-class-diagram.md) |
| 5 | Entity Relationship Diagram | [Overview](./05-entity-relationship-diagram.puml) dan [diagram detail](./05-erd-detail.md) | [Narasi overview](./05-entity-relationship-diagram.md) |

## Jumlah Diagram

- 1 Use Case Diagram overview + 5 diagram Use Case detail
- 10 Activity Diagram
- 10 Sequence Diagram
- 1 Class Diagram overview + 5 diagram Class detail
- 1 Entity Relationship Diagram overview + 5 diagram ERD detail
- Total: 38 diagram

## Cara Menghasilkan Gambar

File `.puml` dapat dibuka menggunakan PlantUML, ekstensi PlantUML pada Visual Studio Code, IntelliJ IDEA, atau layanan PlantUML Server. Format SVG disarankan untuk dokumen skripsi karena tetap tajam ketika diperbesar.

Contoh perintah jika PlantUML sudah terpasang:

```bash
plantuml -tsvg docs/uml/**/*.puml
```

## Konsistensi Istilah

- Aktor sistem: Pengunjung, Alumni, dan Admin.
- “Alumni Unggulan” tidak digunakan; sistem menggunakan kategori objektif “Alumni Sudah Bekerja”.
- Lowongan memiliki status `pending`, `approved`, dan `rejected`.
- Konten Galeri hanya tampil jika `published_at` terisi.
- Forum saat ini diperbarui melalui polling Livewire dua detik.
- Model Agenda tersedia, tetapi CRUD Agenda pada panel admin belum tersedia.
