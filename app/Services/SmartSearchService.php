<?php

namespace App\Services;

use App\Models\Category;
use App\Models\News;

class SmartSearchService
{
    /**
     * ============================================================
     * NewsSearch — Smart Search Engine untuk Portal Berita Semantik
     * ============================================================
     *
     * Alur Kerja (Pipeline):
     * 1. PRE-PROCESSING    : Bersihkan tanda baca & frasa perintah
     * 2. INTENT DETECTION  : Deteksi sorting (terbaru, terlama)
     * 3. ENTITY EXTRACTION : Deteksi Kategori (+ fuzzy typo), Tahun, Sumber
     * 4. STOP WORD REMOVAL : Hapus kata tidak bermakna
     * 5. SPARQL BUILD      : Bangun query SPARQL multi-token
     * 6. MYSQL FALLBACK    : Jika SPARQL kosong, fallback ke MySQL LIKE
     * 7. RESPONSE ASSEMBLY : Kembalikan hasil + SPO Triplets + metadata
     */

    protected SemanticService $semantic;

    // Daftar stop word konteks berita Indonesia
    protected array $stopWords = [
        'berita', 'artikel', 'informasi', 'kabar', 'laporan', 'tulisan', 'tulis', 'ditulis', 'karya', 'karangan', 'ciptaan', 'liputan', 'dibuat', 'buat',
        'baca', 'membaca', 'mencari', 'cari', 'carikan', 'tampilkan', 'lihat',
        'tentang', 'mengenai', 'seputar', 'terkait', 'mengenai', 'perihal',
        'saya', 'kami', 'kita', 'mau', 'ingin', 'minta', 'tolong', 'dong', 'sih',
        'yang', 'pada', 'di', 'dan', 'atau', 'serta', 'ke', 'dari', 'untuk',
        'adalah', 'ini', 'itu', 'ada', 'tidak', 'oleh', 'karena', 'juga',
        'dengan', 'dalam', 'akan', 'sudah', 'telah', 'bisa', 'dapat',
        'hal', 'cara', 'baru', 'lagi', 'pun', 'aja', 'deh', 'ya', 'nih',
        'min', 'kak', 'bang', 'pak', 'bu', 'halo', 'hai',
    ];

    public function __construct(SemanticService $semantic)
    {
        $this->semantic = $semantic;
    }

