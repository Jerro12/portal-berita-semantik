<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Services\SemanticService;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    protected $semanticService;

    public function __construct(SemanticService $semanticService)
    {
        $this->semanticService = $semanticService;
    }

    public function index()
    {
        $news = News::latest()->get();
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|string',
            'source' => 'nullable|string',
            'published_at' => 'required|date',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_url' => 'nullable|url',
        ]);

        $data = $validated;
        
        // Handle Image
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('news', 'public');
            $data['image'] = '/storage/' . $path;
        } elseif ($request->filled('image_url')) {
            $data['image'] = $request->image_url;
        }

        // 1. Simpan ke Database Relasional (MySQL)
        $news = News::create($data);

        // 2. Konversi ke RDF & Indeks ke Triplestore (Semantic Web)
        $this->semanticService->indexNews($news);

        return redirect()->route('news.index')
            ->with('success', 'Berita berhasil disimpan dan diindeks secara semantik.');
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|string',
            'source' => 'nullable|string',
            'published_at' => 'required|date',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_url' => 'nullable|url',
        ]);

        $data = $validated;

        // Handle Image
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('news', 'public');
            $data['image'] = '/storage/' . $path;
        } elseif ($request->filled('image_url')) {
            $data['image'] = $request->image_url;
        }

        // 1. Update di MySQL
        $news->update($data);

        // 2. Update di Triplestore (Hapus yang lama, simpan yang baru)
        $this->semanticService->indexNews($news);

        return redirect()->route('news.index')
            ->with('success', 'Berita berhasil diperbarui dan disinkronkan secara semantik.');
    }

    public function destroy(News $news)
    {
        $news->delete();
        return redirect()->route('news.index')->with('success', 'Berita berhasil dihapus.');
    }

    /**
     * Endpoint untuk testing SPARQL (Opsional)
     */
    public function sparql(Request $request)
    {
        $query = $request->input('query', 'SELECT ?s ?p ?o WHERE { ?s ?p ?o } LIMIT 100');
        $results = $this->semanticService->query($query);
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json($results);
        }

        $triples = $results['result']['rows'] ?? [];
        
        return view('admin.graph', compact('triples', 'query'));
    }
}
