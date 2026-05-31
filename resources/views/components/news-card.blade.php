@props(['news'])

@php
    $newsId = basename($news['id']);
@endphp
<article class="flex flex-col sm:flex-row gap-6 pt-6 group cursor-pointer border border-slate-200 rounded-xl p-4 bg-white hover:border-accent/40 hover:shadow-md transition-all duration-300">
    <!-- Thumbnail Image (Left) -->
    <div class="w-full sm:w-48 h-32 rounded-lg overflow-hidden shrink-0 bg-slate-100 border border-slate-200">
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
        <div class="flex flex-wrap items-center gap-2 text-[10px] mb-2 font-bold text-slate-500 uppercase tracking-wider">
            <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-700 border border-slate-200 font-sans">
                {{ $news['category'] }}
            </span>
            <span>•</span>
            <span>{{ $news['source'] }}</span>
            <span>•</span>
            <span>{{ \Carbon\Carbon::parse($news['date'])->translatedFormat('d M Y') }}</span>
        </div>

        <a href="{{ route('public.news.show', $newsId) }}" class="block">
            <h3 class="text-lg font-serif font-bold text-slate-900 group-hover:text-accent transition-colors leading-snug line-clamp-2">
                {{ $news['headline'] }}
            </h3>
        </a>

        <p class="text-xs text-slate-500 mt-2 font-medium line-clamp-2 leading-relaxed">
            {{ $news['body'] }}
        </p>

        <div class="mt-auto pt-4 flex items-center justify-between">
            <span class="inline-flex items-center gap-1 font-mono text-[9px] font-bold text-slate-400">
                rdf:type schema:NewsArticle
            </span>
            <a href="{{ route('public.news.show', $newsId) }}" class="inline-flex items-center gap-1 text-[9px] font-black uppercase text-accent hover:gap-2 tracking-widest transition-all">
                Eksplorasi Triple
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>
    </div>
</article>