    /**
     * Entry point utama — jalankan full pipeline pencarian.
     *
     * @param string $rawQuery   Query mentah dari user
     * @param array  $filters    Filter manual: ['category' => 'Politik']
     * @return array             Hasil pencarian + metadata
     */
    public function search(string $rawQuery, array $filters = []): array
    {
        $rawQuery   = trim($rawQuery);
        $cleanQ     = $rawQuery;
        $sortOrder  = 'DESC';   // default: terbaru
        $sortLabel  = null;
        $detectedCat    = null;   // nama kategori yang terdeteksi
        $detectedYear   = null;
        $detectedSource = null;
        $highlightQuery = $rawQuery;

        // ====================================================
        // STEP 1: PRE-PROCESSING
        // ====================================================
        // Bersihkan tanda baca (kecuali huruf, angka, spasi, strip)
        $cleanQ = preg_replace('/[^\w\s\-]/u', ' ', $cleanQ);

        // Hapus frasa perintah umum konteks berita (Natural Language Queries)
        $commandPhrases = [
            'carikan berita', 'tampilkan berita', 'cari berita',
            'lihat berita', 'berita apa', 'apa berita', 'tunjukkan berita',
            'kasih lihat', 'tolong carikan', 'ingin tahu',
            'info terbaru seputar', 'info tentang', 'kabar tentang', 'kabar seputar',
            'tolong cari artikel', 'tolong tampilkan', 'berikan berita',
            'artikel mengenai', 'artikel tentang', 'berita seputar',
            'berita terkini seputar', 'artikel terbaru seputar', 'tolong carikan artikel',
            'minta berita', 'tolong carikan berita', 'cari artikel', 'tampilkan artikel',
        ];
        foreach ($commandPhrases as $phrase) {
            $cleanQ = preg_replace('/\b' . preg_quote($phrase, '/') . '\b/i', '', $cleanQ);
        }

        $cleanQ = trim(preg_replace('/\s+/', ' ', $cleanQ));

        // ====================================================
        // STEP 2: INTENT DETECTION (Sorting)
        // ====================================================
        if (preg_match('/\b(terbaru|baru|terkini|mutakhir|anyar|recent|fresh)\b/i', $cleanQ)) {
            $sortOrder = 'DESC';
            $sortLabel = 'Terbaru';
            $cleanQ = preg_replace('/\b(terbaru|baru|terkini|mutakhir|anyar|recent|fresh)\b/i', '', $cleanQ);
        } elseif (preg_match('/\b(terlama|lama|lawas|jadul|klasik|kuno)\b/i', $cleanQ)) {
            $sortOrder = 'ASC';
            $sortLabel = 'Terlama';
            $cleanQ = preg_replace('/\b(terlama|lama|lawas|jadul|klasik|kuno)\b/i', '', $cleanQ);
        }

        $cleanQ = trim(preg_replace('/\s+/', ' ', $cleanQ));

        // ====================================================
        // STEP 3: ENTITY EXTRACTION
        // ====================================================

        // -- 3a. Deteksi Tahun --
        if (preg_match('/\b(19|20)\d{2}\b/', $cleanQ, $yearMatch)) {
            $detectedYear = $yearMatch[0];
            $cleanQ = str_replace($detectedYear, '', $cleanQ);
            $cleanQ = trim(preg_replace('/\s+/', ' ', $cleanQ));
        }

        // -- 3a2. Deteksi Waktu Relatif (Hari ini, Kemarin, Bulan ini, Minggu ini) --
        $detectedPeriod = null;
        $periodLabel = null;
        $periodFilterDate = null;

        if (preg_match('/\b(hari ini|hariini|today)\b/i', $cleanQ)) {
            $detectedPeriod = 'today';
            $periodLabel = 'Hari ini';
            $periodFilterDate = now()->format('Y-m-d');
            $cleanQ = preg_replace('/\b(hari ini|hariini|today)\b/i', '', $cleanQ);
        } elseif (preg_match('/\b(kemarin|yesterday)\b/i', $cleanQ)) {
            $detectedPeriod = 'yesterday';
            $periodLabel = 'Kemarin';
            $periodFilterDate = now()->subDay()->format('Y-m-d');
            $cleanQ = preg_replace('/\b(kemarin|yesterday)\b/i', '', $cleanQ);
        } elseif (preg_match('/\b(bulan ini|this month)\b/i', $cleanQ)) {
            $detectedPeriod = 'month';
            $periodLabel = 'Bulan ini (' . now()->format('F Y') . ')';
            $periodFilterDate = now()->format('Y-m');
            $cleanQ = preg_replace('/\b(bulan ini|this month)\b/i', '', $cleanQ);
        } elseif (preg_match('/\b(minggu ini|this week)\b/i', $cleanQ)) {
            $detectedPeriod = 'week';
            $periodLabel = 'Minggu ini';
            $cleanQ = preg_replace('/\b(minggu ini|this week)\b/i', '', $cleanQ);
        }
        $cleanQ = trim(preg_replace('/\s+/', ' ', $cleanQ));

        // -- 3b. Deteksi Kategori dengan Fuzzy Matching (levenshtein ≤ 2) --
        // Gunakan filter manual jika ada, atau deteksi dari query
        $categoryFilter = $filters['category'] ?? null;

        if (!$categoryFilter) {
            $allCategories = Category::all();
            $lowerQ = strtolower($cleanQ);

            foreach ($allCategories as $cat) {
                $catName = strtolower($cat->name);

                // === EXACT MATCH ===
                if (strpos($lowerQ, $catName) !== false) {
                    $detectedCat = $cat->name;
                    $categoryFilter = $cat->name;
                    $cleanQ = preg_replace('/' . preg_quote($cat->name, '/') . '/i', '', $cleanQ);
                    break;
                }

                // === KEYWORD MATCH — pecah nama kategori jadi kata ===
                $catKeywords = array_filter(
                    explode(' ', str_replace(['&', 'dan', 'atau', '/', '-'], ' ', $catName)),
                    fn($w) => strlen(trim($w)) > 3
                );
                $matched = false;
                foreach ($catKeywords as $kw) {
                    $kw = trim($kw);
                    if (preg_match('/\b' . preg_quote($kw, '/') . '\b/i', $cleanQ)) {
                        $detectedCat = $cat->name;
                        $categoryFilter = $cat->name;
                        $cleanQ = preg_replace('/\b' . preg_quote($kw, '/') . '\b/i', '', $cleanQ);
                        $matched = true;
                        break;
                    }
                }
                if ($matched) break;

                // === FUZZY MATCH — toleransi typo (levenshtein ≤ 2) ===
                $queryWords = array_filter(
                    explode(' ', strtolower($cleanQ)),
                    fn($w) => strlen(trim($w)) > 3
                );
                foreach ($queryWords as $word) {
                    $word = trim($word);
                    if (in_array($word, $this->stopWords)) continue;

                    // Cek terhadap nama kategori penuh
                    if (levenshtein($word, $catName) <= 2 && levenshtein($word, $catName) > 0) {
                        $detectedCat = $cat->name . ' (koreksi dari "' . $word . '")';
                        $categoryFilter = $cat->name;
                        $cleanQ = preg_replace('/\b' . preg_quote($word, '/') . '\b/i', '', $cleanQ);
                        break 2;
                    }

                    // Cek terhadap keyword kategori
                    foreach ($catKeywords as $kw) {
                        $kw = trim($kw);
                        if (strlen($kw) > 4 && levenshtein($word, $kw) <= 2 && levenshtein($word, $kw) > 0) {
                            $detectedCat = $cat->name . ' (koreksi dari "' . $word . '")';
                            $categoryFilter = $cat->name;
                            $cleanQ = preg_replace('/\b' . preg_quote($word, '/') . '\b/i', '', $cleanQ);
                            break 3;
                        }
                    }
                }
            }
        } else {
            // Kategori dari filter manual (klik nav)
            $detectedCat = $categoryFilter;
        }

        $cleanQ = trim(preg_replace('/\s+/', ' ', $cleanQ));

        // -- 3c. Deteksi Sumber / Media --
        if (preg_match('/\b(dari|sumber|media|oleh)\s+([A-Za-z\s]+?)(?:\b(tentang|dan|atau|di|ke|dari)\b|$)/i', $cleanQ, $srcMatch)) {
            $detectedSource = trim($srcMatch[2]);
            if (!empty($detectedSource) && strlen($detectedSource) > 2) {
                $cleanQ = preg_replace('/\b(dari|sumber|media|oleh)\s+' . preg_quote($detectedSource, '/') . '/i', '', $cleanQ);
            }
        }

        $cleanQ = trim(preg_replace('/\s+/', ' ', $cleanQ));

        // -- 3d. Deteksi Penulis dengan Fuzzy Match (Typo Tolerance) --
        $allAuthors = \Illuminate\Support\Facades\Cache::remember('semantic_authors_list', 3600, function () {
            return \App\Models\News::whereNotNull('source')->where('source', '!=', '')->distinct()->pluck('source')->toArray();
        });

        if ($detectedSource) {
            // Jika penulis didapat dari regex (misal "oleh zainal"), lakukan koreksi typo
            $sourceWords = array_filter(explode(' ', strtolower($detectedSource)), fn($w) => strlen(trim($w)) > 3);
            foreach ($sourceWords as $word) {
                foreach ($allAuthors as $author) {
                    $authorWords = explode(' ', strtolower($author));
                    foreach ($authorWords as $aWord) {
                        if (strlen($aWord) > 3 && (levenshtein($word, $aWord) <= 2)) {
                            $detectedSource = $author;
                            break 3;
                        }
                    }
                }
            }
        } else {
            // Jika belum ada penulis yang terdeteksi, cari dari sisa kata di query
            $queryWords = array_filter(
                explode(' ', strtolower($cleanQ)),
                fn($w) => strlen(trim($w)) > 3
            );

            foreach ($queryWords as $word) {
                $word = trim($word);
                if (in_array($word, $this->stopWords)) continue;

                foreach ($allAuthors as $author) {
                    $authorWords = explode(' ', strtolower($author));
                    foreach ($authorWords as $aWord) {
                        if (strlen($aWord) > 3) {
                            // Deteksi kecocokan penuh ATAU typo (levenshtein <= 2)
                            if ($word === $aWord || (levenshtein($word, $aWord) <= 2 && levenshtein($word, $aWord) > 0)) {
                                $detectedSource = $author;
                                $cleanQ = preg_replace('/\b' . preg_quote($word, '/') . '\b/i', '', $cleanQ);
                                break 3;
                            }
                        }
                    }
                }
            }
        }

        $cleanQ = trim(preg_replace('/\s+/', ' ', $cleanQ));

        // ====================================================
        // STEP 4: STOP WORD REMOVAL
        // ====================================================
        foreach ($this->stopWords as $sw) {
            $cleanQ = preg_replace('/\b' . preg_quote($sw, '/') . '\b/i', '', $cleanQ);
        }
        $cleanQ = trim(preg_replace('/\s+/', ' ', $cleanQ));

        // Tokenisasi — hanya ambil kata ≥ 2 karakter
        $tokens = array_filter(
            explode(' ', $cleanQ),
            fn($t) => strlen(trim($t)) >= 2
        );
        $tokens = array_values(array_map('trim', $tokens));

        // ====================================================
        // STEP 5: SPARQL QUERY BUILD
        // ====================================================
        $sparqlQuery = $this->buildSparqlQuery($tokens, $categoryFilter, $detectedSource, $sortOrder);

        $sparqlResults = $this->semantic->query($sparqlQuery);
        $results = $sparqlResults['result']['rows'] ?? [];

        // Post-filter tanggal (tahun & periode) pada hasil SPARQL agar aman dari error binary collation MySQL 8
        if (!empty($results) && ($detectedYear || $periodFilterDate)) {
            $results = array_values(array_filter($results, function ($row) use ($detectedYear, $periodFilterDate) {
                $rowDate = $row['date'] ?? '';
                if ($detectedYear && strpos($rowDate, $detectedYear) === false) {
                    return false;
                }
                if ($periodFilterDate && strpos($rowDate, $periodFilterDate) === false) {
                    return false;
                }
                return true;
            }));
        }

        $dataSource = 'sparql';

        // ====================================================
        // STEP 6: MYSQL FALLBACK
        // ====================================================
        if (empty($results) && (!empty($tokens) || $categoryFilter || $detectedPeriod)) {
            $results       = $this->mysqlFallback($tokens, $categoryFilter, $detectedYear, $detectedPeriod, $detectedSource, $sortOrder);
            $dataSource    = 'mysql';
        }

        // ====================================================
        // STEP 6.5: RELEVANCE RANKING (Perhitungan Bobot Peringkat Relevansi Kata Kunci)
        // ====================================================
        if (!empty($tokens) && !empty($results)) {
            $results = $this->rankByRelevance($results, $tokens);
        }

        // ====================================================
        // STEP 7: RESPONSE ASSEMBLY — SPO Triplets + metadata
        // ====================================================
        $spoTriplets = $this->buildSpoTriplets(
            $tokens, $categoryFilter, $detectedCat,
            $detectedYear, $periodLabel, $detectedSource, $sortLabel
        );

        return [
            'results'        => $results,
            'source'         => $dataSource,        // 'sparql' atau 'mysql'
            'sparql_query'   => $sparqlQuery,        // untuk debug panel
            'spo_triplets'   => $spoTriplets,        // visualisasi semantik
            'clean_query'    => $cleanQ,             // query setelah dibersihkan
            'tokens'         => $tokens,             // token untuk highlight
            'highlight_query'=> $highlightQuery,     // query asli user untuk highlight UI
            'sort_label'     => $sortLabel,          // label sorting terdeteksi
            'detected_cat'   => $detectedCat,        // kategori terdeteksi
            'detected_year'  => $detectedYear,       // tahun terdeteksi
            'detected_period'=> $periodLabel,        // periode waktu terdeteksi (misal: Hari ini, Bulan ini)
            'detected_source'=> $detectedSource,     // sumber terdeteksi
            'total'          => count($results),
        ];
    }

