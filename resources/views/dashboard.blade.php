<x-admin-layout>
    <x-slot name="header">
        Ikhtisar Sistem
    </x-slot>

    <div class="space-y-8">
        <!-- Welcome Banner -->
        <div class="relative p-10 rounded-[2rem] bg-primary text-primary-foreground overflow-hidden shadow-2xl shadow-primary/20">
            <div class="absolute right-0 top-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/3 blur-3xl"></div>
            <div class="relative z-10">
                <h2 class="text-3xl font-serif font-bold mb-2">Selamat datang kembali, {{ Auth::user()->name }}</h2>
                <p class="text-primary-foreground/70 max-w-md leading-relaxed">
                    Sistem manajemen berita semantik Anda siap digunakan. Anda telah mengindeks total {{ $stats['total_articles'] }} berita hari ini.
                </p>
                <div class="mt-8 flex gap-4">
                    <a href="{{ route('news.create') }}" class="px-6 py-2.5 bg-background text-primary rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-primary-soft transition-colors shadow-lg">
                        + Artikel Baru
                    </a>
                    <a href="{{ route('news.sparql') }}" class="px-6 py-2.5 bg-primary-hover text-white rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-white/10 transition-colors">
                        Lihat Graf
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- Articles Card --}}
            <div class="p-8 rounded-[2rem] bg-background border border-border shadow-sm hover:border-primary/20 transition-all group">
                <div class="flex items-center justify-between mb-6">
                    <div class="w-12 h-12 bg-secondary/50 rounded-2xl flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 2v4h4"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 9h10M7 13h10M7 17h10"></path></svg>
                    </div>
                    <span class="text-[10px] font-bold text-muted-foreground uppercase tracking-widest">Artikel</span>
                </div>
                <div class="text-4xl font-serif font-bold text-foreground mb-1">{{ $stats['total_articles'] }}</div>
                <div class="text-xs font-medium text-muted-foreground">Terindeks di DB relasional</div>
            </div>

            {{-- Triples Card --}}
            <div class="p-8 rounded-[2rem] bg-background border border-border shadow-sm hover:border-primary/20 transition-all group">
                <div class="flex items-center justify-between mb-6">
                    <div class="w-12 h-12 bg-primary-soft rounded-2xl flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <span class="text-[10px] font-bold text-muted-foreground uppercase tracking-widest">Triple</span>
                </div>
                <div class="text-4xl font-serif font-bold text-foreground mb-1">{{ $stats['total_triples'] }}</div>
                <div class="text-xs font-medium text-muted-foreground">Disimpan di triplestore persisten</div>
            </div>

            {{-- Categories Card --}}
            <div class="p-8 rounded-[2rem] bg-background border border-border shadow-sm hover:border-primary/20 transition-all group">
                <div class="flex items-center justify-between mb-6">
                    <div class="w-12 h-12 bg-secondary/50 rounded-2xl flex items-center justify-center text-foreground group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    </div>
                    <span class="text-[10px] font-bold text-muted-foreground uppercase tracking-widest">Node</span>
                </div>
                <div class="text-4xl font-serif font-bold text-foreground mb-1">{{ $stats['categories'] }}</div>
                <div class="text-xs font-medium text-muted-foreground">Kelas ontologi unik</div>
            </div>
        </div>

        <!-- System Alerts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="p-8 rounded-[2rem] bg-secondary/20 border border-border">
                <h4 class="text-lg font-serif font-bold mb-4">Kesehatan Semantik</h4>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-background rounded-xl border border-border">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 rounded-full bg-green-500"></div>
                            <span class="text-sm font-medium">Koneksi ARC2 Triplestore</span>
                        </div>
                        <span class="text-[10px] font-bold text-muted-foreground uppercase">Stabil</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-background rounded-xl border border-border">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 rounded-full bg-green-500"></div>
                            <span class="text-sm font-medium">Pemetaan Schema.org</span>
                        </div>
                        <span class="text-[10px] font-bold text-muted-foreground uppercase">Aktif</span>
                    </div>
                </div>
            </div>
            
            <div class="p-8 rounded-[2rem] bg-background border border-border shadow-sm">
                <h4 class="text-lg font-serif font-bold mb-4">Aktivitas Pengindeksan Terkini</h4>
                <div class="space-y-4">
                    @forelse($recentActivities as $activity)
                        <div class="flex items-center justify-between p-4 bg-secondary/10 rounded-xl border border-border group hover:border-primary/30 transition-all">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-foreground line-clamp-1">{{ $activity->title }}</span>
                                <span class="text-[10px] text-muted-foreground uppercase font-bold tracking-tight">{{ $activity->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-[10px] font-bold text-primary bg-primary/10 px-2 py-1 rounded">TERINDEKS</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <p class="text-sm text-muted-foreground italic">Belum ada aktivitas pengindeksan baru.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
