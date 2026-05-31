<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Indeks Semantik - Portal Berita Semantik</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;0,800;1,600&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
                    <span class="text-slate-900 font-bold uppercase tracking-wider">Indeks Semantik</span>
                </div>

                <div class="flex items-center gap-4">
                    <a href="{{ route('home') }}" class="text-xs font-bold text-slate-600 hover:text-accent flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali
                    </a>
                </div>
            </div>
        </nav>

        <main class="max-w-5xl mx-auto px-4 py-16">
            <div class="space-y-12">
                <header class="text-center space-y-4">
                    <div class="inline-flex px-3 py-1 bg-accent/5 border border-accent/20 rounded-full text-xs font-black uppercase text-accent tracking-widest mx-auto">
                        Statistik Mesin Pengetahuan
                    </div>
                    <h1 class="text-3xl md:text-5xl font-serif font-black text-slate-900 leading-tight">Indeks Pengetahuan Semantik</h1>
                    <p class="text-sm md:text-base text-slate-500 max-w-2xl mx-auto font-medium leading-relaxed">
                        Statistik waktu nyata dan analisis distribusi relasi subjek-predikat-objek dalam triplestore persisten.
                    </p>
                </header>

                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Total Triples -->
                    <div class="p-8 bg-primary text-white rounded-2xl shadow-lg shadow-slate-950/10 flex flex-col items-center text-center relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-24 h-24 rounded-full bg-white/5 -translate-y-1/3 translate-x-1/3 pointer-events-none"></div>
                        <div class="text-5xl font-serif font-black text-accent mb-2">{{ number_format($totalTriples) }}</div>
                        <div class="text-[10px] font-black uppercase tracking-widest text-slate-300">Total Triple Hubungan</div>
                    </div>
                    
                    <!-- Predicates Count -->
                    <div class="p-8 bg-slate-50 border border-slate-200 rounded-2xl shadow-sm flex flex-col items-center text-center">
                        <div class="text-5xl font-serif font-black text-primary mb-2">{{ count($predicates) }}</div>
                        <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">Predikat Ontologi Aktif</div>
                    </div>

                    <!-- Indexed Articles -->
                    <div class="p-8 bg-slate-50 border border-slate-200 rounded-2xl shadow-sm flex flex-col items-center text-center">
                        <div class="text-5xl font-serif font-black text-primary mb-2">{{ \App\Models\News::count() }}</div>
                        <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">Artikel Berita Terindeks</div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                    <!-- Predicate Distribution (Left) - 7 Cols -->
                    <div class="lg:col-span-7 bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
                        <div class="p-6 bg-slate-50 border-b border-slate-200">
                            <h3 class="font-serif font-bold text-lg text-primary">Distribusi Penggunaan Predikat</h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-6">
                                @forelse($predicates as $row)
                                    @php
                                        $pred = str_replace(
                                            ['https://schema.org/', 'http://www.w3.org/1999/02/22-rdf-syntax-ns#'], 
                                            ['schema:', 'rdf:'], 
                                            $row['p']
                                        );
                                        $maxVal = max(array_column($predicates, 'count')) ?: 1;
                                        $percent = ($row['count'] / $maxVal) * 100;
                                    @endphp
                                    <div class="space-y-2">
                                        <div class="flex justify-between items-end">
                                            <span class="text-xs font-mono font-bold text-primary">{{ $pred }}</span>
                                            <span class="text-[10px] font-bold text-accent">{{ $row['count'] }} triple</span>
                                        </div>
                                        <div class="w-full h-2.5 bg-slate-100 rounded-full overflow-hidden border border-slate-200">
                                            <div class="h-full bg-accent rounded-full" style="width: {{ $percent }}%"></div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-xs text-slate-400 italic text-center py-8">Belum ada predikat yang terpetakan.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Ontology Map Info (Right) - 5 Cols -->
                    <div class="lg:col-span-5 space-y-6">
                        <div class="p-8 bg-slate-50 border border-slate-200 rounded-2xl shadow-sm">
                            <h3 class="font-serif font-bold text-xl text-primary mb-4">Arsitektur Graf Pengetahuan</h3>
                            <p class="text-xs text-slate-500 leading-relaxed font-medium mb-6">
                                Setiap berita secara otomatis dipetakan ke format semantik <strong>Resource Description Framework (RDF)</strong> dengan URI sebagai pengenal utama.
                            </p>
                            <div class="p-4 bg-white rounded-xl border border-slate-200 font-mono text-[10px] text-accent leading-relaxed font-semibold">
                                &lt;{{ url('/ns/news/{id}') }}&gt;<br>
                                &nbsp;&nbsp;rdf:type schema:NewsArticle ;<br>
                                &nbsp;&nbsp;schema:headline ?headline .
                            </div>
                        </div>

                        <div class="p-8 border border-accent/20 bg-accent/5 rounded-2xl">
                            <h3 class="font-serif font-bold text-lg text-accent mb-3">Linked Open Data</h3>
                            <p class="text-xs text-slate-600 leading-relaxed font-medium">
                                Melalui format Turtle (.ttl) dan struktur JSON-LD yang tertanam, portal berita Anda secara instan terhubung dengan ekosistem data terbuka global yang dapat diakses oleh mesin pencari global.
                            </p>
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
                    <h4 class="text-xs font-black uppercase tracking-widest text-accent">Info Proyek</h4>
                    <p class="text-xs text-white/60 leading-relaxed font-semibold">&copy; {{ date('Y') }} Portal Berita Semantik. Dikembangkan dengan Laravel & ARC2.</p>
                </div>
            </div>
        </footer>
    </body>
</html>