    /**
     * STEP 5: Bangun query SPARQL multi-token.
     */
    protected function buildSparqlQuery(
        array   $tokens,
        ?string $category,
        ?string $source,
        string  $sortOrder
    ): string {
        $filters = [];

        // Filter teks (judul ATAU isi ATAU penulis) untuk setiap token — OR antar token
        if (!empty($tokens)) {
            $regexParts = [];
            foreach ($tokens as $token) {
                $safe = addslashes($token);
                $regexParts[] = "REGEX(?headline, \"$safe\", \"i\")";
                $regexParts[] = "REGEX(?body, \"$safe\", \"i\")";
                $regexParts[] = "REGEX(?source, \"$safe\", \"i\")";
            }
            $filters[] = 'FILTER(' . implode(' || ', $regexParts) . ')';
        }

        // Filter kategori (exact match di triplestore)
        if ($category) {
            $safeCat = addslashes($category);
            $filters[] = "FILTER(REGEX(?category, \"$safeCat\", \"i\"))";
        }

        // Filter sumber
        if ($source) {
            $safeSource = addslashes($source);
            $filters[] = "FILTER(REGEX(?source, \"$safeSource\", \"i\"))";
        }

        $filterStr = implode("\n                ", $filters);

        $sparql = "
            PREFIX schema: <https://schema.org/>
            PREFIX rdf:    <http://www.w3.org/1999/02/22-rdf-syntax-ns#>

            SELECT ?id ?headline ?body ?category ?date ?source ?image WHERE {
                ?id rdf:type schema:NewsArticle ;
                    schema:headline ?headline ;
                    schema:articleBody ?body ;
                    schema:articleSection ?category ;
                    schema:datePublished ?date ;
                    schema:author ?source .
                OPTIONAL { ?id schema:image ?image }
                $filterStr
            }
            ORDER BY {$sortOrder}(?date)
            LIMIT 20
        ";

        return $sparql;
    }

