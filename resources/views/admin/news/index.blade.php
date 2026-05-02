<x-admin-layout>
    <div class="space-y-8">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <h1 class="text-3xl font-serif font-bold text-foreground mb-2">Articles Workspace</h1>
                <p class="text-muted-foreground font-medium">Manage and monitor semantic news articles indexed in the triplestore.</p>
            </div>
            <a href="{{ route('news.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-primary text-primary-foreground rounded-2xl font-bold text-sm shadow-lg shadow-primary/20 hover:scale-105 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                ADD NEW ARTICLE
            </a>
        </div>

        @if(session('success'))
            <div class="p-4 bg-primary/10 border border-primary/20 rounded-2xl text-primary text-sm font-bold flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- News Table -->
        <div class="bg-background border border-border rounded-[2rem] overflow-hidden shadow-sm">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-secondary/30">
                        <th class="px-6 py-4 text-[10px] font-bold text-muted-foreground uppercase tracking-widest">Content & Metadata</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-muted-foreground uppercase tracking-widest">Semantic Category</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-muted-foreground uppercase tracking-widest">Source</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-muted-foreground uppercase tracking-widest">Triplestore Status</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-muted-foreground uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse($news as $item)
                        <tr class="hover:bg-secondary/10 transition-colors">
                            <td class="px-6 py-6">
                                <div class="flex items-center gap-4">
                                    @if($item->image)
                                        <img src="{{ $item->image }}" class="w-16 h-10 rounded-lg object-cover bg-secondary border border-border">
                                    @else
                                        <div class="w-16 h-10 rounded-lg bg-secondary flex items-center justify-center border border-border">
                                            <svg class="w-4 h-4 text-muted-foreground/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="text-lg font-serif font-bold text-foreground mb-1">{{ $item->title }}</div>
                                        <div class="text-xs font-mono text-muted-foreground">{{ $item->published_at->format('d M Y H:i') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                <span class="meta-tag">
                                    <span class="meta-tag-key">rdf:type</span> {{ $item->category }}
                                </span>
                            </td>
                            <td class="px-6 py-6 text-sm font-medium text-foreground">
                                {{ $item->source }}
                            </td>
                            <td class="px-6 py-6">
                                <span class="inline-flex items-center gap-1.5 text-[10px] font-bold text-primary px-3 py-1 bg-primary/10 rounded-lg border border-primary/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span>
                                    SYNCED & INDEXED
                                </span>
                            </td>
                            <td class="px-6 py-6">
                                <div class="flex justify-end items-center gap-2">
                                    <a href="{{ route('public.news.show', $item->id) }}" target="_blank" class="p-2 text-muted-foreground hover:text-primary transition-colors" title="View Semantic Page">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    <a href="{{ route('news.edit', $item->id) }}" class="p-2 text-muted-foreground hover:text-primary transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="{{ route('news.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus berita ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 text-muted-foreground hover:text-destructive transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-muted-foreground font-medium italic font-serif">
                                No news articles found in the triplestore.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
