# Panduan Penggunaan Aplikasi: NewsHub Semantic Portal

Dokumen ini menjelaskan alur operasional sistem NewsHub berbasis Web Semantik, baik dari sisi **Administrator** maupun **Pengguna Publik**.

---

## 1. Alur Administrator (Pengelola Pengetahuan)

Tujuan utama Admin adalah mengelola data berita dan memastikan data tersebut terkonversi menjadi format semantik (RDF) yang valid.

### A. Akses Dashboard
1. Buka halaman utama aplikasi.
2. Klik tombol **"Admin Login"** di pojok kanan atas.
3. Masukkan kredensial admin (Email & Password).
4. Setelah berhasil, Anda akan diarahkan ke **Dashboard** yang menampilkan statistik jumlah berita dan total triple semantik yang tersimpan.

### B. Pengelolaan Konsep (Kelola Ontologi)
1. Pilih menu **"Categories"** di sidebar.
2. Tambahkan kategori baru (misal: *Artificial Intelligence*).
3. Kategori ini bertindak sebagai **Konsep Semantik** yang akan digunakan untuk mengklasifikasikan berita berdasarkan ontologi `schema:articleSection`.

### C. Manajemen Berita & Sinkronisasi Semantik
1. Pilih menu **"Articles"**.
2. Klik **"+ New Article"** untuk menambah berita baru.
3. Masukkan data lengkap (Judul, Konten, Tanggal, Kategori, Sumber, dan Gambar).
4. Klik **"Save Article"**.
5. **Proses Dibalik Layar**: Sistem akan menyimpan data ke MySQL dan secara otomatis mengonversinya menjadi **RDF Triples** menggunakan standar *Schema.org*, lalu menyimpannya ke **ARC2 Triplestore**.
6. Status **"Semantic Indexed"** (ikon biru) pada daftar berita menandakan berita tersebut sudah tersinkronisasi ke mesin semantik.

### D. Validasi & Eksplorasi Graf (SPARQL)
1. Pilih menu **"Semantic Graph"**.
2. Di sini Admin bisa melakukan pengujian sistem:
   * **Table View**: Melihat data mentah Triple (Subject, Predicate, Object).
   * **Visual Graph**: Melihat visualisasi jaringan hubungan antar berita secara interaktif.
   * **SPARQL Editor**: Menjalankan query manual (misal: mencari semua berita di kategori tertentu menggunakan bahasa SPARQL).

---

## 2. Alur Pengguna Publik (Konsumsi Data Semantik)

Tujuan utama pengguna adalah mencari informasi dan mengonsumsi metadata semantik.

### A. Pencarian Berbasis Konsep
1. Di halaman **Home**, pengguna dapat mencari berita menggunakan kolom pencarian.
2. Pengguna dapat menggunakan **Semantic Filters** (tombol kategori) untuk menyaring berita berdasarkan konsep ontologi yang tersedia.

### B. Inspeksi Metadata Berita
1. Klik salah satu berita untuk masuk ke halaman **Detail Berita**.
2. Di sebelah kanan berita, terdapat fitur **"Triple Inspector"**.
3. Fitur ini menampilkan data asli yang diambil langsung dari Triplestore menggunakan query SPARQL secara real-time. Ini membuktikan bahwa berita tersebut memiliki identitas semantik yang unik.

### C. Interoperabilitas (Ekspor RDF)
1. Pada halaman detail berita, pengguna dapat mengklik tombol **"Download RDF (.TTL)"**.
2. File yang diunduh adalah format Turtle standar yang bisa dibaca oleh sistem Web Semantik lain (seperti Protégé atau GraphDB).

### D. Edukasi Web Semantik
1. Menu **"Ontology"**: Menampilkan dokumentasi pemetaan data ke standar *Schema.org*.
2. Menu **"Semantic Index"**: Menampilkan statistik global tentang kesehatan dan ukuran Knowledge Graph yang dimiliki aplikasi.

---

## 3. Rencana Pengembangan Masa Depan (Future Work)

Berikut adalah fitur yang direncanakan untuk pengembangan tahap selanjutnya:
1. **Advanced Author Relations**: Menghubungkan berita ke entitas Penulis yang memiliki profil lengkap (bukan sekadar teks).
2. **Semantic Related Content**: Menampilkan rekomendasi berita terkait secara otomatis menggunakan algoritma kemiripan hubungan pada graf semantik.
3. **Reasoning Engine**: Menambahkan kemampuan sistem untuk menarik kesimpulan baru (inference) dari data yang ada.

---

## 4. Penjelasan Teknis: Database & Triplestore (Untuk Sidang Skripsi)

Sistem ini menggunakan arsitektur **Hybrid Data Storage**, yang menggabungkan database relasional tradisional dan penyimpanan graf semantik.

### A. Database Relasional (MySQL)
Digunakan untuk manajemen data operasional aplikasi. Tabel utama meliputi:
*   **`news`**: Menyimpan data mentah berita (judul, konten, path gambar).
*   **`categories`**: Menyimpan master data kategori/taksonomi.
*   **`users`**: Menyimpan kredensial login Admin.

### B. ARC2 Triplestore (Engine Semantik)
ARC2 adalah *library* PHP yang bertindak sebagai mesin utama Web Semantik di aplikasi ini. ARC2 membuat tabel-tabel khusus di MySQL (berawalan `arc_`) untuk menyimpan data dalam format **RDF**.

Tabel paling penting adalah **`arc_triple`**:
*   **Subject**: URI unik berita (contoh: `hub:news/1`).
*   **Predicate**: Properti dari ontologi Schema.org (contoh: `schema:headline`).
*   **Object**: Nilai dari properti tersebut (contoh: "Banjir Jakarta").

### C. Kenapa Menggunakan Arsitektur Ini?
1.  **Interoperabilitas**: Data berita tidak hanya tersimpan sebagai teks, tapi sebagai **Knowledge Graph** yang bisa dipahami oleh mesin atau aplikasi lain di seluruh dunia.
2.  **SPARQL Query**: Memungkinkan pencarian data yang sangat kompleks yang tidak bisa dilakukan oleh SQL biasa (misal: mencari hubungan antar entitas secara rekursif).
3.  **Standardisasi**: Mengikuti standar W3C untuk Web Semantik, sehingga data berita kamu siap untuk masa depan *Linked Open Data (LOD)*.

---
*Dokumen ini diperbarui secara berkala untuk mendukung dokumentasi teknis proyek skripsi.*