    /**
     * STEP 6: MySQL LIKE fallback jika SPARQL tidak menghasilkan apa-apa.
     * Menghasilkan array berformat sama dengan hasil SPARQL.
     */
    protected function mysqlFallback(
        array   $tokens,
        ?string $category,
        ?string $year,
        ?string $detectedPeriod,
        ?string $source,
        string  $sortOrder
    ): array {
        $query = News::query();

        if (!empty($tokens)) {
            $query->where(function ($q) use ($tokens) {
                foreach ($tokens as $token) {
                    $q->orWhere(function ($inner) use ($token) {
                        $inner->where('title', 'LIKE', "%$token%")
                              ->orWhere('content', 'LIKE', "%$token%")
                              ->orWhere('source', 'LIKE', "%$token%");
                    });
                }
            });
        }

        if ($category) {
            $query->where('category', $category);
        }

        if ($year) {
            $query->whereYear('published_at', $year);
        }

        if ($detectedPeriod === 'today') {
            $query->whereDate('published_at', now()->today());
        } elseif ($detectedPeriod === 'yesterday') {
            $query->whereDate('published_at', now()->yesterday());
        } elseif ($detectedPeriod === 'month') {
            $query->whereYear('published_at', now()->year)->whereMonth('published_at', now()->month);
        } elseif ($detectedPeriod === 'week') {
            $query->whereBetween('published_at', [now()->startOfWeek(), now()->endOfWeek()]);
        }

        if ($source) {
            $query->where('source', 'LIKE', "%$source%");
        }

        $direction = ($sortOrder === 'ASC') ? 'asc' : 'desc';
        $news = $query->orderBy('published_at', $direction)->limit(20)->get();

        // Normalise ke format yang sama dengan row SPARQL
        return $news->map(function (News $n) {
            return [
                'id'       => url('/ns/news/' . $n->id),
                'headline' => $n->title,
                'body'     => $n->content,
                'category' => $n->category,
                'date'     => $n->published_at?->toIso8601String(),
                'source'   => $n->source ?? 'Admin',
                'image'    => $n->image ?? null,
            ];
        })->toArray();
    }

