<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Spesifikasi Ontologi - Portal Berita Semantik</title>
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
                    <span class="text-slate-900 font-bold uppercase tracking-wider">Spesifikasi Ontologi</span>
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
            <div class="space-y-12">
                <header class="text-center space-y-4">
                    <div class="inline-flex px-3 py-1 bg-accent/5 border border-accent/20 rounded-full text-xs font-black uppercase text-accent tracking-widest mx-auto">
                        Skema Representasi Pengetahuan
                    </div>
                    <h1 class="text-3xl md:text-5xl font-serif font-black text-slate-900 leading-tight">Spesifikasi Ontologi Portal</h1>
                    <p class="text-sm md:text-base text-slate-500 max-w-2xl mx-auto font-medium leading-relaxed">
                        Aplikasi ini menggunakan kosakata standar internasional untuk menjamin interoperabilitas semantik dan keterhubungan grafik pengetahuan di internet global.
                    </p>
                </header>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Schema.org Card -->
                    <div class="p-8 bg-slate-50 border border-slate-200 rounded-2xl shadow-sm space-y-4">
                        <div class="w-12 h-12 bg-primary text-white rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <h2 class="text-xl font-serif font-bold text-slate-900">Kosakata Standar: Schema.org</h2>
                        <p class="text-xs text-slate-500 leading-relaxed font-medium">
                            Schema.org dipromosikan bersama oleh Google, Microsoft, Yahoo, dan Yandex untuk menyepakati struktur metadata agar situs web mudah dipahami secara cerdas oleh crawler pencari.
                        </p>
                        <a href="https://schema.org" target="_blank" class="inline-flex items-center gap-1 text-xs font-black uppercase text-accent hover:underline">
                            Kunjungi Schema.org
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        </a>
                    </div>

                    <!-- NewsArticle Card -->
                    <div class="p-8 bg-slate-50 border border-slate-200 rounded-2xl shadow-sm space-y-4">
                        <div class="w-12 h-12 bg-primary text-white rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <h2 class="text-xl font-serif font-bold text-slate-900">Kelas Utama: NewsArticle</h2>
                        <p class="text-xs text-slate-500 leading-relaxed font-medium">
                            Sebuah sub-tipe dari <strong>Article</strong> dan <strong>CreativeWork</strong> yang secara spesifik dirancang untuk merepresentasikan berita digital dengan properti lengkap.
                        </p>
                        <span class="inline-flex px-3 py-1 bg-slate-200 text-slate-700 border border-slate-300 rounded text-[10px] font-mono font-bold">schema:NewsArticle</span>
                    </div>
                </div>

                <!-- Table Area -->
                <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
                    <div class="p-6 bg-slate-50 border-b border-slate-200">
                        <h3 class="font-serif font-bold text-lg text-primary">Properti Kelas yang Dipetakan</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-100/80">
                                    <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">Properti (SPO)</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">Tipe Data</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">Deskripsi Semantik</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-600">
                                <tr>
                                    <td class="px-6 py-4 font-mono text-accent">schema:headline</td>
                                    <td class="px-6 py-4 font-mono">Teks (Literal)</td>
                                    <td class="px-6 py-4 text-slate-500">Judul berita yang mendeskripsikan ringkasan artikel.</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 font-mono text-accent">schema:articleBody</td>
                                    <td class="px-6 py-4 font-mono">Teks (Literal)</td>
                                    <td class="px-6 py-4 text-slate-500">Konten tulisan atau tubuh berita secara komprehensif.</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 font-mono text-accent">schema:datePublished</td>
                                    <td class="px-6 py-4 font-mono">DateTime (Literal)</td>
                                    <td class="px-6 py-4 text-slate-500">Tanggal dan waktu artikel berita dipublikasikan ke publik.</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 font-mono text-accent">schema:articleSection</td>
                                    <td class="px-6 py-4 font-mono">Teks (Literal)</td>
                                    <td class="px-6 py-4 text-slate-500">Kategori atau rubrik berita (seperti Politik, Ekonomi, dll).</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 font-mono text-accent">schema:author</td>
                                    <td class="px-6 py-4 font-mono">Person / Org</td>
                                    <td class="px-6 py-4 text-slate-500">Pihak/institusi yang mempublikasikan atau menulis berita.</td>
                                </tr>
                            </tbody>
                        </table>
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
