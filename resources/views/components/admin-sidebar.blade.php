<aside class="w-64 border-r border-border bg-background flex flex-col sticky top-0 h-screen">
    <div class="p-6 mb-4">
        <a href="/" class="flex items-center gap-2 group">
            <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center text-primary-foreground font-serif font-bold text-lg shadow-lg shadow-primary/20">
                S
            </div>
            <span class="text-xl font-bold tracking-tight text-foreground">
                News<span class="text-primary">Hub</span>
            </span>
        </a>
    </div>

    <nav class="flex-1 px-4 space-y-8 overflow-y-auto">
        <!-- Workspace Section -->
        <div>
            <h4 class="px-2 mb-4 text-[10px] font-bold text-muted-foreground uppercase tracking-[0.2em]">Workspace</h4>
            <div class="space-y-1">
                <x-admin-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="layout-dashboard">
                    Dashboard
                </x-admin-nav-link>
                <x-admin-nav-link :href="route('news.index')" :active="request()->routeIs('news.index')" icon="files">
                    Articles
                </x-admin-nav-link>
                <x-admin-nav-link :href="route('news.create')" :active="request()->routeIs('news.create')" icon="plus-circle">
                    New Article
                </x-admin-nav-link>
                <x-admin-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')" icon="tag">
                    Categories
                </x-admin-nav-link>
            </div>
        </div>

        <!-- System Section -->
        <div>
            <h4 class="px-2 mb-4 text-[10px] font-bold text-muted-foreground uppercase tracking-[0.2em]">System</h4>
            <div class="space-y-1">
                <x-admin-nav-link :href="route('news.sparql')" :active="request()->routeIs('news.sparql')" icon="share-2">
                    Semantic Graph
                </x-admin-nav-link>
                <x-admin-nav-link href="#" icon="users">
                    Authors
                </x-admin-nav-link>
                <x-admin-nav-link href="#" icon="settings">
                    Settings
                </x-admin-nav-link>
            </div>
        </div>
    </nav>

    <!-- Bottom Status Card -->
    <div class="p-4 mt-auto">
        <div class="p-4 rounded-2xl bg-primary-soft border border-primary/10">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-2 h-2 rounded-full bg-primary"></div>
                <span class="text-[11px] font-bold text-primary uppercase tracking-wider">Ontology Synced</span>
            </div>
            <p class="text-[10px] text-primary/60 leading-relaxed font-medium">
                Last updated: {{ now()->format('H:i') }}
            </p>
        </div>
        
        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <button type="submit" class="w-full flex items-center gap-2 px-2 py-2 text-xs font-bold text-muted-foreground hover:text-destructive transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4-4v12"></path></svg>
                LOGOUT SYSTEM
            </button>
        </form>
    </div>
</aside>
