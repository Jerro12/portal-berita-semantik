<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Indeks Semantik - NewsHub Knowledge Base</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-background text-foreground font-sans">
        
        <!-- Navbar -->
        <nav class="border-b border-border bg-background/80 backdrop-blur-md py-4 sticky top-0 z-50">
            <div class="max-w-5xl mx-auto px-4 flex justify-between items-center">
                <a href="/" class="flex items-center gap-2 group">
                    <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center shadow-lg shadow-primary/20 overflow-hidden">
                        <img src="/portal_berita_logo_icon_1777981056681.png" class="w-full h-full object-cover" alt="Logo">
                    </div>
                    <span class="text-lg font-bold tracking-tight text-foreground">Portal<span class="text-primary">Berita</span></span>
                </a>
                <div class="flex items-center gap-6">
                    <a href="{{ route('home') }}" class="text-xs font-bold text-muted-foreground hover:text-primary uppercase tracking-widest transition-colors">Beranda</a>
                    <a href="{{ route('public.ontology') }}" class="text-xs font-bold text-muted-foreground hover:text-primary uppercase tracking-widest transition-colors">Ontologi</a>
                    <a href="{{ route('public.semantic.index') }}" class="text-xs font-bold text-primary uppercase tracking-widest">Indeks Semantik</a>
                    <a href="{{ route('public.about') }}" class="text-xs font-bold text-muted-foreground hover:text-primary uppercase tracking-widest transition-colors">Tentang</a>
                    <div class="h-4 w-[1px] bg-border mx-2"></div>
                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-secondary text-primary rounded-lg font-bold text-xs uppercase tracking-widest hover:bg-primary-soft transition-colors">Dasbor</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-muted-foreground hover:text-primary transition-colors">Login Admin</a>
                    @endauth
                </div>
            </div>
        </nav>

        <main class="max-w-5xl mx-auto px-4 py-16">
            <div class="space-y-12">
                <header class="text-center space-y-4">
                    <h1 class="text-4xl font-serif font-bold">Indeks Pengetahuan Semantik</h1>
                    <p class="text-muted-foreground max-w-2xl mx-auto">Statistik waktu nyata dan eksplorasi graf pengetahuan triplestore persisten.</p>
                </header>

                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="p-8 bg-primary text-primary-foreground rounded-[2rem] shadow-xl shadow-primary/20 flex flex-col items-center text-center">
                        <div class="text-5xl font-serif font-bold mb-2">{{ number_format($totalTriples) }}</div>
                        <div class="text-xs font-bold uppercase tracking-widest opacity-80">Total Triple Hubungan</div>
                    </div>
                    
                    <div class="p-8 bg-background border border-border rounded-[2rem] shadow-sm flex flex-col items-center text-center">
                        <div class="text-5xl font-serif font-bold mb-2 text-foreground">{{ count($predicates) }}</div>
                        <div class="text-xs font-bold uppercase tracking-widest text-muted-foreground">Predikat Unik</div>
                    </div>

                    <div class="p-8 bg-background border border-border rounded-[2rem] shadow-sm flex flex-col items-center text-center">
                        <div class="text-5xl font-serif font-bold mb-2 text-foreground">{{ \App\Models\News::count() }}</div>
                        <div class="text-xs font-bold uppercase tracking-widest text-muted-foreground">Artikel Terindeks</div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <!-- Predicate Distribution -->
                    <div class="bg-background border border-border rounded-[2rem] overflow-hidden shadow-sm">
                        <div class="p-6 bg-secondary/10 border-b border-border">
                            <h3 class="font-bold font-serif text-lg">Distribusi Penggunaan Predikat</h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-6">
                                @foreach($predicates as $row)
                                    <div class="space-y-2">
                                        <div class="flex justify-between items-end">
                                            <span class="text-xs font-mono font-bold text-primary">{{ str_replace(['https://schema.org/', 'http://www.w3.org/1999/02/22-rdf-syntax-ns#'], ['schema:', 'rdf:'], $row['p']) }}</span>
                                            <span class="text-[10px] font-bold text-muted-foreground">{{ $row['count'] }} penggunaan</span>
                                        </div>
                                        <div class="w-full h-1.5 bg-secondary rounded-full overflow-hidden">
                                            <div class="h-full bg-primary" style="width: {{ ($row['count'] / max(array_column($predicates, 'count'))) * 100 }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Ontology Map Info -->
                    <div class="space-y-6">
                        <div class="p-8 bg-secondary/30 rounded-[2rem] border border-border">
                            <h3 class="font-bold font-serif text-xl mb-4">Info Mesin Semantik</h3>
                            <p class="text-sm text-muted-foreground leading-relaxed mb-6">
                                Seluruh data di indeks ini disimpan menggunakan format <strong>Resource Description Framework (RDF)</strong>. Subjek dari setiap berita diidentifikasi menggunakan URI unik yang berbasis pada ID database.
                            </p>
                            <div class="p-4 bg-background rounded-xl border border-border font-mono text-[10px] text-primary">
                                hub:news/{id} schema:headline "Judul Berita"
                            </div>
                        </div>

                        <div class="p-8 border border-primary/20 bg-primary/5 rounded-[2rem]">
                            <h3 class="font-bold font-serif text-lg text-primary mb-3">Pemberitahuan Interoperabilitas</h3>
                            <p class="text-sm text-foreground/70 leading-relaxed">
                                Data ini tersedia untuk sistem pihak ketiga melalui endpoint SPARQL dan format serialisasi Turtle yang dapat diakses pada masing-masing halaman detail berita.
                            </p>
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
                        <span class="text-lg font-bold tracking-tight">NewsHub</span>
                    </div>
                    <p class="text-xs text-muted-foreground leading-relaxed">Penerapan Teknologi Web Semantik untuk kurasi berita cerdas berbasis Ontologi Schema.org.</p>
                </div>
                <div class="space-y-4">
                    <h4 class="text-xs font-bold uppercase tracking-widest text-foreground">Tautan Semantik</h4>
                    <ul class="space-y-2 text-xs text-muted-foreground font-medium">
                        <li><a href="{{ route('public.ontology') }}" class="hover:text-primary transition-colors">Spek Ontologi</a></li>
                        <li><a href="{{ route('public.semantic.index') }}" class="hover:text-primary transition-colors">Indeks Semantik</a></li>
                        <li><a href="https://schema.org" target="_blank" class="hover:text-primary transition-colors">Kosakata Schema.org</a></li>
                    </ul>
                </div>
                <div class="space-y-4">
                    <h4 class="text-xs font-bold uppercase tracking-widest text-foreground">Info Proyek</h4>
                    <p class="text-xs text-muted-foreground font-medium">&copy; {{ date('Y') }} Portal Berita Semantik - Proyek Skripsi. Dikembangkan dengan Laravel & ARC2.</p>
                </div>
            </div>
        </footer>
    </body>
</html>
