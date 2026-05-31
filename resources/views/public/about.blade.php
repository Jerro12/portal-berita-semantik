<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Tentang Aplikasi - Portal Berita Semantik</title>
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
                    <span class="text-slate-900 font-bold uppercase tracking-wider">Tentang Aplikasi</span>
                </div>

                <div class="flex items-center gap-4">
                    <a href="{{ route('home') }}" class="text-xs font-bold text-slate-600 hover:text-accent flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali
                    </a>
                </div>
            </div>
        </nav>

        <main class="max-w-4xl mx-auto px-4 py-16">
            <div class="space-y-16">
                <!-- Hero About -->
                <section class="text-center space-y-6">
                    <div class="inline-flex px-3 py-1 bg-accent/5 border border-accent/20 rounded-full text-xs font-black uppercase text-accent tracking-widest mx-auto">
                        Dokumentasi Riset Skripsi
                    </div>
                    <h1 class="text-3xl md:text-5xl font-serif font-black text-slate-900 leading-tight">
                        Membangun Jembatan Antara <br/> 
                        <span class="text-accent italic">Berita & Pengetahuan Semantik</span>
                    </h1>
                    <p class="text-sm md:text-base text-slate-500 max-w-2xl mx-auto font-medium leading-relaxed">
                        Portal Berita Semantik adalah wujud implementasi mutakhir teknologi Web Semantik untuk ekstraksi, pemetaan, dan visualisasi data terhubung dari artikel berita digital.
                    </p>
                </section>

                <!-- Core Pillars -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Column 1 -->
                    <div class="p-8 bg-slate-50 border border-slate-200 rounded-2xl space-y-4 group hover:bg-primary transition-all duration-300">
                        <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center border border-slate-200 shadow-sm group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <h3 class="text-xl font-serif font-bold text-slate-900 group-hover:text-white transition-colors">Ekstraksi RDF</h3>
                        <p class="text-xs text-slate-500 group-hover:text-slate-300 leading-relaxed font-medium transition-colors">
                            Setiap berita dikonversi secara real-time menjadi pasangan Triple RDF (Subjek, Predikat, Objek) untuk memetakan hubungan logis data.
                        </p>
                    </div>

                    <!-- Column 2 -->
                    <div class="p-8 bg-slate-50 border border-slate-200 rounded-2xl space-y-4 group hover:bg-primary transition-all duration-300">
                        <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center border border-slate-200 shadow-sm group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <h3 class="text-xl font-serif font-bold text-slate-900 group-hover:text-white transition-colors">Ontologi Terstruktur</h3>
                        <p class="text-xs text-slate-500 group-hover:text-slate-300 leading-relaxed font-medium transition-colors">
                            Mengadopsi skema global dari <strong>Schema.org</strong> sehingga struktur data dipahami secara universal oleh mesin pencarian modern.
                        </p>
                    </div>
                </div>

                <!-- Technical Details -->
                <section class="bg-primary text-white rounded-2xl p-8 md:p-12 relative overflow-hidden shadow-xl shadow-slate-950/10">
                    <div class="absolute top-0 right-0 w-48 h-48 rounded-full bg-white/5 -translate-y-1/3 translate-x-1/3 pointer-events-none"></div>
                    
                    <div class="relative z-10 space-y-8">
                        <div class="space-y-2">
                            <h2 class="text-2xl md:text-3xl font-serif font-black text-white">Arsitektur & Teknologi Sistem</h2>
                            <p class="text-xs text-slate-300 font-bold uppercase tracking-widest">Kombinasi Database Relasional & Database Semantik</p>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-xs">
                            <div class="space-y-1">
                                <div class="font-bold text-accent uppercase tracking-widest text-[9px]">Framework Backend</div>
                                <div class="text-sm font-bold text-white">Laravel 11 (PHP 8.2)</div>
                            </div>
                            <div class="space-y-1">
                                <div class="font-bold text-accent uppercase tracking-widest text-[9px]">Triplestore Database</div>
                                <div class="text-sm font-bold text-white">ARC2 RDF Database Store</div>
                            </div>
                            <div class="space-y-1">
                                <div class="font-bold text-accent uppercase tracking-widest text-[9px]">RDF Converter</div>
                                <div class="text-sm font-bold text-white">EasyRDF Library PHP</div>
                            </div>
                            <div class="space-y-1">
                                <div class="font-bold text-accent uppercase tracking-widest text-[9px]">Sistem Styling</div>
                                <div class="text-sm font-bold text-white">Tailwind CSS (Vite Bundler)</div>
                            </div>
                        </div>
                    </div>
                </section>
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
