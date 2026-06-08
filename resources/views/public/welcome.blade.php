<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Portal Berita Semantik</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;0,800;1,600&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <style>
            .line-clamp-2 {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
            .line-clamp-3 {
                display: -webkit-box;
                -webkit-line-clamp: 3;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }

            /* ===================== Smart Search Styles ===================== */

            /* Keyword Highlight */
            mark.search-highlight {
                background: linear-gradient(120deg, #fde68a 0%, #fbbf24 100%);
                color: #92400e;
                border-radius: 3px;
                padding: 0 2px;
                font-weight: 700;
            }

            /* Autocomplete Dropdown */
            #autocomplete-dropdown {
                position: absolute;
                top: calc(100% + 6px);
                left: 0; right: 0;
                z-index: 9999;
                background: #fff;
                border: 1px solid #e2e8f0;
                border-radius: 12px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.12);
                overflow: hidden;
                animation: dropIn 0.15s ease;
            }
            @keyframes dropIn {
                from { opacity: 0; transform: translateY(-6px); }
                to   { opacity: 1; transform: translateY(0); }
            }
            .autocomplete-item {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 9px 14px;
                font-size: 13px;
                color: #334155;
                cursor: pointer;
                transition: background 0.12s;
                border-bottom: 1px solid #f1f5f9;
            }
            .autocomplete-item:last-child { border-bottom: none; }
            .autocomplete-item:hover, .autocomplete-item.active { background: #f8fafc; }
            .autocomplete-item svg { flex-shrink: 0; color: #94a3b8; }

            /* Smart Feedback Panel */
            .smart-feedback-panel {
                background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
                border: 1px solid #bae6fd;
                border-radius: 12px;
                padding: 12px 16px;
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
                align-items: center;
            }
            .spo-chip {
                display: inline-flex;
                align-items: center;
                gap: 4px;
                background: #fff;
                border: 1px solid #bae6fd;
                border-radius: 20px;
                padding: 3px 10px;
                font-size: 11px;
                font-weight: 600;
                color: #0369a1;
                font-family: monospace;
            }
            .spo-chip .spo-pred {
                color: #9ca3af;
                font-style: italic;
            }
            .spo-chip .spo-obj {
                color: #1d4ed8;
                font-weight: 700;
            }

            /* Data Source Badge */
            .source-badge-sparql {
                display: inline-flex; align-items: center; gap: 5px;
                background: #dcfce7; color: #15803d;
                border: 1px solid #86efac;
                border-radius: 20px; padding: 3px 10px;
                font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;
            }
            .source-badge-mysql {
                display: inline-flex; align-items: center; gap: 5px;
                background: #fef9c3; color: #92400e;
                border: 1px solid #fde68a;
                border-radius: 20px; padding: 3px 10px;
                font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;
            }

            /* SPARQL Debug Panel */
            .sparql-debug {
                background: #1e293b;
                border-radius: 10px;
                padding: 14px 16px;
                font-family: 'JetBrains Mono', 'Fira Code', monospace;
                font-size: 11px;
                color: #94a3b8;
                white-space: pre-wrap;
                line-height: 1.6;
                border: 1px solid #334155;
            }
            .sparql-debug .kw-prefix { color: #c084fc; }
            .sparql-debug .kw-select { color: #38bdf8; }
            .sparql-debug .kw-where  { color: #38bdf8; }
            .sparql-debug .kw-filter { color: #fb923c; }
            .sparql-debug .kw-order  { color: #4ade80; }
            details > summary {
                cursor: pointer;
                user-select: none;
                list-style: none;
            }
            details > summary::-webkit-details-marker { display: none; }
        </style>
    </head>
    <body class="antialiased bg-white text-slate-900 selection:bg-accent selection:text-white">
        
        <!-- Top Utility Bar / Header -->
        <header class="border-b border-slate-100 bg-white">
            <div class="max-w-7xl mx-auto px-4 py-6 flex flex-col lg:flex-row justify-between items-center gap-6">
                <!-- Brand Logo & Meta -->
                <div class="flex items-center gap-4">
                    <a href="/" class="flex items-center gap-3 group">
                        <div class="w-12 h-12 bg-primary rounded-xl flex items-center justify-center shadow-md group-hover:rotate-3 transition-transform overflow-hidden relative border border-slate-200">
                            <span class="text-white font-serif font-black text-xl">PS</span>
                            <div class="absolute bottom-0 inset-x-0 h-1 bg-accent"></div>
                        </div>
                        <div>
                            <h1 class="text-2xl md:text-3xl font-serif font-black tracking-tight leading-none text-primary">
                                PORTAL BERITA <span class="text-accent">SEMANTIK</span>
                            </h1>
                            <p class="text-[10px] uppercase tracking-widest text-slate-400 font-bold mt-1">
                                Riset & Aplikasi Pencarian Berbasis Ontologi
                            </p>
                        </div>
                    </a>
                </div>

                <!-- Date & Info Bar -->
                <div class="flex items-center gap-6 text-xs text-slate-500 font-medium bg-slate-50 border border-slate-200/60 px-4 py-2.5 rounded-full">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span id="realtime-clock" class="font-mono font-bold">Minggu, 31 Mei 2026</span>
                    </div>
                    <div class="h-3.5 w-[1px] bg-slate-200"></div>
                    <div class="flex items-center gap-1">
                        <span class="font-bold text-primary">SPARQL Engine:</span> Active (ARC2)
                    </div>
                </div>

                <!-- Smart Search Bar + Autocomplete -->
                <form id="search-form" action="/" method="GET" class="relative w-full max-w-sm" autocomplete="off">
                    <div class="relative">
                        <input
                            id="search-input"
                            type="text"
                            name="q"
                            value="{{ $query ?? '' }}"
                            placeholder="Cari topik, kategori, atau berita..."
                            class="w-full pl-4 pr-10 py-2.5 rounded-full border border-slate-200 bg-slate-50 focus:bg-white focus:border-accent focus:ring-1 focus:ring-accent/20 text-sm transition-all placeholder:text-slate-400"
                        >
                        <button type="submit" class="absolute right-3 top-3 text-slate-400 hover:text-accent transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>

                        <!-- Autocomplete Dropdown (diisi via JS) -->
                        <div id="autocomplete-dropdown" class="hidden"></div>
                    </div>
                    @if($categoryFilter)
                        <input type="hidden" name="category" value="{{ $categoryFilter }}">
                    @endif
                </form>
            </div>
        </header>

        <!-- Navbar Navigation -->
        <nav class="sticky top-0 z-50 border-b border-slate-200 bg-white/95 backdrop-blur-md shadow-sm">
            <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
                <!-- Nav Links -->
                <div class="flex items-center overflow-x-auto scrollbar-none py-1 w-full lg:w-auto">
                    <a href="{{ route('home') }}" 
                        class="px-4 py-4 text-xs font-black uppercase tracking-wider transition-colors border-b-2 {{ !$categoryFilter ? 'border-accent text-accent' : 'border-transparent text-slate-700 hover:text-accent hover:border-accent/40' }}">
                        Beranda
                    </a>
                    
                    @foreach($categories as $cat)
                        <a href="{{ route('home', ['category' => $cat->name, 'q' => $query]) }}" 
                            class="px-4 py-4 text-xs font-black uppercase tracking-wider transition-colors whitespace-nowrap border-b-2 {{ $categoryFilter == $cat->name ? 'border-accent text-accent' : 'border-transparent text-slate-700 hover:text-accent hover:border-accent/40' }}">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                    
                    <div class="h-6 w-[1px] bg-slate-200 mx-2 hidden lg:block"></div>

                    <a href="{{ route('public.ontology') }}" 
                        class="px-4 py-4 text-xs font-bold uppercase tracking-wider text-primary hover:text-accent transition-colors whitespace-nowrap">
                        Spek Ontologi
                    </a>
                    <a href="{{ route('public.semantic.index') }}" 
                        class="px-4 py-4 text-xs font-bold uppercase tracking-wider text-primary hover:text-accent transition-colors whitespace-nowrap">
                        Indeks Semantik
                    </a>
                    <a href="{{ route('public.about') }}" 
                        class="px-4 py-4 text-xs font-bold uppercase tracking-wider text-primary hover:text-accent transition-colors whitespace-nowrap">
                        Tentang
                    </a>
                </div>

                <!-- Admin Link -->
                <div class="hidden lg:flex items-center">
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-5 py-2 bg-primary text-white rounded-lg font-bold text-xs uppercase tracking-widest hover:bg-slate-800 transition-colors shadow-sm">
                            Dasbor
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-xs font-bold text-slate-600 hover:text-accent transition-colors flex items-center gap-1">
                            <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                            Masuk Admin
                        </a>
                    @endauth
                </div>
            </div>
        </nav>

        <!-- News Ticker -->
        <div class="ticker-wrap">
            <span class="ticker-title">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
                </span>
                TREN SEMANTIK
            </span>
            <div class="ticker-content">
                <div class="ticker-items">
                    @forelse($results as $r)
                        @php $rId = basename($r['id']); @endphp
                        <a href="{{ route('public.news.show', $rId) }}" class="ticker-item">
                            <span class="text-accent font-bold">#{{ $r['category'] }}</span>
                            <span class="text-white/80">•</span>
                            <span class="hover:underline">{{ $r['headline'] }}</span>
                        </a>
                    @empty
                        <div class="ticker-item">Sistem Triplestore Terkoneksi • Siap Menerima Query SPARQL</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Headline / Hero Grid (Only show when results exist) -->
        @if(count($results) > 0 && !$query && !$categoryFilter)
            <section class="max-w-7xl mx-auto px-4 py-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 border-b border-slate-200 pb-12">
                    <!-- Main Headline (Left) - 8 Cols -->
                    @php 
                        $mainHero = $results[0]; 
                        $heroId = basename($mainHero['id']);
                    @endphp
                    <div class="lg:col-span-8 flex flex-col group cursor-pointer">
                        <a href="{{ route('public.news.show', $heroId) }}" class="relative overflow-hidden rounded-2xl aspect-[16/10] bg-slate-100 border border-slate-200">
                            @if(isset($mainHero['image']) && $mainHero['image'])
                                <img src="{{ $mainHero['image'] }}" alt="{{ $mainHero['headline'] }}" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            @else
                                <div class="absolute inset-0 bg-gradient-to-br from-primary/10 via-slate-100 to-accent/5 flex items-center justify-center text-slate-300">
                                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                                </div>
                            @endif
                            <!-- Category Float Badge -->
                            <div class="absolute top-4 left-4 z-10">
                                <span class="meta-tag shadow-md bg-white/90 backdrop-blur-sm">
                                    <span class="meta-tag-key">rdf:type</span> {{ $mainHero['category'] }}
                                </span>
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent"></div>
                            
                            <!-- Overlay Headline Content -->
                            <div class="absolute bottom-0 inset-x-0 p-6 md:p-8 text-white">
                                <span class="text-xs font-black uppercase tracking-wider text-accent bg-accent-foreground px-2.5 py-1 rounded mb-4 inline-block shadow">HEADLINE UTAMA</span>
                                <h2 class="text-2xl md:text-4xl font-serif font-black leading-tight group-hover:text-accent transition-colors duration-300">
                                    {{ $mainHero['headline'] }}
                                </h2>
                                <p class="text-sm text-white/80 mt-3 font-medium line-clamp-2 md:block hidden leading-relaxed">
                                    {{ $mainHero['body'] }}
                                </p>
                                <div class="flex items-center gap-4 text-xs text-white/70 font-bold mt-4">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        {{ $mainHero['source'] }}
                                    </span>
                                    <span>•</span>
                                    <span>{{ \Carbon\Carbon::parse($mainHero['date'])->translatedFormat('d M Y H:i') }}</span>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Sub Headlines (Right) - 4 Cols -->
                    <div class="lg:col-span-4 flex flex-col justify-between gap-6">
                        <div class="border-b border-slate-100 pb-3 flex justify-between items-end">
                            <h3 class="text-xs font-black uppercase tracking-widest text-primary border-l-2 border-accent pl-2">Berita Terkini Pilihan</h3>
                            <span class="text-[10px] text-slate-400 font-bold">SPARQL Indeks</span>
                        </div>

                        <div class="flex flex-col gap-6 divide-y divide-slate-100 flex-1">
                            @php $subHeadlines = array_slice($results, 1, 3); @endphp
                            @forelse($subHeadlines as $sub)
                                @php $subId = basename($sub['id']); @endphp
                                <a href="{{ route('public.news.show', $subId) }}" class="flex items-start gap-4 pt-4 first:pt-0 group cursor-pointer">
                                    <div class="w-24 h-24 rounded-lg overflow-hidden shrink-0 bg-slate-100 border border-slate-200">
                                        @if(isset($sub['image']) && $sub['image'])
                                            <img src="{{ $sub['image'] }}" alt="{{ $sub['headline'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-[9px] font-black uppercase text-accent tracking-wider mb-1">{{ $sub['category'] }}</span>
                                        <h4 class="text-sm font-serif font-bold text-slate-900 group-hover:text-accent transition-colors line-clamp-2 leading-snug">
                                            {{ $sub['headline'] }}
                                        </h4>
                                        <span class="text-[10px] text-slate-400 font-bold mt-2">
                                            {{ \Carbon\Carbon::parse($sub['date'])->translatedFormat('d M Y') }}
                                        </span>
                                    </div>
                                </a>
                            @empty
                                <p class="text-xs text-slate-400 italic">Belum ada berita pendukung terindeks.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <!-- Main Feed & Sidebar Grid -->
        <main class="max-w-7xl mx-auto px-4 py-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                
                <!-- Left Column (Feed) - 8 Cols -->
                <section class="lg:col-span-8 space-y-8">
                    
                    <!-- Feed Header -->
                    <div class="border-b-2 border-slate-900 pb-4 flex flex-col gap-4">

                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <div>
                                @if($query)
                                    <h2 class="text-2xl font-serif font-black tracking-tight text-primary">
                                        Hasil Pencarian: <span class="text-accent italic">"{{ $query }}"</span>
                                    </h2>
                                    <p class="text-xs text-slate-500 font-medium mt-1">Ditemukan melalui Smart Search Engine (SPARQL + Fuzzy Matching)</p>
                                @elseif($categoryFilter)
                                    <h2 class="text-2xl font-serif font-black tracking-tight text-primary">
                                        Kategori: <span class="text-accent italic">{{ $categoryFilter }}</span>
                                    </h2>
                                    <p class="text-xs text-slate-500 font-medium mt-1">Menampilkan seluruh subjek di bawah konsep ontologi ini</p>
                                @else
                                    <h2 class="text-2xl font-serif font-black tracking-tight text-primary">
                                        INDEKS BERITA TERKINI
                                    </h2>
                                    <p class="text-xs text-slate-500 font-medium mt-1">Seluruh artikel yang dipetakan ke ontologi global Schema.org</p>
                                @endif
                            </div>

                            <!-- Badges: sumber data + jumlah hasil -->
                            <div class="flex items-center gap-3">
                                @if($queryInfo)
                                    @if($queryInfo['source'] === 'mysql')
                                        <span class="source-badge-mysql">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M12 3a9 9 0 100 18A9 9 0 0012 3z"/></svg>
                                            Fallback: MySQL
                                        </span>
                                    @else
                                        <span class="source-badge-sparql">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            SPARQL Engine
                                        </span>
                                    @endif
                                @endif
                                <div class="flex items-center gap-4 text-xs font-mono bg-slate-50 border border-slate-200 rounded-lg px-4 py-2">
                                    <div>
                                        <span class="text-slate-400 block text-[9px] uppercase font-sans font-bold">Ditemukan</span>
                                        <span class="font-bold text-accent">{{ count($results) }}</span>
                                    </div>
                                    <div class="w-[1px] h-6 bg-slate-200"></div>
                                    <div>
                                        <span class="text-slate-400 block text-[9px] uppercase font-sans font-bold">Triple Diproses</span>
                                        <span class="font-bold text-primary">{{ count($results) * 9 }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                    <!-- Horizontal News Feed List -->
                    <div class="flex flex-col gap-8 divide-y divide-slate-100">
                        @php 
                            // If it's a category page or search, show all. If homepage, skip the first 4 that were in the Hero Grid.
                            $feedResults = ($query || $categoryFilter) ? $results : array_slice($results, 4); 
                        @endphp
                        
                        @forelse($feedResults as $news)
                            @php $newsId = basename($news['id']); @endphp
                            <article class="flex flex-col sm:flex-row gap-6 pt-8 first:pt-0 group cursor-pointer">
                                <!-- Thumbnail Image (Left) -->
                                <div class="w-full sm:w-56 h-36 rounded-xl overflow-hidden shrink-0 bg-slate-100 border border-slate-200">
                                    <a href="{{ route('public.news.show', $newsId) }}" class="block w-full h-full">
                                        @if(isset($news['image']) && $news['image'])
                                            <img src="{{ $news['image'] }}" alt="{{ $news['headline'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                                            </div>
                                        @endif
                                    </a>
                                </div>

                                <!-- Text Metadata & Body (Right) -->
                                <div class="flex flex-col flex-1">
                                    <div class="flex flex-wrap items-center gap-3 text-xs mb-2">
                                        <span class="px-2.5 py-0.5 rounded-full text-[9px] font-black uppercase bg-slate-100 text-slate-700 border border-slate-200/60 font-sans">
                                            {{ $news['category'] }}
                                        </span>
                                        <span class="text-slate-300">•</span>
                                        <div class="flex items-center gap-1.5 text-slate-500 font-bold">
                                            <svg class="w-3.5 h-3.5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                            {{ $news['source'] }}
                                        </div>
                                        <span class="text-slate-300">•</span>
                                        <div class="flex items-center gap-1.5 text-slate-500 font-bold">
                                            <svg class="w-3.5 h-3.5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            {{ \Carbon\Carbon::parse($news['date'])->translatedFormat('d M Y') }}
                                        </div>
                                    </div>

                                    <a href="{{ route('public.news.show', $newsId) }}" class="block">
                                        <h3 class="text-xl font-serif font-bold text-slate-900 group-hover:text-accent transition-colors leading-snug line-clamp-2">
                                            @if($queryInfo && !empty($queryInfo['tokens']))
                                                {!! \App\Services\SmartSearchService::highlight($news['headline'], $queryInfo['tokens']) !!}
                                            @else
                                                {{ $news['headline'] }}
                                            @endif
                                        </h3>
                                    </a>

                                    <p class="text-sm text-slate-500 mt-2 font-medium line-clamp-2 leading-relaxed">
                                        @if($queryInfo && !empty($queryInfo['tokens']))
                                            {!! \App\Services\SmartSearchService::highlight(Str::limit($news['body'], 180), $queryInfo['tokens']) !!}
                                        @else
                                            {{ Str::limit($news['body'], 180) }}
                                        @endif
                                    </p>

                                    <!-- Semantic Metadata Tag -->
                                    <div class="mt-4 flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <span class="inline-flex items-center gap-1 rounded bg-slate-50 border border-slate-200 px-2 py-0.5 font-mono text-[9px] font-bold text-slate-500">
                                                rdf:type schema:NewsArticle
                                            </span>
                                        </div>
                                        <a href="{{ route('public.news.show', $newsId) }}" class="inline-flex items-center gap-1 text-[10px] font-black uppercase text-accent hover:gap-2 tracking-widest transition-all">
                                            Eksplorasi Triple
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @empty
                            <div class="text-center py-20 bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100 shadow-sm">
                                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                                <h3 class="text-lg font-serif font-bold text-slate-900 mb-1">Tidak Ada Data Semantik</h3>
                                <p class="text-xs text-slate-400 max-w-xs mx-auto">Tidak dapat menemukan artikel yang cocok di triplestore. Silakan lakukan sinkronisasi ulang di halaman dashboard.</p>
                            </div>
                        @endforelse
                    </div>

                </section>

                <!-- Right Column (Sidebar) - 4 Cols -->
                <aside class="lg:col-span-4 space-y-10">
                    
                    <!-- Sidebar Widget: Terpopuler -->
                    <div class="p-6 rounded-2xl bg-white border border-slate-200/80 shadow-sm space-y-6">
                        <div class="border-b border-slate-100 pb-3 flex items-center gap-2">
                            <span class="w-3 h-3 bg-accent rounded-full"></span>
                            <h3 class="font-serif font-black text-lg text-primary">Berita Terpopuler</h3>
                        </div>

                        <div class="flex flex-col gap-5">
                            @php $popularList = array_slice($results, 0, 5); @endphp
                            @forelse($popularList as $index => $pop)
                                @php $popId = basename($pop['id']); @endphp
                                <a href="{{ route('public.news.show', $popId) }}" class="flex items-start gap-4 group cursor-pointer">
                                    <span class="rank-badge group-hover:scale-105">
                                        {{ $index + 1 }}
                                    </span>
                                    <div class="flex flex-col">
                                        <span class="text-[9px] font-black uppercase text-accent tracking-wider mb-0.5">{{ $pop['category'] }}</span>
                                        <h4 class="text-sm font-serif font-bold text-slate-900 group-hover:text-accent transition-colors leading-snug line-clamp-2">
                                            {{ $pop['headline'] }}
                                        </h4>
                                    </div>
                                </a>
                            @empty
                                <p class="text-xs text-slate-400 italic">Tidak ada berita populer saat ini.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Sidebar Widget: Kognisi Mesin Semantik -->
                    <div class="p-6 rounded-2xl bg-primary text-white shadow-xl shadow-slate-950/10 space-y-6 relative overflow-hidden">
                        <!-- Decorative floating ring -->
                        <div class="absolute -right-16 -top-16 w-32 h-32 rounded-full border-4 border-white/5 pointer-events-none"></div>

                        <div class="border-b border-white/10 pb-4">
                            <h3 class="font-serif font-bold text-lg flex items-center gap-2 text-white">
                                <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                                Status Triplestore
                            </h3>
                            <p class="text-[10px] text-white/60 font-semibold uppercase tracking-widest mt-1">Eksplorasi Data Terhubung</p>
                        </div>

                        <div class="space-y-4 font-sans text-xs">
                            <div class="flex justify-between items-center py-1 border-b border-white/5">
                                <span class="text-white/70 font-semibold">Tipe Penyimpanan</span>
                                <span class="font-mono font-bold text-accent">MySQL Triple Store</span>
                            </div>
                            <div class="flex justify-between items-center py-1 border-b border-white/5">
                                <span class="text-white/70 font-semibold">Konektor Semantik</span>
                                <span class="font-mono font-bold text-white">ARC2 Core PHP Engine</span>
                            </div>
                            <div class="flex justify-between items-center py-1 border-b border-white/5">
                                <span class="text-white/70 font-semibold">Ontologi Terpasang</span>
                                <span class="font-mono font-bold text-white">Schema.org, Dublin Core</span>
                            </div>
                            <div class="flex justify-between items-center py-1">
                                <span class="text-white/70 font-semibold">Ketersediaan SPARQL</span>
                                <span class="px-2 py-0.5 bg-emerald-500 text-white rounded text-[9px] font-bold tracking-widest font-mono">ONLINE</span>
                            </div>
                        </div>

                        <div class="pt-4">
                            <a href="{{ route('public.semantic.index') }}" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-accent hover:bg-red-700 text-white font-bold text-xs uppercase tracking-widest rounded-lg shadow-md transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2z"></path></svg>
                                Indeks Pengetahuan
                            </a>
                        </div>
                    </div>

                    <!-- Sidebar Widget: Info Ontologi Schema -->
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 shadow-sm space-y-6">
                        <div class="border-b border-slate-200 pb-3">
                            <h3 class="font-serif font-black text-base text-primary">Pemetaan Schema:NewsArticle</h3>
                        </div>
                        <p class="text-xs text-slate-500 leading-relaxed font-medium">
                            Setiap berita dikonversi menjadi grafik hubungan menggunakan ontologi Schema.org sehingga dapat dipahami langsung oleh Google secara global.
                        </p>
                        <div class="p-3 bg-white rounded-xl border border-slate-200 font-mono text-[9px] text-accent font-semibold leading-relaxed">
                            :news_item rdf:type schema:NewsArticle ;<br>
                            &nbsp;&nbsp;schema:headline ?judul ;<br>
                            &nbsp;&nbsp;schema:articleBody ?konten ;<br>
                            &nbsp;&nbsp;schema:author ?sumber .
                        </div>
                        <a href="{{ route('public.ontology') }}" class="w-full inline-flex items-center justify-center gap-1.5 px-4 py-2.5 border border-slate-200 hover:bg-slate-100 font-bold text-xs uppercase tracking-widest text-slate-700 rounded-lg transition-colors">
                            Pelajari Ontologi
                        </a>
                    </div>
                </aside>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-primary text-white py-16 border-t-4 border-accent mt-20">
            <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-12">
                <!-- Branding -->
                <div class="space-y-4 md:col-span-2">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-primary font-serif font-black text-lg border-b-4 border-accent shadow">PS</div>
                        <span class="text-xl font-serif font-black tracking-tight text-white">PORTAL BERITA <span class="text-accent">SEMANTIK</span></span>
                    </div>
                    <p class="text-xs text-white/60 leading-relaxed max-w-sm">
                        Sebuah implementasi riset teknologi Web Semantik terdepan untuk menghadirkan ekstraksi, representasi, dan visualisasi pengetahuan berita terhubung berbasis Ontologi Schema.org.
                    </p>
                </div>
                
                <!-- Semantic Links -->
                <div class="space-y-4">
                    <h4 class="text-xs font-black uppercase tracking-widest text-accent">Tautan Semantik</h4>
                    <ul class="space-y-2.5 text-xs text-white/70 font-semibold">
                        <li><a href="{{ route('public.ontology') }}" class="hover:text-accent transition-colors flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-accent"></span> Spesifikasi Ontologi</a></li>
                        <li><a href="{{ route('public.semantic.index') }}" class="hover:text-accent transition-colors flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-accent"></span> Indeks Pengetahuan</a></li>
                        <li><a href="https://schema.org" target="_blank" class="hover:text-accent transition-colors flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-accent"></span> Kosakata Schema.org</a></li>
                    </ul>
                </div>
                
                <!-- Project info -->
                <div class="space-y-4">
                    <h4 class="text-xs font-black uppercase tracking-widest text-accent">Informasi Sistem</h4>
                    <p class="text-xs text-white/60 leading-relaxed font-medium">
                        &copy; {{ date('Y') }} Portal Berita Semantik. Dikembangkan menggunakan Framework Laravel 11, EasyRDF, dan database semantik ARC2.
                    </p>
                </div>
            </div>
        </footer>

        <!-- Realtime clock widget + Smart Search JS -->
        <script>
        document.addEventListener('DOMContentLoaded', function() {

            // ===================== Realtime Clock =====================
            const days   = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
            const months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
            function updateClock() {
                const now  = new Date();
                const str  = `${days[now.getDay()]}, ${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()} • ${String(now.getHours()).padStart(2,'0')}:${String(now.getMinutes()).padStart(2,'0')}:${String(now.getSeconds()).padStart(2,'0')} WIB`;
                const el   = document.getElementById('realtime-clock');
                if (el) el.textContent = str;
            }
            updateClock();
            setInterval(updateClock, 1000);

            // ===================== Autocomplete =====================
            const searchInput = document.getElementById('search-input');
            const dropdown    = document.getElementById('autocomplete-dropdown');
            const searchForm  = document.getElementById('search-form');

            if (!searchInput || !dropdown) return;

            let debounceTimer = null;
            let activeIndex   = -1;
            let currentItems  = [];

            const AUTOCOMPLETE_URL = '{{ route('search.autocomplete') }}';

            function showDropdown(items) {
                currentItems = items;
                activeIndex  = -1;

                if (!items.length) {
                    hideDropdown();
                    return;
                }

                dropdown.innerHTML = items.map((item, i) =>
                    `<div class="autocomplete-item" data-index="${i}" data-value="${escapeHtml(item)}">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <span>${escapeHtml(item)}</span>
                    </div>`
                ).join('');

                dropdown.classList.remove('hidden');

                // Klik item autocomplete
                dropdown.querySelectorAll('.autocomplete-item').forEach(el => {
                    el.addEventListener('mousedown', function(e) {
                        e.preventDefault();
                        selectItem(this.dataset.value);
                    });
                });
            }

            function hideDropdown() {
                dropdown.classList.add('hidden');
                dropdown.innerHTML = '';
                currentItems = [];
                activeIndex  = -1;
            }

            function selectItem(value) {
                searchInput.value = value;
                hideDropdown();
                searchForm.submit();
            }

            function setActive(idx) {
                const items = dropdown.querySelectorAll('.autocomplete-item');
                items.forEach(el => el.classList.remove('active'));
                if (idx >= 0 && idx < items.length) {
                    items[idx].classList.add('active');
                    searchInput.value = currentItems[idx];
                }
                activeIndex = idx;
            }

            function escapeHtml(str) {
                return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
            }

            // Input handler dengan debounce 280ms
            searchInput.addEventListener('input', function() {
                const q = this.value.trim();
                clearTimeout(debounceTimer);

                if (q.length < 2) {
                    hideDropdown();
                    return;
                }

                debounceTimer = setTimeout(() => {
                    fetch(`${AUTOCOMPLETE_URL}?q=${encodeURIComponent(q)}`)
                        .then(r => r.json())
                        .then(data => showDropdown(data))
                        .catch(() => hideDropdown());
                }, 280);
            });

            // Navigasi keyboard (↑ ↓ Enter Escape)
            searchInput.addEventListener('keydown', function(e) {
                const itemCount = currentItems.length;
                if (!itemCount) return;

                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    setActive(Math.min(activeIndex + 1, itemCount - 1));
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    setActive(Math.max(activeIndex - 1, -1));
                } else if (e.key === 'Enter' && activeIndex >= 0) {
                    e.preventDefault();
                    selectItem(currentItems[activeIndex]);
                } else if (e.key === 'Escape') {
                    hideDropdown();
                }
            });

            // Tutup dropdown saat klik di luar
            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target) && !dropdown.contains(e.target)) {
                    hideDropdown();
                }
            });

        });
        </script>
    </body>
</html>
