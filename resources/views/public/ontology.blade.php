<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Ontology Specification - NewsHub</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-background text-foreground font-sans">
        
        <!-- Navbar -->
        <nav class="border-b border-border bg-background/80 backdrop-blur-md py-4 sticky top-0 z-50">
            <div class="max-w-5xl mx-auto px-4 flex justify-between items-center">
                <a href="/" class="flex items-center gap-2 group">
                    <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center text-primary-foreground font-serif font-bold text-lg shadow-lg shadow-primary/20">S</div>
                    <span class="text-lg font-bold tracking-tight text-foreground">News<span class="text-primary">Hub</span></span>
                </a>
                <div class="flex items-center gap-6">
                    <a href="{{ route('home') }}" class="text-xs font-bold text-muted-foreground hover:text-primary uppercase tracking-widest transition-colors">Home</a>
                    <a href="{{ route('public.ontology') }}" class="text-xs font-bold text-primary uppercase tracking-widest">Ontology</a>
                    <a href="{{ route('public.semantic.index') }}" class="text-xs font-bold text-muted-foreground hover:text-primary uppercase tracking-widest transition-colors">Semantic Index</a>
                </div>
            </div>
        </nav>

        <main class="max-w-4xl mx-auto px-4 py-16">
            <div class="space-y-12">
                <header class="text-center space-y-4">
                    <h1 class="text-4xl font-serif font-bold">Ontology Specification</h1>
                    <p class="text-muted-foreground max-w-2xl mx-auto">This project utilizes standard vocabularies to ensure semantic interoperability and structured knowledge representation.</p>
                </header>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="p-8 bg-secondary/30 rounded-[2rem] border border-border space-y-4">
                        <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-primary">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <h2 class="text-xl font-bold font-serif">Vocabulary: Schema.org</h2>
                        <p class="text-sm text-muted-foreground leading-relaxed">Schema.org is a collaborative, community activity with a mission to create, maintain, and promote schemas for structured data on the Internet.</p>
                        <a href="https://schema.org" target="_blank" class="inline-flex items-center gap-2 text-xs font-bold text-primary hover:underline">
                            Visit Schema.org
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        </a>
                    </div>

                    <div class="p-8 bg-secondary/30 rounded-[2rem] border border-border space-y-4">
                        <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-primary">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <h2 class="text-xl font-bold font-serif">Base Class: NewsArticle</h2>
                        <p class="text-sm text-muted-foreground leading-relaxed">A NewsArticle is an article whose primary purpose is to report news. It is a sub-type of <strong>Article</strong> and <strong>CreativeWork</strong>.</p>
                        <span class="inline-flex px-3 py-1 bg-primary/10 text-primary rounded-lg text-[10px] font-mono font-bold">schema:NewsArticle</span>
                    </div>
                </div>

                <div class="bg-background border border-border rounded-[2rem] overflow-hidden shadow-sm">
                    <div class="p-6 bg-secondary/10 border-b border-border">
                        <h3 class="font-bold font-serif text-lg">Mapped Properties</h3>
                    </div>
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-secondary/30">
                                <th class="px-6 py-4 text-[10px] font-bold text-muted-foreground uppercase tracking-widest">Property</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-muted-foreground uppercase tracking-widest">Expected Type</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-muted-foreground uppercase tracking-widest">Description</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            <tr>
                                <td class="px-6 py-4 font-mono text-xs text-primary">schema:headline</td>
                                <td class="px-6 py-4 font-mono text-xs">Text</td>
                                <td class="px-6 py-4 text-xs text-muted-foreground">The headline of the article.</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 font-mono text-xs text-primary">schema:articleBody</td>
                                <td class="px-6 py-4 font-mono text-xs">Text</td>
                                <td class="px-6 py-4 text-xs text-muted-foreground">The actual body of the article.</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 font-mono text-xs text-primary">schema:datePublished</td>
                                <td class="px-6 py-4 font-mono text-xs">DateTime</td>
                                <td class="px-6 py-4 text-xs text-muted-foreground">Date of first publication.</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 font-mono text-xs text-primary">schema:articleSection</td>
                                <td class="px-6 py-4 font-mono text-xs">Text / Category</td>
                                <td class="px-6 py-4 text-xs text-muted-foreground">High-level grouping (Category).</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 font-mono text-xs text-primary">schema:author</td>
                                <td class="px-6 py-4 font-mono text-xs">Person / Org</td>
                                <td class="px-6 py-4 text-xs text-muted-foreground">The creator of this content.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>

        <footer class="py-16 border-t border-border mt-24 bg-secondary/10">
            <div class="max-w-5xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-12 text-center md:text-left">
                <div class="space-y-4">
                    <div class="flex items-center justify-center md:justify-start gap-2">
                        <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center text-primary-foreground font-serif font-bold">S</div>
                        <span class="text-lg font-bold tracking-tight">NewsHub</span>
                    </div>
                    <p class="text-xs text-muted-foreground leading-relaxed">Penerapan Teknologi Web Semantik untuk kurasi berita cerdas berbasis Ontologi Schema.org.</p>
                </div>
                <div class="space-y-4">
                    <h4 class="text-xs font-bold uppercase tracking-widest text-foreground">Semantic Links</h4>
                    <ul class="space-y-2 text-xs text-muted-foreground font-medium">
                        <li><a href="{{ route('public.ontology') }}" class="hover:text-primary transition-colors">Ontology Spec</a></li>
                        <li><a href="{{ route('public.semantic.index') }}" class="hover:text-primary transition-colors">Semantic Index</a></li>
                        <li><a href="https://schema.org" target="_blank" class="hover:text-primary transition-colors">Schema.org Vocabulary</a></li>
                    </ul>
                </div>
                <div class="space-y-4">
                    <h4 class="text-xs font-bold uppercase tracking-widest text-foreground">Project Info</h4>
                    <p class="text-xs text-muted-foreground font-medium">&copy; {{ date('Y') }} Portal Berita Semantik - Thesis Project. Developed with Laravel & ARC2.</p>
                </div>
            </div>
        </footer>
    </body>
</html>