    /**
     * STEP 6.5: Mengurutkan hasil pencarian berdasarkan skor relevansi kata kunci.
     */
    protected function rankByRelevance(array $results, array $tokens): array
    {
        if (empty($tokens) || empty($results)) {
            return $results;
        }

        foreach ($results as &$item) {
            $score = 0;
            $headline = strtolower($item['headline'] ?? '');
            $body = strtolower(strip_tags($item['body'] ?? ''));

            foreach ($tokens as $token) {
                $tokenLower = strtolower($token);
                if (strlen($tokenLower) < 2) continue;

                // Judul (headline) memiliki bobot tinggi (+3 poin per kemunculan)
                $headlineMatches = substr_count($headline, $tokenLower);
                $score += ($headlineMatches * 3);

                // Isi artikel (body) memiliki bobot normal (+1 poin per kemunculan, maks 10 poin per kata)
                $bodyMatches = min(substr_count($body, $tokenLower), 10);
                $score += $bodyMatches;
            }

            $item['_relevance_score'] = $score;
        }
        unset($item);

        // Urutkan berdasar skor tertinggi
        usort($results, function ($a, $b) {
            if (($b['_relevance_score'] ?? 0) === ($a['_relevance_score'] ?? 0)) {
                return 0;
            }
            return ($b['_relevance_score'] ?? 0) <=> ($a['_relevance_score'] ?? 0);
        });

        // Bersihkan atribut internal
        foreach ($results as &$item) {
            unset($item['_relevance_score']);
        }
        unset($item);

        return $results;
    }

