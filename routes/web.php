<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;

use App\Http\Controllers\SearchController;
use App\Http\Controllers\CategoryController;

// ==========================================
// PUBLIC ROUTES (USER)
// ==========================================
Route::get('/', [SearchController::class, 'index'])->name('home');
Route::get('/search/autocomplete', [SearchController::class, 'autocomplete'])->name('search.autocomplete');
Route::get('/news-detail/{news}', [SearchController::class, 'show'])->name('public.news.show');
Route::get('/news-export/{news}', [SearchController::class, 'exportRdf'])->name('public.news.export');
Route::get('/ontology', [SearchController::class, 'ontology'])->name('public.ontology');
Route::get('/semantic-index', [SearchController::class, 'semanticIndex'])->name('public.semantic.index');
Route::get('/about', [SearchController::class, 'about'])->name('public.about');

Route::get('/dashboard', function (App\Services\SemanticService $semanticService) {
    // Ambil jumlah triple asli dari triplestore
    $tripleCountResults = $semanticService->query('SELECT (COUNT(*) as ?total) WHERE { ?s ?p ?o }');
    $totalTriples = $tripleCountResults['result']['rows'][0]['total'] ?? 0;

    $stats = [
        'total_articles' => \App\Models\News::count(),
        'total_triples' => $totalTriples,
        'categories' => \App\Models\Category::count(),
    ];

    $recentActivities = \App\Models\News::latest()->take(5)->get();

    return view('dashboard', compact('stats', 'recentActivities'));
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Category Management
    Route::resource('categories', CategoryController::class);

    // News Management (Admin Only)
    Route::resource('news', NewsController::class)->except(['show']);
    Route::post('/news/reindex', [NewsController::class, 'reindex'])->name('news.reindex');
    Route::post('/news/reset-triplestore', [NewsController::class, 'resetTriplestore'])->name('news.reset_triplestore');
    Route::get('/sparql-test', [NewsController::class, 'sparql'])->name('news.sparql');
});

require __DIR__.'/auth.php';
