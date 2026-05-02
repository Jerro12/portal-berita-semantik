@props(['news'])

@php
    $newsId = basename($news['id']);
@endphp
<article class="group relative flex flex-col bg-background border border-border rounded-2xl overflow-hidden hover:shadow-2xl hover:shadow-primary/5 transition-all duration-500 hover:-translate-y-1">
    {{-- Card Image Placeholder with Gradient --}}
    <div class="aspect-[16/9] w-full bg-secondary/50 relative overflow-hidden">
        <a href="{{ route('public.news.show', $newsId) }}">
            @if(isset($news['image']) && $news['image'])
                <img src="{{ $news['image'] }}" alt="{{ $news['headline'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
            @else
                <div class="absolute inset-0 bg-gradient-to-br from-primary/10 to-transparent"></div>
            @endif
        </a>
        <div class="absolute top-4 left-4">
            <span class="meta-tag shadow-sm backdrop-blur-md bg-white/80">
                <span class="meta-tag-key">rdf:type</span> {{ $news['category'] }}
            </span>
        </div>
    </div>

    <div class="p-6 flex flex-col flex-1">
        <div class="flex items-center gap-3 mb-4">
            <div class="flex items-center gap-1.5 text-[11px] font-bold text-muted-foreground uppercase tracking-widest">
                <svg class="w-3.5 h-3.5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                {{ $news['source'] }}
            </div>
            <span class="text-border">•</span>
            <div class="flex items-center gap-1.5 text-[11px] font-bold text-muted-foreground uppercase tracking-widest">
                <svg class="w-3.5 h-3.5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                {{ \Carbon\Carbon::parse($news['date'])->translatedFormat('d M Y') }}
            </div>
        </div>

        <a href="{{ route('public.news.show', $newsId) }}">
            <h3 class="text-xl font-serif font-bold text-foreground mb-3 group-hover:text-primary transition-colors leading-snug">
                {{ $news['headline'] }}
            </h3>
        </a>
        
        <p class="text-muted-foreground text-sm leading-relaxed mb-6 line-clamp-3">
            {{ $news['body'] }}
        </p>

        <div class="mt-auto pt-6 border-t border-border flex items-center justify-between">
            <div class="flex gap-2">
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-mono bg-secondary text-primary/70 border border-border">
                    #semantic
                </span>
            </div>
            <a href="{{ route('public.news.show', $newsId) }}" class="inline-flex items-center gap-1 text-xs font-bold text-primary group-hover:gap-2 transition-all">
                EXPLORE TRIPLES
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>
    </div>
</article>
