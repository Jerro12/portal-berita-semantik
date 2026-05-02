<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\Category;
use App\Services\SemanticService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    public function run(SemanticService $semanticService): void
    {
        // 1. Buat Kategori
        $categories = [
            ['name' => 'Teknologi', 'description' => 'Berita seputar perkembangan tech, gadget, dan AI.'],
            ['name' => 'Ekonomi', 'description' => 'Berita pasar modal, bisnis, dan makro ekonomi.'],
            ['name' => 'Kesehatan', 'description' => 'Tips kesehatan dan berita medis terbaru.'],
            ['name' => 'Politik', 'description' => 'Dinamika politik nasional dan internasional.'],
            ['name' => 'Olahraga', 'description' => 'Hasil pertandingan dan info atlet.'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => Str::slug($cat['name'])], $cat);
        }

        // 2. Data Berita Dummy
        $newsData = [
            [
                'title' => 'Revolusi AI: Bagaimana Web Semantik Mengubah Cara Kita Mencari Informasi',
                'content' => 'Web Semantik atau Web 3.0 memungkinkan mesin memahami data seperti manusia. Dengan menggunakan format RDF dan SPARQL, informasi tidak lagi sekadar teks, melainkan entitas yang saling terhubung...',
                'category' => 'Teknologi',
                'source' => 'TechDaily',
                'image' => 'https://images.unsplash.com/photo-1677442136019-21780ecad995?auto=format&fit=crop&q=80&w=800',
                'published_at' => now()->subDays(1),
            ],
            [
                'title' => 'Pertumbuhan Ekonomi Digital Indonesia Diprediksi Meningkat 20% di 2026',
                'content' => 'Laporan terbaru menunjukkan bahwa sektor e-commerce dan fintech masih menjadi motor utama penggerak ekonomi digital di Asia Tenggara, khususnya Indonesia yang memiliki basis pengguna besar...',
                'category' => 'Ekonomi',
                'source' => 'BisnisNews',
                'image' => 'https://images.unsplash.com/photo-1526304640581-d334cdbbf45e?auto=format&fit=crop&q=80&w=800',
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'Gaya Hidup Sehat: Pentingnya Nutrisi Seimbang di Era Serba Cepat',
                'content' => 'Kesadaran masyarakat akan kesehatan meningkat pesat. Mengonsumsi makanan bergizi dan rutin berolahraga menjadi kunci utama dalam menjaga imunitas tubuh di tengah aktivitas padat...',
                'category' => 'Kesehatan',
                'source' => 'HealthWay',
                'image' => 'https://images.unsplash.com/photo-1490818387583-1baba5e638af?auto=format&fit=crop&q=80&w=800',
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => 'Analisis Politik: Tantangan Diplomasi Global di Tahun 2026',
                'content' => 'Hubungan antar negara besar mengalami dinamika baru. Isu lingkungan dan perdagangan menjadi agenda utama dalam pertemuan puncak internasional yang akan datang...',
                'category' => 'Politik',
                'source' => 'GlobalInsight',
                'image' => 'https://images.unsplash.com/photo-1529107386315-e1a2ed48a620?auto=format&fit=crop&q=80&w=800',
                'published_at' => now()->subDays(4),
            ],
            [
                'title' => 'Tim Nasional Siap Hadapi Kualifikasi Dunia Pekan Depan',
                'content' => 'Persiapan intensif dilakukan oleh skuad garuda. Pelatih optimis anak asuhnya bisa memberikan performa maksimal untuk mengamankan tiket ke babak selanjutnya...',
                'category' => 'Olahraga',
                'source' => 'SportCenter',
                'image' => 'https://images.unsplash.com/photo-1508098682722-e99c43a406b2?auto=format&fit=crop&q=80&w=800',
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Inovasi Blockchain di Sektor Logistik Nasional',
                'content' => 'Blockchain bukan hanya soal kripto. Di sektor logistik, teknologi ini membantu transparansi pengiriman dan efisiensi biaya operasional yang selama ini menjadi kendala...',
                'category' => 'Teknologi',
                'source' => 'TechDaily',
                'image' => 'https://images.unsplash.com/photo-1639762681485-074b7f938ba0?auto=format&fit=crop&q=80&w=800',
                'published_at' => now()->subDays(6),
            ],
            [
                'title' => 'Pasar Saham Hijau: Investasi Berkelanjutan Semakin Diminati',
                'content' => 'Investor kini lebih memilih perusahaan yang memiliki skor ESG (Environmental, Social, and Governance) tinggi. Tren ini diprediksi akan terus tumbuh hingga akhir dekade...',
                'category' => 'Ekonomi',
                'source' => 'FinanceHub',
                'image' => 'https://images.unsplash.com/photo-1590283603385-17ffb3a7f29f?auto=format&fit=crop&q=80&w=800',
                'published_at' => now()->subDays(7),
            ],
            [
                'title' => 'Vaksin Generasi Baru Mulai Diuji Coba Massal',
                'content' => 'Ilmuwan berhasil mengembangkan varian vaksin yang lebih efektif melawan mutasi virus terbaru. Tahap uji coba klinis menunjukkan hasil yang sangat menjanjikan bagi kesehatan publik...',
                'category' => 'Kesehatan',
                'source' => 'ScienceDaily',
                'image' => 'https://images.unsplash.com/photo-1584036561566-baf8f5f1b144?auto=format&fit=crop&q=80&w=800',
                'published_at' => now()->subDays(8),
            ],
            [
                'title' => 'Eksplorasi Ruang Angkasa: Misi Ke Mars Kembali Diluncurkan',
                'content' => 'Badan antariksa dunia mengumumkan peluncuran roket terbaru yang akan membawa peralatan penelitian ke planet merah. Misi ini bertujuan mencari tanda-tanda kehidupan masa lalu...',
                'category' => 'Teknologi',
                'source' => 'CosmosNews',
                'image' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&q=80&w=800',
                'published_at' => now()->subDays(9),
            ],
            [
                'title' => 'Piala Dunia Atletik: Rekor Baru Terpecahkan di Nomor Lari 100m',
                'content' => 'Dunia terpukau dengan kecepatan pelari muda asal jamaika yang berhasil memecahkan rekor dunia yang telah bertahan selama satu dekade terakhir di stadion nasional...',
                'category' => 'Olahraga',
                'source' => 'SportCenter',
                'image' => 'https://images.unsplash.com/photo-1461896756985-2256b6f63f33?auto=format&fit=crop&q=80&w=800',
                'published_at' => now()->subDays(10),
            ],
        ];

        foreach ($newsData as $data) {
            $news = News::create($data);
            
            // INDEKS SEMANTIK secara otomatis saat seeding
            $semanticService->indexNews($news);
        }
    }
}
