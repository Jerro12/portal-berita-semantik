<x-admin-layout>
    <div class="space-y-8">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <h1 class="text-3xl font-serif font-bold text-foreground mb-2">Ruang Kerja Kategori</h1>
                <p class="text-muted-foreground font-medium">Kelola dan atur taksonomi berita untuk pemetaan semantik yang lebih baik.</p>
            </div>
            <a href="{{ route('categories.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-primary text-primary-foreground rounded-2xl font-bold text-sm shadow-lg shadow-primary/20 hover:scale-105 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                TAMBAH KATEGORI BARU
            </a>
        </div>

        @if(session('success'))
            <div class="p-4 bg-primary/10 border border-primary/20 rounded-2xl text-primary text-sm font-bold flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Categories Table -->
        <div class="bg-background border border-border rounded-[2rem] overflow-hidden shadow-sm">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-secondary/30">
                        <th class="px-6 py-4 text-[10px] font-bold text-muted-foreground uppercase tracking-widest">Info Kategori</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-muted-foreground uppercase tracking-widest">Slug</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-muted-foreground uppercase tracking-widest">Tautan Triple</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-muted-foreground uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse($categories as $category)
                        <tr class="hover:bg-secondary/10 transition-colors">
                            <td class="px-6 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-secondary rounded-xl flex items-center justify-center text-primary font-bold">
                                        {{ substr($category->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-lg font-serif font-bold text-foreground mb-1">{{ $category->name }}</div>
                                        <div class="text-xs text-muted-foreground line-clamp-1 max-w-xs">{{ $category->description ?? 'Tidak ada deskripsi disediakan.' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                <span class="px-3 py-1 bg-secondary text-primary rounded-lg text-xs font-mono font-bold">
                                    {{ $category->slug }}
                                </span>
                            </td>
                            <td class="px-6 py-6">
                                <span class="meta-tag">
                                    <span class="meta-tag-key">schema:articleSection</span>
                                </span>
                            </td>
                            <td class="px-6 py-6">
                                <div class="flex justify-end items-center gap-2">
                                    <a href="{{ route('categories.edit', $category) }}" class="p-2 text-muted-foreground hover:text-primary transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
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
                            <td colspan="4" class="px-6 py-12 text-center text-muted-foreground font-medium">
                                Tidak ada kategori ditemukan. Mulai dengan membuatnya.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
