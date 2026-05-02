# 📰 Portal Berita Semantik (Semantic News Portal)

[![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com)
[![Semantic Web](https://img.shields.io/badge/Semantic-Web-blue.svg)](https://w3.org/standards/semanticweb/)
[![RDF](https://img.shields.io/badge/RDF-Data-green.svg)](https://www.w3.org/RDF/)

**Portal Berita Semantik** adalah platform manajemen berita modern yang mengintegrasikan teknologi Web Semantik. Setiap berita yang dipublikasikan tidak hanya disimpan ke dalam database relasional (MySQL), tetapi juga diindeks secara otomatis ke dalam **Triplestore** menggunakan ontologi standard **Schema.org**.

## 🚀 Fitur Utama

-   **Manajemen Berita (CRUD)**: Kelola berita dengan dukungan unggah poster dari lokal atau menggunakan link eksternal.
-   **Injeksi Semantik Otomatis**: Konversi data berita (Judul, Konten, Penulis, Tanggal, Gambar) menjadi format RDF secara *real-time*.
-   **Integrasi ARC2 Triplestore**: Penyimpanan data semantik yang persisten di dalam MySQL menggunakan library ARC2.
-   **Ontologi Schema.org**: Menggunakan namespace standard `https://schema.org/NewsArticle` untuk interoperabilitas data yang lebih baik.
-   **SPARQL Query Interface**: Dashboard khusus untuk menjalankan query SPARQL langsung terhadap data berita yang tersimpan.
-   **Public News Portal**: Tampilan publik yang bersih dengan optimasi SEO dan metadata semantik.

## 🛠️ Tech Stack Requirement

Untuk menjalankan proyek ini, pastikan lingkungan pengembangan Anda memenuhi kriteria berikut:

-   **PHP**: `^8.2` (Wajib, Laravel 12 tidak mendukung PHP 8.1 ke bawah)
-   **Framework**: [Laravel 12.x](https://laravel.com)
-   **Database**: MySQL 8.0+ / MariaDB 10.4+
-   **Semantic Libraries**: 
    -   [EasyRdf](https://www.easyrdf.org/) `^1.1` (RDF Processing)
    -   [ARC2](https://github.com/semsol/arc2) `^3.1` (Triplestore & SPARQL Engine)
-   **Package Manager**: Composer `^2.x` & Node.js `^18.x` (NPM)
-   **Frontend**: Tailwind CSS & Blade Templating (Laravel Breeze)

## 📥 Instalasi

1. **Clone repositori**
   ```bash
   git clone https://github.com/username/portal-berita-semantik.git
   cd portal-berita-semantik
   ```

2. **Instal dependensi**
   ```bash
   composer install
   npm install && npm run build
   ```

3. **Konfigurasi Environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Sesuaikan `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` di file `.env`.

4. **Migrasi & Seed Data**
   ```bash
   php artisan migrate --seed
   ```

5. **Symlink Storage**
   ```bash
   php artisan storage:link
   ```

6. **Jalankan Server**
   ```bash
   php artisan serve
   ```

## 🔍 Penggunaan Semantik

Setelah menambahkan berita, Anda dapat mengakses menu **Semantic Graph** di dashboard admin untuk menjalankan query SPARQL. 

Contoh query untuk mengambil semua judul berita:
```sparql
PREFIX schema: <https://schema.org/>
SELECT ?title 
WHERE {
  ?s rdf:type schema:NewsArticle ;
     schema:headline ?title .
}
```

## 📄 Lisensi

Proyek ini bersifat open-source di bawah lisensi [MIT](LICENSE).
