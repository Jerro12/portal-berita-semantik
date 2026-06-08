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
        'berita', 'artikel', 'informasi', 'kabar', 'laporan', 'tulisan',
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

        // Hapus frasa perintah umum konteks berita
        $commandPhrases = [
            'carikan berita', 'tampilkan berita', 'cari berita',
            'lihat berita', 'berita apa', 'apa berita', 'tunjukkan berita',
            'kasih lihat', 'tolong carikan', 'ingin tahu',
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
        } elseif (preg_match('/\b(terlama|lama|lawas|jadul|klasik|kuno|lama)\b/i', $cleanQ)) {
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
        $sparqlQuery = $this->buildSparqlQuery($tokens, $categoryFilter, $detectedYear, $detectedSource, $sortOrder);

        $sparqlResults = $this->semantic->query($sparqlQuery);
        $results = $sparqlResults['result']['rows'] ?? [];

        $dataSource = 'sparql';

        // ====================================================
        // STEP 6: MYSQL FALLBACK
        // ====================================================
        if (empty($results) && (!empty($tokens) || $categoryFilter)) {
            $results       = $this->mysqlFallback($tokens, $categoryFilter, $detectedYear, $detectedSource, $sortOrder);
            $dataSource    = 'mysql';
        }

        // ====================================================
        // STEP 7: RESPONSE ASSEMBLY — SPO Triplets + metadata
        // ====================================================
        $spoTriplets = $this->buildSpoTriplets(
            $tokens, $categoryFilter, $detectedCat,
            $detectedYear, $detectedSource, $sortLabel
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
            'detected_source'=> $detectedSource,     // sumber terdeteksi
            'total'          => count($results),
        ];
    }

    /**
     * STEP 5: Bangun query SPARQL multi-token.
     */
    protected function buildSparqlQuery(
        array  $tokens,
        ?string $category,
        ?string $year,
        ?string $source,
        string  $sortOrder
    ): string {
        $filters = [];

        // Filter teks (judul ATAU isi) untuk setiap token — OR antar token
        if (!empty($tokens)) {
            $regexParts = [];
            foreach ($tokens as $token) {
                $safe = addslashes($token);
                $regexParts[] = "REGEX(?headline, \"$safe\", \"i\")";
                $regexParts[] = "REGEX(?body, \"$safe\", \"i\")";
            }
            $filters[] = 'FILTER(' . implode(' || ', $regexParts) . ')';
        }

        // Filter kategori (exact match di triplestore)
        if ($category) {
            $safeCat = addslashes($category);
            $filters[] = "FILTER(REGEX(?category, \"$safeCat\", \"i\"))";
        }

        // Filter tahun
        if ($year) {
            $filters[] = "FILTER(REGEX(?date, \"$year\"))";
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
        ?string $source,
        string  $sortOrder
    ): array {
        $query = News::query();

        if (!empty($tokens)) {
            $query->where(function ($q) use ($tokens) {
                foreach ($tokens as $token) {
                    $q->orWhere(function ($inner) use ($token) {
                        $inner->where('title', 'LIKE', "%$token%")
                              ->orWhere('content', 'LIKE', "%$token%");
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
     * STEP 7: Bangun array SPO Triplets untuk visualisasi semantik di view.
     */
    protected function buildSpoTriplets(
        array   $tokens,
        ?string $categoryFilter,
        ?string $detectedCat,
        ?string $detectedYear,
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
