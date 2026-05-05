<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Tentang Aplikasi - NewsHub Semantic</title>
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
                    <a href="{{ route('public.semantic.index') }}" class="text-xs font-bold text-muted-foreground hover:text-primary uppercase tracking-widest transition-colors">Indeks Semantik</a>
                    <a href="{{ route('public.about') }}" class="text-xs font-bold text-primary uppercase tracking-widest transition-colors">Tentang</a>
                    <div class="h-4 w-[1px] bg-border mx-2"></div>
                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-secondary text-primary rounded-lg font-bold text-xs uppercase tracking-widest hover:bg-primary-soft transition-colors">Dasbor</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-muted-foreground hover:text-primary transition-colors">Login Admin</a>
                    @endauth
                </div>
            </div>
        </nav>

        <main class="max-w-4xl mx-auto px-4 py-20">
            <div class="space-y-20">
                <!-- Hero About -->
                <section class="text-center space-y-6">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/5 border border-primary/10 text-primary text-[10px] font-bold uppercase tracking-widest mx-auto">
                        Dokumentasi Sistem
                    </div>
                    <h1 class="text-5xl font-serif font-bold text-foreground leading-tight">Membangun Jembatan Antara <br/> <span class="text-primary italic">Berita & Pengetahuan</span></h1>
                    <p class="text-lg text-muted-foreground max-w-2xl mx-auto leading-relaxed">
                        NewsHub Semantic Portal adalah implementasi teknologi Web Semantik untuk ekstraksi, representasi, dan visualisasi pengetahuan dari artikel berita digital.
                    </p>
                </section>

                <!-- Core Pillars -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="p-10 bg-secondary/20 rounded-[2.5rem] border border-border group hover:bg-primary transition-all duration-500">
                        <div class="w-14 h-14 bg-background rounded-2xl flex items-center justify-center mb-8 shadow-sm group-hover:scale-110 transition-transform">
                            <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-serif font-bold mb-4 group-hover:text-white transition-colors">Ekstraksi RDF</h3>
                        <p class="text-muted-foreground leading-relaxed group-hover:text-white/70 transition-colors">
                            Setiap berita dikonversi menjadi triple (Subjek, Predikat, Objek) menggunakan standar RDF untuk menciptakan jaringan data yang terhubung.
                        </p>
                    </div>

                    <div class="p-10 bg-secondary/20 rounded-[2.5rem] border border-border group hover:bg-primary transition-all duration-500">
                        <div class="w-14 h-14 bg-background rounded-2xl flex items-center justify-center mb-8 shadow-sm group-hover:scale-110 transition-transform">
                            <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-serif font-bold mb-4 group-hover:text-white transition-colors">Ontologi Terstruktur</h3>
                        <p class="text-muted-foreground leading-relaxed group-hover:text-white/70 transition-colors">
                            Mengadopsi kosakata <strong>Schema.org</strong> untuk memastikan data yang dihasilkan dapat dipahami oleh mesin pencari seperti Google secara universal.
                        </p>
                    </div>
                </div>

                <!-- Technical Details -->
                <section class="bg-[#172A39] text-white rounded-[3rem] p-12 overflow-hidden relative">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-primary/20 rounded-full blur-[100px] -translate-y-1/2 translate-x-1/2"></div>
                    <div class="relative z-10 space-y-8">
                        <div class="space-y-4">
                            <h2 class="text-3xl font-serif font-bold">Teknologi yang Digunakan</h2>
                            <p class="text-white/60">Arsitektur modern yang menggabungkan Framework Relasional dengan Mesin Semantik.</p>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                            <div class="space-y-2">
                                <div class="text-xs font-bold text-accent uppercase tracking-widest">Backend</div>
                                <div class="text-lg font-bold">Laravel 11</div>
                            </div>
                            <div class="space-y-2">
                                <div class="text-xs font-bold text-accent uppercase tracking-widest">Triplestore</div>
                                <div class="text-lg font-bold">ARC2 RDF Store</div>
                            </div>
                            <div class="space-y-2">
                                <div class="text-xs font-bold text-accent uppercase tracking-widest">UI Framework</div>
                                <div class="text-lg font-bold">Tailwind CSS</div>
                            </div>
                            <div class="space-y-2">
                                <div class="text-xs font-bold text-accent uppercase tracking-widest">Data Format</div>
                                <div class="text-lg font-bold">JSON-LD & Turtle</div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Why Semantic? -->
                <section class="space-y-8">
                    <h2 class="text-3xl font-serif font-bold text-center">Mengapa Harus Semantik?</h2>
                    <div class="space-y-6">
                        <div class="flex gap-6 p-6 rounded-2xl hover:bg-secondary/10 transition-colors">
                            <div class="text-2xl font-serif font-bold text-primary">01.</div>
                            <div class="space-y-2">
                                <h4 class="text-xl font-bold">Interoperabilitas Data</h4>
                                <p class="text-muted-foreground leading-relaxed text-sm">Data tidak lagi terkunci dalam database terisolasi, melainkan menjadi bagian dari Linked Open Data yang bisa diintegrasikan dengan aplikasi lain.</p>
                            </div>
                        </div>
                        <div class="flex gap-6 p-6 rounded-2xl hover:bg-secondary/10 transition-colors">
                            <div class="text-2xl font-serif font-bold text-primary">02.</div>
                            <div class="space-y-2">
                                <h4 class="text-xl font-bold">Pencarian Cerdas</h4>
                                <p class="text-muted-foreground leading-relaxed text-sm">Mesin pencari dapat memahami relasi antar aktor, lokasi, dan peristiwa dalam berita melalui query SPARQL yang presisi.</p>
                            </div>
                        </div>
                        <div class="flex gap-6 p-6 rounded-2xl hover:bg-secondary/10 transition-colors">
                            <div class="text-2xl font-serif font-bold text-primary">03.</div>
                            <div class="space-y-2">
                                <h4 class="text-xl font-bold">Optimasi SEO</h4>
                                <p class="text-muted-foreground leading-relaxed text-sm">Dengan JSON-LD, artikel berita akan mendapatkan Rich Snippets pada hasil pencarian, meningkatkan visibilitas dan klik secara organik.</p>
                            </div>
                        </div>
                    </div>
                </section>
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
