# Rencana Implementasi: Mesin Pencari Berita Berbasis Web Semantik

Dokumen ini merangkum konsep dan alur pengembangan untuk proyek skripsi: **"Pengembangan Mesin Pencari Berbasis Web Semantik untuk Website Portal Berita"**.

## 1. Perancangan Representasi Data (Ontologi)

Untuk menjawab rumusan masalah pertama, kita perlu mendefinisikan skema data (Ontologi) menggunakan vocabularies standar seperti **Schema.org**, **Dublin Core (dc)**, dan **FOAF**.

### Struktur Kelas & Properti (Predikat)

| Entitas | Properti (Ontologi) | Deskripsi |
| :--- | :--- | :--- |
| **NewsArticle** | `schema:headline` | Judul Berita |
| | `schema:articleBody` | Isi/Konten Berita |
| | `schema:datePublished` | Tanggal Publikasi |
| | `schema:author` | Penulis/Sumber |
| | `schema:articleSection` | Kategori (Politik, Ekonomi, dll) |
| | `schema:url` | Link Sumber |
| **Category** | `rdfs:label` | Nama Kategori |
| **Source** | `schema:name` | Nama Media Sumber |

---

## 2. Arsitektur Sistem

Sistem akan dibangun menggunakan framework **Laravel** dengan integrasi library semantik.

### Komponen Utama:
1. **Laravel (Backend/Frontend)**: Manajemen data berita dan UI.
2. **EasyRDF (PHP Library)**: Untuk konversi data MySQL ke format RDF (Turtle/JSON-LD).
3. **ARC2 / Fuseki / GraphDB**: Sebagai Triplestore untuk menyimpan RDF dan melayani query SPARQL.
4. **SPARQL Endpoint**: Antarmuka untuk melakukan pencarian semantik.

---

## 3. Alur Kerja (Workflows)

### Alur Admin (Input & Indeks)
1. **Input**: Admin mengisi form berita di Dashboard Laravel.
2. **Konversi**: Laravel menggunakan library Semantik untuk memetakan input ke Triple (S-P-O).
   - *Subject*: `http://portal-berita.com/news/{id}`
   - *Predicate*: `schema:headline`
   - *Object*: "Judul Berita"
3. **Storage**: Data disimpan di DB Relasional (untuk manajemen) dan dikirim ke Triplestore (untuk pencarian).
4. **Indexing**: Sistem melakukan indexing agar data bisa di-query via SPARQL.

### Alur User (Search Semantik)
1. **Query**: User memasukkan kata kunci.
2. **Translation**: Sistem menerjemahkan input user menjadi query SPARQL.
3. **Retrieval**: SPARQL mencari relasi antar data (misal: mencari berita berdasarkan kategori semantik).
4. **Result**: Menampilkan hasil dengan metadata yang kaya.

---

## 4. Rencana Desain UI/UX (Aesthetics)

Aplikasi akan menggunakan desain **Premium & Modern**:
- **Dark Mode / Glassmorphism**: Untuk tampilan dashboard admin yang futuristik.
- **Dynamic Search Results**: Hasil pencarian yang tidak hanya teks, tapi menunjukkan relasi semantik.
- **Micro-animations**: Transisi halus saat konversi RDF berhasil.

---

## 5. Langkah Selanjutnya (Action Plan)

1. [ ] **Setup Ontologi**: Menentukan namespace (prefix) yang akan digunakan.
2. [ ] **Integrasi Library**: Instalasi `easyrdf/easyrdf` via Composer.
3. [ ] **Database Schema**: Menyesuaikan tabel `posts` atau `news` untuk mendukung metadata semantik.
4. [ ] **Admin UI**: Membuat form input berita yang lengkap sesuai flowchart.
5. [ ] **RDF Generator**: Implementasi logic konversi ke RDF.

> [!IMPORTANT]
> Fokus utama kita adalah pada **keakuratan Triple** yang dihasilkan agar mesin pencari benar-benar "pintar" dalam memahami konteks berita.
