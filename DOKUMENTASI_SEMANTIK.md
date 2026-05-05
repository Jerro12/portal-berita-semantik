# Panduan Komprehensif: Arsitektur Semantik & Cara Menjelaskan Aplikasi

Dokumen ini disusun khusus untuk membantu pengembang/pemilik aplikasi dalam menjelaskan aspek **Web Semantik** pada proyek ini saat bimbingan atau sidang.

---

## 1. Lokasi "Semantik" dalam Kode (Di mana letaknya?)

Jika ditanya: *"Di mana kode semantiknya?"*, Anda bisa menunjukkan lokasi-lokasi berikut:

### A. Jantung Semantik (Semantic Engine)
- **File**: `app/Services/SemanticService.php`
- **Penjelasan**: Inilah "otak" aplikasi. Di sini terjadi proses **Ekstraksi & Mapping**. 
  - Lihat fungsi `indexNews()`: Di sana teks berita dari MySQL diambil, lalu dipasangkan dengan label internasional dari Schema.org.
  - Cari baris `$resource->add('schema:headline', $news->title)`: Ini adalah bukti Anda menghubungkan data lokal ke ontologi global.

### B. Bahasa Query Khusus (SPARQL)
- **File**: `app/Http/Controllers/SearchController.php`
- **Penjelasan**: Aplikasi ini **tidak** menggunakan pencarian SQL biasa (`SELECT * FROM...`) untuk mencari berita, melainkan menggunakan **SPARQL**.
  - Lihat fungsi `index()`: Di sana ada variabel `$sparql`. Tunjukkan bahwa pencarian dilakukan berdasarkan hubungan subjek-predikat-objek.

### C. Output Data untuk Mesin (JSON-LD)
- **File**: `resources/views/public/show.blade.php`
- **Penjelasan**: Di bagian atas file (di dalam tag `<head>`), terdapat kode `<script type="application/ld+json">`.
  - Ini adalah format semantik yang paling populer saat ini. Google menggunakan data ini untuk menampilkan *Rich Snippets*.

---

## 2. Mengenal Komponen Utama (Istilah Penting)

### Apa itu ARC2?
ARC2 adalah library PHP yang berfungsi sebagai **Triplestore** (Database Semantik).
- **Fungsi**: Jika database biasa menyimpan data dalam tabel, ARC2 menyimpan data dalam bentuk **Graf (Jaringan)**. Ia yang mengelola query SPARQL di aplikasi ini.

### Apa itu Ontologi Schema.org?
Ontologi adalah "Kamus" atau "Kesepakatan" tentang nama-nama properti. 
- Kita sepakat menggunakan `schema:headline` daripada sekadar `judul_berita`, agar mesin di seluruh dunia (Google, Bing, dll) tahu bahwa itu adalah judul berita.

### Apa itu Triple?
Triple adalah cara aplikasi menyimpan rahasia hubungan data.
- **Subject**: URI berita (Alamat unik).
- **Predicate**: Jenis hubungan (Contoh: `isAuthorOf`).
- **Object**: Nilai data (Contoh: "Budi").
*Ingat: Subjek - Predikat - Objek.*

---

## 3. Fungsi Tombol Khusus di Admin (Wajib Tahu!)

### A. Reset Triplestore (Tombol Merah)
- **Fungsi**: Menghapus seluruh memori graf di mesin ARC2.
- **Mengapa Ada?**: Kadang data di MySQL diubah secara manual, sehingga data di mesin semantik jadi tidak cocok. Reset digunakan untuk membersihkan mesin sebelum diisi ulang.

### B. Sinkron Ulang Semantik (Tombol Biru)
- **Fungsi**: Mengonversi ulang seluruh berita di MySQL menjadi Triple RDF.
- **Mengapa Ada?**: Agar data semantik yang baru saja di-reset atau yang belum terdaftar bisa muncul kembali di pencarian dan inspektur triple.

---

## 4. Alur Menjelaskan (Storytelling untuk Bimbingan)

Gunakan alur ini saat menjelaskan kepada dosen:

1.  **Input**: "Saat admin menginput berita, data disimpan dulu ke database MySQL biasa."
2.  **Konversi**: "Secara otomatis, sistem memanggil `SemanticService` untuk mengubah data tersebut menjadi format **RDF** menggunakan ontologi **Schema.org**."
3.  **Penyimpanan**: "Data RDF tersebut kemudian disimpan ke dalam **Triplestore ARC2**."
4.  **Akses**: "Saat pengunjung mencari berita, sistem menjalankan query **SPARQL**. Sistem tidak mencari kata per kata, tapi mencari berdasarkan relasi data di Triplestore."
5.  **Output**: "Hasilnya bisa dilihat di **Inspektur Triple** (halaman detail) atau divisualisasikan dalam bentuk **Graf** (halaman admin)."

---

## 5. Mengapa Aplikasi ini "Hebat"? (Value Proposition)

1.  **Interoperabilitas**: Data berita kita bisa dibaca oleh aplikasi semantik lain di seluruh dunia karena formatnya standar (RDF).
2.  **Pencarian Berbasis Makna**: Kita bisa mencari berita berdasarkan entitas atau kategori ontologi, bukan cuma sekadar teks.
3.  **SEO Teroptimasi**: Karena menggunakan JSON-LD, berita ini lebih mudah diindeks secara cerdas oleh Google.

---

