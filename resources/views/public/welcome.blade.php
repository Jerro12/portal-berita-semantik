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
                    <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center shadow-lg shadow-primary/20 group-hover:rotate-6 transition-transform overflow-hidden">
                        <img src="/portal_berita_logo_icon_1777981056681.png" class="w-full h-full object-cover" alt="Logo">
                    </div>
                    <span class="text-xl font-bold tracking-tight text-foreground">
                        Portal<span class="text-primary">Berita</span>
                    </span>
                </a>
                
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-xs font-bold text-primary uppercase tracking-widest transition-colors">Beranda</a>
                    <a href="{{ route('public.ontology') }}" class="text-xs font-bold text-muted-foreground hover:text-primary uppercase tracking-widest transition-colors">Ontologi</a>
                    <a href="{{ route('public.semantic.index') }}" class="text-xs font-bold text-muted-foreground hover:text-primary uppercase tracking-widest transition-colors">Indeks Semantik</a>
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

        <!-- Hero Section -->
        <header class="relative pt-24 pb-40 overflow-hidden border-b border-border bg-[#172A39]">
            <!-- Hero Background Image -->
            <div class="absolute inset-0 z-0">
                <img src="/semantic_hero_bg_1777979268720.png" class="w-full h-full object-cover opacity-30 mix-blend-overlay" alt="Background">
                <div class="absolute inset-0 bg-gradient-to-b from-[#172A39]/80 via-[#172A39]/60 to-background"></div>
            </div>

            <!-- Decorative Floating Elements -->
            <div class="absolute top-1/4 -left-20 w-96 h-96 bg-primary/20 rounded-full blur-[100px] animate-pulse"></div>
            <div class="absolute bottom-1/4 -right-20 w-80 h-80 bg-accent/10 rounded-full blur-[120px] animate-pulse" style="animation-delay: 2s"></div>
            
            <div class="max-w-7xl mx-auto px-4 relative z-10">
                <div class="text-center max-w-3xl mx-auto">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary-soft border border-primary/20 text-primary text-[10px] font-bold uppercase tracking-[0.2em] mb-8 animate-fade-in">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
                        </span>
                        Mesin Pencari Generasi Baru
                    </div>

                    <!-- Decorative Icon -->
                    <div class="absolute right-0 top-0 opacity-20 -rotate-12 translate-x-20 -translate-y-10 hidden lg:block animate-float">
                        <svg class="w-64 h-64 text-accent" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                            <circle cx="12" cy="12" r="3"/>
                            <path d="M16.5 7.5L14 10m-4 4l-2.5 2.5M7.5 7.5L10 10m4 4l2.5 2.5"/>
                        </svg>
                    </div>
                    
                    <h1 class="text-5xl md:text-7xl font-serif font-bold mb-8 tracking-tighter text-white leading-[1.1]">
                        Temukan Pengetahuan dengan <br/> <span class="text-accent">Web Semantik</span>
                    </h1>
                    
                    <p class="text-xl text-white/70 mb-12 leading-relaxed font-medium">
                        Jelajahi berita global melalui jaringan data yang terhubung dan ontologi yang kaya.
                    </p>

                    <form action="/" method="GET" class="relative max-w-2xl mx-auto group">
                        <div class="absolute inset-0 bg-primary/20 blur-2xl group-focus-within:bg-primary/30 transition-all opacity-0 group-focus-within:opacity-100 rounded-2xl"></div>
                        <div class="relative flex">
                            <input type="text" name="q" value="{{ $query ?? '' }}" placeholder="Cari berita berdasarkan topik, entitas, atau kata kunci..." 
                                class="w-full pl-6 pr-40 py-5 rounded-2xl border-2 border-border bg-background focus:border-primary focus:ring-0 shadow-2xl text-lg transition-all placeholder:text-muted-foreground/50">
                            <button type="submit" class="absolute right-2 top-2 bottom-2 px-10 bg-primary text-primary-foreground rounded-xl font-bold uppercase tracking-widest text-xs hover:bg-primary-hover transition-all hover:shadow-lg hover:shadow-primary/30">
                                Cari
                            </button>
                        </div>
                    </form>

                    <div class="mt-10 flex flex-wrap justify-center gap-3">
                        <span class="text-xs font-bold text-primary uppercase tracking-widest py-2">Sedang Tren:</span>
                        @foreach(['Teknologi', 'Ekonomi', 'Kesehatan', 'Politik'] as $tag)
                            <a href="/?q={{ $tag }}" class="px-4 py-2 rounded-xl bg-background border border-secondary/20 text-xs font-bold text-muted-foreground hover:bg-primary hover:text-primary-foreground hover:border-primary transition-all">
                                #{{ $tag }}
                            </a>
                        @endforeach
                        <!-- Semantic Filters -->
                        <div class="flex flex-wrap items-center gap-3 mt-8">
                            <span class="text-[10px] font-bold text-primary uppercase tracking-widest mr-2">Kategori Ontologi:</span>
                            <a href="{{ route('home') }}" 
                                class="px-5 py-2 rounded-full text-xs font-bold transition-all {{ !$categoryFilter ? 'bg-accent text-white shadow-lg shadow-accent/20' : 'bg-white/10 backdrop-blur-md border border-white/20 text-white hover:bg-accent hover:text-white hover:border-accent' }}">
                                Semua Konsep
                            </a>
                            @foreach($categories as $cat)
                                <a href="{{ route('home', ['category' => $cat->name, 'q' => $query]) }}" 
                                    class="px-5 py-2 rounded-full text-xs font-bold transition-all {{ $categoryFilter == $cat->name ? 'bg-accent text-white shadow-lg shadow-accent/20' : 'bg-white/10 backdrop-blur-md border border-white/20 text-white hover:bg-accent hover:text-white hover:border-accent' }}">
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
                        <h2 class="text-4xl font-serif font-bold text-foreground">Pencarian: <span class="text-primary italic">"{{ $query }}"</span></h2>
                        <p class="text-muted-foreground mt-2 font-medium">Menampilkan kecocokan semantik dari triplestore persisten</p>
                    @else
                        <h2 class="text-4xl font-serif font-bold text-foreground">Pembaruan <span class="text-primary italic">Terkini</span></h2>
                        <p class="text-muted-foreground mt-2 font-medium">Artikel berita semantik yang baru saja diindeks</p>
                    @endif
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <div class="text-xs font-bold text-muted-foreground uppercase tracking-widest mb-1">Waktu Respons</div>
                        <div class="text-lg font-mono font-bold text-primary">0.042s</div>
                    </div>
                    <div class="w-[1px] h-10 bg-border"></div>
                    <div class="text-right">
                        <div class="text-xs font-bold text-muted-foreground uppercase tracking-widest mb-1">Triple Dipindai</div>
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
                        <h3 class="text-2xl font-serif font-bold text-foreground mb-2">Tidak Ada Triple Ditemukan</h3>
                        <p class="text-muted-foreground">Coba cari istilah yang lebih luas atau kategori yang berbeda.</p>
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