    /**
     * STEP 7: Bangun array SPO Triplets untuk visualisasi semantik di view.
     */
    protected function buildSpoTriplets(
        array   $tokens,
        ?string $categoryFilter,
        ?string $detectedCat,
        ?string $detectedYear,
        ?string $periodLabel,
        ?string $detectedSource,
        ?string $sortLabel
    ): array {
        $spo = [];

        if (!empty($tokens)) {
            $spo[] = [
                'subject'   => 'Berita',
                'predicate' => 'mengandung_kata_kunci',
                'object'    => implode(', ', $tokens),
            ];
        }

        if ($detectedCat) {
            $spo[] = [
                'subject'   => 'Berita',
                'predicate' => 'memiliki_kategori',
                'object'    => $detectedCat,
            ];
        }

        if ($detectedYear) {
            $spo[] = [
                'subject'   => 'Berita',
                'predicate' => 'diterbitkan_pada_tahun',
                'object'    => $detectedYear,
            ];
        }

        if ($periodLabel) {
            $spo[] = [
                'subject'   => 'Berita',
                'predicate' => 'diterbitkan_pada_periode',
                'object'    => $periodLabel,
            ];
        }

        if ($detectedSource) {
            $spo[] = [
                'subject'   => 'Berita',
                'predicate' => 'bersumber_dari',
                'object'    => $detectedSource,
            ];
        }

        if ($sortLabel) {
            $spo[] = [
                'subject'   => 'Hasil_Pencarian',
                'predicate' => 'diurutkan_berdasarkan',
                'object'    => $sortLabel,
            ];
        }

        return $spo;
    }

    /**
     * Autocomplete — Saran judul berita berdasarkan prefix query.
     * Digunakan oleh endpoint AJAX.
     */
    public function autocomplete(string $q): array
    {
        if (strlen(trim($q)) < 2) {
            return [];
        }

        // Cari dari MySQL (cepat, tidak perlu SPARQL untuk autocomplete)
        $suggestions = News::where('title', 'LIKE', "%$q%")
            ->orderBy('published_at', 'desc')
            ->limit(7)
            ->pluck('title')
            ->toArray();

        return $suggestions;
    }

    /**
     * Highlight semua token dalam teks — bungkus dengan <mark>.
     * Gunakan di Blade dengan {!! !!} agar HTML tidak di-escape.
     */
    public static function highlight(string $text, array $tokens): string
    {
        if (empty($tokens)) {
            return e($text);
        }

        $text = e($text);

        foreach ($tokens as $token) {
            if (strlen(trim($token)) < 2) continue;
            $safe = preg_quote($token, '/');
            $text = preg_replace(
                '/(' . $safe . ')/iu',
                '<mark class="search-highlight">$1</mark>',
                $text
            );
        }

        return $text;
    }
}
