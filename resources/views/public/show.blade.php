<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $news->title }} - NewsHub Semantic</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- JSON-LD Semantic Metadata -->
        <script type="application/ld+json">
        {!! json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
        </script>
    </head>
    <body class="antialiased bg-background text-foreground font-sans">
        
        <!-- Navbar -->
        <nav class="border-b border-border bg-background/80 backdrop-blur-md py-4 sticky top-0 z-50">
            <div class="max-w-5xl mx-auto px-4 flex justify-between items-center">
                <a href="/" class="flex items-center gap-2 group">
                    <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center text-primary-foreground font-serif font-bold text-lg shadow-lg shadow-primary/20">S</div>
                    <span class="text-lg font-bold tracking-tight text-foreground">News<span class="text-primary">Hub</span></span>
                </a>
                <div class="flex items-center gap-6">
                    <a href="{{ route('public.ontology') }}" class="text-xs font-bold text-muted-foreground hover:text-primary uppercase tracking-widest transition-colors">Ontology</a>
                    <a href="{{ route('public.semantic.index') }}" class="text-xs font-bold text-muted-foreground hover:text-primary uppercase tracking-widest transition-colors">Semantic Index</a>
                    <div class="flex items-center gap-4 border-l border-border pl-6">
                        @auth
                            <a href="{{ route('news.index') }}" class="text-xs font-bold text-primary hover:underline uppercase tracking-widest flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                Admin
                            </a>
                        @endauth
                        <a href="{{ url()->previous() == url()->current() ? route('home') : url()->previous() }}" class="text-xs font-bold text-muted-foreground hover:text-primary uppercase tracking-widest transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Back
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <main class="max-w-5xl mx-auto px-4 py-12">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                
                <!-- News Content -->
                <div class="lg:col-span-2 space-y-8">
                    <div class="space-y-4">
                        <span class="meta-tag">
                            <span class="meta-tag-key">rdf:type</span> {{ $news->category }}
                        </span>
                        <h1 class="text-4xl md:text-5xl font-serif font-bold text-foreground leading-tight">
                            {{ $news->title }}
                        </h1>
                        <div class="flex items-center gap-6 text-sm text-muted-foreground font-medium border-y border-border py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-secondary flex items-center justify-center text-primary">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                {{ $news->source }}
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ $news->published_at->translatedFormat('d F Y H:i') }}
                            </div>
                        </div>
                    </div>

                    @if($news->image)
                        <div class="rounded-[2rem] overflow-hidden border border-border shadow-2xl">
                            <img src="{{ $news->image }}" alt="{{ $news->title }}" class="w-full h-auto">
                        </div>
                    @endif

                    <div class="prose prose-lg max-w-none text-foreground/80 leading-relaxed font-sans first-letter:text-5xl first-letter:font-serif first-letter:font-bold first-letter:mr-3 first-letter:float-left">
                        {!! nl2br(e($news->content)) !!}
                    </div>
                </div>

                <!-- Semantic Sidebar -->
                <div class="space-y-8">
                    <div class="sticky top-24">
                        <div class="p-8 rounded-[2rem] bg-secondary/30 border border-border">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center text-primary-foreground shadow-lg shadow-primary/20">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                </div>
                                <h3 class="font-serif font-bold text-xl">Triple Inspector</h3>
                            </div>
                            
                            <p class="text-xs text-muted-foreground mb-6 leading-relaxed">
                                Metadata di bawah ini diekstrak langsung dari Triplestore menggunakan query SPARQL.
                            </p>

                            <div class="space-y-4">
                                @forelse($triples as $triple)
                                    <div class="p-4 bg-background rounded-xl border border-border group hover:border-primary/30 transition-colors">
                                        <div class="text-[10px] font-bold text-primary uppercase tracking-widest mb-1 opacity-60 group-hover:opacity-100 transition-opacity">
                                            {{ str_replace(['https://schema.org/', 'http://www.w3.org/1999/02/22-rdf-syntax-ns#'], ['schema:', 'rdf:'], $triple['p'] ?? '') }}
                                        </div>
                                        <div class="text-sm font-medium text-foreground break-words leading-snug">
                                            {{ $triple['o'] ?? '' }}
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-xs text-muted-foreground italic">No triples found.</p>
                                @endforelse
                            </div>

                            <div class="mt-8 pt-6 border-t border-border space-y-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-[10px] font-bold text-muted-foreground uppercase tracking-widest">Total Relations</span>
                                    <span class="px-2 py-1 bg-primary text-primary-foreground rounded text-[10px] font-bold">{{ count($triples) }}</span>
                                </div>
                                <a href="{{ route('public.news.export', $news->id) }}" class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-foreground text-background rounded-xl font-bold text-xs hover:bg-foreground/90 transition-all shadow-lg shadow-foreground/10">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    DOWNLOAD RDF (.TTL)
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

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
