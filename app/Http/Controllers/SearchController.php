<?php

namespace App\Http\Controllers;

use App\Services\SemanticService;
use App\Services\SmartSearchService;
use App\Models\News;
use Illuminate\Http\Request;
use EasyRdf\Graph;
use EasyRdf\RdfNamespace;

class SearchController extends Controller
{
    protected $semanticService;
    protected $smartSearch;

    public function __construct(SemanticService $semanticService, SmartSearchService $smartSearch)
    {
        $this->semanticService = $semanticService;
        $this->smartSearch     = $smartSearch;
    }

    /**
     * Halaman utama / hasil pencarian.
     * Menggabungkan Smart Search pipeline dengan hasil SPARQL.
     */
    public function index(Request $request)
    {
        $query          = $request->input('q', '');
        $categoryFilter = $request->input('category');
        $categories     = \App\Models\Category::all();

        // Jalankan Smart Search hanya jika ada input query atau filter kategori
        if ($query || $categoryFilter) {
            $searchData = $this->smartSearch->search($query, [
                'category' => $categoryFilter,
            ]);

            $results     = $searchData['results'];
            $queryInfo   = $searchData;
        } else {
            // Halaman beranda — ambil semua berita terbaru via SPARQL langsung
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
                }
                ORDER BY DESC(?date)
                LIMIT 12
            ";

            $sparqlResults = $this->semanticService->query($sparql);
            $results       = $sparqlResults['result']['rows'] ?? [];
            $queryInfo     = null;
        }

        return view('public.welcome', compact(
            'results',
            'query',
            'categories',
            'categoryFilter',
            'queryInfo'
        ));
    }

    /**
     * Endpoint AJAX untuk autocomplete search bar.
     * Mengembalikan JSON array of strings.
     */
    public function autocomplete(Request $request)
    {
        $q = trim($request->input('q', ''));

        if (strlen($q) < 2) {
            return response()->json([]);
        }

        $suggestions = $this->smartSearch->autocomplete($q);

        return response()->json($suggestions);
    }

    public function show(News $news)
    {
        $uri = url('/ns/news/' . $news->id);

        // SPARQL untuk mengambil semua triple terkait URI berita ini
        $sparql = "SELECT ?p ?o WHERE { <$uri> ?p ?o . }";
        $triplesResults = $this->semanticService->query($sparql);
        $triples = $triplesResults['result']['rows'] ?? [];

        // Siapkan JSON-LD untuk View
        $jsonLd = [
            "@context"    => "https://schema.org",
            "@type"       => "NewsArticle",
            "headline"    => $news->title,
            "articleBody" => str_replace(["\r", "\n"], ' ', strip_tags($news->content)),
            "datePublished" => $news->published_at->toIso8601String(),
            "author"      => [
                "@type" => "Person",
                "name"  => $news->source ?? 'Admin',
            ],
            "publisher"   => [
                "@type" => "Organization",
                "name"  => "NewsHub Semantic Engine",
            ],
            "articleSection" => $news->category,
            "image"       => $news->image ?: null,
        ];

        return view('public.show', compact('news', 'triples', 'jsonLd'));
    }

    public function exportRdf(News $news)
    {
        $graph = new Graph();
        RdfNamespace::set('schema', 'https://schema.org/');

        $uri      = url('/ns/news/' . $news->id);
        $resource = $graph->resource($uri);

        $resource->add('rdf:type', $graph->resource('https://schema.org/NewsArticle'));
        $resource->add('schema:headline', $news->title);
        $resource->add('schema:articleBody', $news->content);
        $resource->add('schema:datePublished', $news->published_at?->toIso8601String());
        $resource->add('schema:articleSection', $news->category);
        $resource->add('schema:author', $news->source ?? 'Admin');

        if ($news->image) {
            $resource->add('schema:image', $news->image);
        }

        $turtle   = $graph->serialise('turtle');
        $filename = 'news-' . $news->id . '.ttl';

        return response($turtle)
            ->header('Content-Type', 'text/turtle')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    public function ontology()
    {
        return view('public.ontology');
    }

    public function semanticIndex()
    {
        $tripleCountResults = $this->semanticService->query('SELECT (COUNT(*) as ?total) WHERE { ?s ?p ?o }');
        $totalTriples       = $tripleCountResults['result']['rows'][0]['total'] ?? 0;

        $predicatesResults = $this->semanticService->query(
            'SELECT ?p (COUNT(?s) as ?count) WHERE { ?s ?p ?o } GROUP BY ?p ORDER BY DESC(?count)'
        );
        $predicates = $predicatesResults['result']['rows'] ?? [];

        return view('public.semantic-index', compact('totalTriples', 'predicates'));
    }

    public function about()
    {
        return view('public.about');
    }
}
