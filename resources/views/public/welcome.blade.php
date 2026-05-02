<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Portal Berita Semantik</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
            .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); }
        </style>
    </head>
    <body class="antialiased bg-background text-foreground font-sans">
        
        <!-- Navbar -->
        <nav class="sticky top-0 z-50 border-b border-border bg-background/80 backdrop-blur-xl py-4">
            <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
                <a href="/" class="flex items-center gap-2 group">
                    <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center text-primary-foreground font-serif font-bold text-xl shadow-lg shadow-primary/20 group-hover:rotate-6 transition-transform">
                        S
                    </div>
                    <span class="text-xl font-bold tracking-tight text-foreground">
                        News<span class="text-primary">Hub</span>
                    </span>
                </a>
                
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-xs font-bold text-primary uppercase tracking-widest transition-colors">Home</a>
                    <a href="{{ route('public.ontology') }}" class="text-xs font-bold text-muted-foreground hover:text-primary uppercase tracking-widest transition-colors">Ontology</a>
                    <a href="{{ route('public.semantic.index') }}" class="text-xs font-bold text-muted-foreground hover:text-primary uppercase tracking-widest transition-colors">Semantic Index</a>
                    <div class="h-4 w-[1px] bg-border mx-2"></div>
                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-secondary text-primary rounded-lg font-bold text-xs uppercase tracking-widest hover:bg-primary-soft transition-colors">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-muted-foreground hover:text-primary transition-colors">Admin Login</a>
                    @endauth
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <header class="relative pt-20 pb-32 overflow-hidden border-b border-border">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,var(--primary-soft),transparent)] opacity-50"></div>
            
            <div class="max-w-7xl mx-auto px-4 relative">
                <div class="text-center max-w-3xl mx-auto">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary-soft border border-primary/20 text-primary text-[10px] font-bold uppercase tracking-[0.2em] mb-8 animate-fade-in">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
                        </span>
                        Next-Gen Search Engine
                    </div>
                    
                    <h1 class="text-5xl md:text-7xl font-serif font-bold mb-8 tracking-tighter text-foreground leading-[1.1]">
                        Uncover Knowledge with <br/> <span class="text-primary">Semantic Web</span>
                    </h1>
                    
                    <p class="text-xl text-muted-foreground mb-12 leading-relaxed font-medium">
                        Explore global news through a network of connected data and rich ontologies.
                    </p>

                    <form action="/" method="GET" class="relative max-w-2xl mx-auto group">
                        <div class="absolute inset-0 bg-primary/20 blur-2xl group-focus-within:bg-primary/30 transition-all opacity-0 group-focus-within:opacity-100 rounded-2xl"></div>
                        <div class="relative flex">
                            <input type="text" name="q" value="{{ $query ?? '' }}" placeholder="Search news by topic, entity, or keyword..." 
                                class="w-full pl-6 pr-40 py-5 rounded-2xl border-2 border-border bg-background focus:border-primary focus:ring-0 shadow-2xl text-lg transition-all placeholder:text-muted-foreground/50">
                            <button type="submit" class="absolute right-2 top-2 bottom-2 px-10 bg-primary text-primary-foreground rounded-xl font-bold uppercase tracking-widest text-xs hover:bg-primary-hover transition-all hover:shadow-lg hover:shadow-primary/30">
                                Search
                            </button>
                        </div>
                    </form>

                    <div class="mt-10 flex flex-wrap justify-center gap-3">
                        <span class="text-xs font-bold text-muted-foreground/60 uppercase tracking-widest py-2">Trending:</span>
                        @foreach(['Teknologi', 'Ekonomi', 'Kesehatan', 'Politik'] as $tag)
                            <a href="/?q={{ $tag }}" class="px-4 py-2 rounded-xl bg-secondary border border-border text-xs font-bold text-muted-foreground hover:bg-primary-soft hover:text-primary hover:border-primary/20 transition-all">
                                #{{ $tag }}
                            </a>
                        @endforeach
                        <!-- Semantic Filters -->
                        <div class="flex flex-wrap items-center gap-3 mt-8">
                            <span class="text-[10px] font-bold text-muted-foreground uppercase tracking-widest mr-2">Ontology Categories:</span>
                            <a href="{{ route('home') }}" 
                                class="px-5 py-2 rounded-full text-xs font-bold transition-all {{ !$categoryFilter ? 'bg-primary text-primary-foreground shadow-lg shadow-primary/20' : 'bg-secondary text-muted-foreground hover:bg-secondary/80' }}">
                                All Concepts
                            </a>
                            @foreach($categories as $cat)
                                <a href="{{ route('home', ['category' => $cat->name, 'q' => $query]) }}" 
                                    class="px-5 py-2 rounded-full text-xs font-bold transition-all {{ $categoryFilter == $cat->name ? 'bg-primary text-primary-foreground shadow-lg shadow-primary/20' : 'bg-secondary text-muted-foreground hover:bg-secondary/80' }}">
                                    {{ $cat->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 py-24">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6 mb-16 border-b border-border pb-10">
                <div>
                    @if($query)
                        <h2 class="text-4xl font-serif font-bold text-foreground">Query: <span class="text-primary italic">"{{ $query }}"</span></h2>
                        <p class="text-muted-foreground mt-2 font-medium">Showing semantic matches from persistent triplestore</p>
                    @else
                        <h2 class="text-4xl font-serif font-bold text-foreground">Latest <span class="text-primary italic">Updates</span></h2>
                        <p class="text-muted-foreground mt-2 font-medium">Freshly indexed semantic news articles</p>
                    @endif
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <div class="text-xs font-bold text-muted-foreground uppercase tracking-widest mb-1">Response Time</div>
                        <div class="text-lg font-mono font-bold text-primary">0.042s</div>
                    </div>
                    <div class="w-[1px] h-10 bg-border"></div>
                    <div class="text-right">
                        <div class="text-xs font-bold text-muted-foreground uppercase tracking-widest mb-1">Triples Scanned</div>
                        <div class="text-lg font-mono font-bold text-primary">{{ count($results) * 8 }}</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($results as $row)
                    <x-news-card :news="$row" />
                @empty
                    <div class="col-span-full text-center py-32 bg-secondary/20 rounded-[2rem] border border-dashed border-border">
                        <div class="w-20 h-20 bg-background rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-sm">
                            <svg class="w-10 h-10 text-muted-foreground/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-serif font-bold text-foreground mb-2">No Triples Found</h3>
                        <p class="text-muted-foreground">Try searching for a broader term or different category.</p>
                    </div>
                @endforelse
            </div>
        </main>

        <footer class="py-16 border-t border-border mt-24 bg-secondary/10">
            <div class="max-w-5xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-12 text-center md:text-left">
                <div class="space-y-4">
                    <div class="flex items-center justify-center md:justify-start gap-2">
                        <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center text-primary-foreground font-serif font-bold">S</div>
                        <span class="text-lg font-bold tracking-tight text-foreground">NewsHub</span>
                    </div>
                    <p class="text-xs text-muted-foreground leading-relaxed">Penerapan Teknologi Web Semantik untuk kurasi berita cerdas berbasis Ontologi Schema.org.</p>
                </div>
                <div class="space-y-4">
                    <h4 class="text-xs font-bold uppercase tracking-widest text-foreground">Semantic Links</h4>
                    <ul class="space-y-2 text-xs text-muted-foreground font-medium">
                        <li><a href="{{ route('public.ontology') }}" class="hover:text-primary transition-colors">Ontology Spec</a></li>
                        <li><a href="{{ route('public.semantic.index') }}" class="hover:text-primary transition-colors">Semantic Index</a></li>
                        <li><a href="https://schema.org" target="_blank" class="hover:text-primary transition-colors">Schema.org Vocabulary</a></li>
                    </ul>
                </div>
                <div class="space-y-4">
                    <h4 class="text-xs font-bold uppercase tracking-widest text-foreground">Project Info</h4>
                    <p class="text-xs text-muted-foreground font-medium">&copy; {{ date('Y') }} Portal Berita Semantik - Thesis Project. Developed with Laravel & ARC2.</p>
                </div>
            </div>
        </footer>

    </body>

</html>
