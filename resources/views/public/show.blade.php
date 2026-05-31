<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $news->title }} - Portal Berita Semantik</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;0,800;1,600&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        
        <!-- JSON-LD Semantic Metadata -->
        <script type="application/ld+json">
        {!! json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
        </script>
        <style>
            .drop-cap::first-letter {
                font-family: 'Playfair Display', Georgia, serif;
                font-size: 4.5rem;
                font-weight: 900;
                line-height: 0.8;
                float: left;
                margin-right: 0.5rem;
                margin-top: 0.5rem;
                color: hsl(var(--accent));
            }
        </style>
    </head>
    <body class="antialiased bg-white text-slate-900 selection:bg-accent selection:text-white">
        
        <!-- Header / Logo Area -->
        <header class="border-b border-slate-100 bg-white">
            <div class="max-w-6xl mx-auto px-4 py-5 flex justify-between items-center">
                <a href="/" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center shadow shadow-slate-200 overflow-hidden relative border border-slate-200">
                        <span class="text-white font-serif font-black text-lg">PS</span>
                        <div class="absolute bottom-0 inset-x-0 h-0.5 bg-accent"></div>
                    </div>
                    <div>
                        <h2 class="text-xl md:text-2xl font-serif font-black tracking-tight leading-none text-primary">
                            PORTAL BERITA <span class="text-accent">SEMANTIK</span>
                        </h2>
                    </div>
                </a>

                <div class="flex items-center gap-4">
                    <a href="/" class="text-xs font-bold text-slate-600 hover:text-accent transition-colors flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Beranda
                    </a>
                </div>
            </div>
        </header>

        <!-- Navbar Navigation -->
        <nav class="sticky top-0 z-50 border-b border-slate-200 bg-white/95 backdrop-blur-md shadow-sm">
            <div class="max-w-6xl mx-auto px-4 flex justify-between items-center py-3">
                <div class="flex items-center gap-4 text-xs font-semibold text-slate-500">
                    <a href="/" class="hover:text-accent">Beranda</a>
                    <span>/</span>
                    <span class="text-slate-900 font-bold uppercase tracking-wider">{{ $news->category }}</span>
                </div>

                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ route('news.index') }}" class="text-xs font-bold text-slate-600 hover:text-accent flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Panel Admin
                        </a>
                    @endauth
                    <a href="{{ route('home') }}" class="text-xs font-bold text-slate-600 hover:text-accent flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali
                    </a>
                </div>
            </div>
        </nav>

        <main class="max-w-6xl mx-auto px-4 py-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                
                <!-- Left Section (News Content) - 8 Cols -->
                <div class="lg:col-span-8 space-y-6">
                    <!-- Title Area -->
                    <div class="space-y-4">
                        <span class="inline-flex px-3 py-1 bg-accent/5 border border-accent/20 rounded-full text-xs font-black uppercase text-accent tracking-widest">
                            {{ $news->category }}
                        </span>
                        
                        <h1 class="text-3xl md:text-5xl font-serif font-black text-slate-900 leading-tight">
                            {{ $news->title }}
                        </h1>

                        <!-- Author and Date Row -->
                        <div class="flex flex-wrap items-center gap-4 text-xs font-bold text-slate-500 border-y border-slate-100 py-3.5">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-slate-100 text-slate-700 flex items-center justify-center font-bold text-xs uppercase shadow-sm">
                                    {{ substr($news->source ?? 'AD', 0, 2) }}
                                </div>
                                <span class="text-slate-800">{{ $news->source ?? 'Admin' }}</span>
                            </div>
                            <span class="text-slate-300">•</span>
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $news->published_at->translatedFormat('d F Y • H:i') }} WIB
                            </div>
                        </div>
                    </div>

                    <!-- Article Main Image -->
                    @if($news->image)
                        <div class="rounded-2xl overflow-hidden border border-slate-200/80 shadow-md">
                            <img src="{{ $news->image }}" alt="{{ $news->title }}" class="w-full h-auto object-cover max-h-[480px]">
                        </div>
                    @endif

                    <!-- Article Body text -->
                    <div class="prose prose-lg max-w-none text-slate-800 leading-relaxed font-sans drop-cap text-base md:text-lg font-medium space-y-6">
                        {!! nl2br(e($news->content)) !!}
                    </div>
                </div>

                <!-- Right Section (Semantic Sidebar) - 4 Cols -->
                <div class="lg:col-span-4 space-y-8">
                    <div class="sticky top-24 space-y-8">
                        
                        <!-- Triple Inspector Card -->
                        <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 shadow-sm space-y-6">
                            <div class="flex items-center gap-3 border-b border-slate-200/60 pb-4">
                                <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center text-white shadow">
                                    <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                </div>
                                <div>
                                    <h3 class="font-serif font-black text-lg text-primary">Inspektur Triple</h3>
                                    <p class="text-[9px] font-black uppercase text-accent tracking-widest mt-0.5">Pengetahuan Terhubung</p>
                                </div>
                            </div>
                            
                            <p class="text-xs text-slate-500 leading-relaxed font-medium">
                                Data di bawah merupakan representasi pengetahuan semantik (Triple RDF) yang diekstrak menggunakan query SPARQL.
                            </p>

                            <!-- Triples Feed -->
                            <div class="flex flex-col gap-3">
                                @forelse($triples as $triple)
                                    @php
                                        $pred = str_replace(
                                            ['https://schema.org/', 'http://www.w3.org/1999/02/22-rdf-syntax-ns#'], 
                                            ['schema:', 'rdf:'], 
                                            $triple['p'] ?? ''
                                        );
                                    @endphp
                                    <div class="p-3 bg-white rounded-xl border border-slate-200/80 hover:border-accent/40 transition-colors shadow-sm">
                                        <span class="text-[9px] font-bold text-accent uppercase font-mono block tracking-wider mb-1">
                                            {{ $pred }}
                                        </span>
                                        <div class="text-xs font-semibold text-slate-800 break-words leading-relaxed font-sans">
                                            {{ $triple['o'] ?? '' }}
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-4 text-center bg-white rounded-xl border border-slate-200/60 italic text-slate-400 text-xs">
                                        Tidak ada triple terdaftar di RDF store.
                                    </div>
                                @endforelse
                            </div>

                            <!-- Metrics and Export -->
                            <div class="pt-6 border-t border-slate-200/60 space-y-4">
                                <div class="flex justify-between items-center text-xs font-semibold text-slate-600">
                                    <span>Total Hubungan RDF</span>
                                    <span class="px-2 py-0.5 bg-primary text-white rounded font-mono font-bold">{{ count($triples) }}</span>
                                </div>
                                
                                <a href="{{ route('public.news.export', $news->id) }}" class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-primary hover:bg-slate-800 text-white font-bold text-xs uppercase tracking-widest rounded-xl transition-all shadow-md">
                                    <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    Unduh RDF Turtle (.ttl)
                                </a>
                            </div>
                        </div>

                        <!-- Sidebar Widget: Google Snippet Preview -->
                        <div class="p-6 rounded-2xl bg-white border border-slate-200 shadow-sm space-y-4">
                            <div class="border-b border-slate-100 pb-3">
                                <h4 class="font-serif font-black text-sm text-primary">Simulasi Google Rich Snippet</h4>
                            </div>
                            <div class="space-y-1 text-xs">
                                <div class="text-slate-400 text-[10px] tracking-tight">portal-berita-semantik.com &gt; news &gt; {{ $news->id }}</div>
                                <div class="text-sky-800 hover:underline font-bold text-sm leading-snug cursor-pointer">{{ $news->title }}</div>
                                <div class="text-slate-500 line-clamp-2 leading-relaxed">
                                    {{ \Carbon\Carbon::parse($news->published_at)->translatedFormat('d M Y') }} — {{ $news->content }}
                                </div>
                                <div class="flex gap-4 text-[10px] text-slate-400 pt-2 font-semibold">
                                    <span>Kategori: <strong class="text-slate-600">{{ $news->category }}</strong></span>
                                    <span>Penulis: <strong class="text-slate-600">{{ $news->source }}</strong></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-primary text-white py-16 border-t-4 border-accent mt-20">
            <div class="max-w-6xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-12 text-center md:text-left">
                <div class="space-y-4">
                    <div class="flex items-center justify-center md:justify-start gap-2">
                        <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center text-primary font-serif font-black text-base shadow border-b-2 border-accent">PS</div>
                        <span class="text-base font-serif font-black tracking-tight">PORTAL BERITA <span class="text-accent">SEMANTIK</span></span>
                    </div>
                    <p class="text-xs text-white/60 leading-relaxed">Penerapan teknologi Web Semantik untuk ekstraksi dan kurasi berita cerdas berbasis Ontologi Schema.org.</p>
                </div>
                <div class="space-y-4">
                    <h4 class="text-xs font-black uppercase tracking-widest text-accent">Tautan Cepat</h4>
                    <ul class="space-y-2 text-xs text-white/70 font-semibold">
                        <li><a href="{{ route('public.ontology') }}" class="hover:text-accent transition-colors">Spesifikasi Ontologi</a></li>
                        <li><a href="{{ route('public.semantic.index') }}" class="hover:text-accent transition-colors">Indeks Semantik</a></li>
                        <li><a href="https://schema.org" target="_blank" class="hover:text-accent transition-colors">Kosakata Schema.org</a></li>
                    </ul>
                </div>
                <div class="space-y-4">
                    <h4 class="text-xs font-black uppercase tracking-widest text-accent">Info Sistem</h4>
                    <p class="text-xs text-white/60 leading-relaxed font-semibold">&copy; {{ date('Y') }} Portal Berita Semantik. Dikembangkan dengan Laravel & ARC2.</p>
                </div>
            </div>
        </footer>

    </body>
</html>
