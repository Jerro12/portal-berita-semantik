<x-admin-layout>
    <div class="max-w-4xl mx-auto space-y-8">
        <!-- Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('news.index') }}" class="w-10 h-10 rounded-full border border-border flex items-center justify-center text-muted-foreground hover:bg-secondary transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h1 class="text-3xl font-serif font-bold text-foreground">Edit Article</h1>
                <p class="text-muted-foreground font-medium">Update the semantic article content and metadata.</p>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-background border border-border rounded-[2rem] p-8 shadow-sm">
            <form action="{{ route('news.update', $news->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PATCH')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="title" class="block text-[10px] font-bold text-muted-foreground uppercase tracking-widest mb-2">Article Title</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $news->title) }}" 
                            class="block w-full border-border bg-secondary/30 rounded-2xl focus:ring-primary focus:border-primary px-4 py-3" 
                            placeholder="Headline berita...">
                        @error('title') <p class="mt-1 text-xs text-destructive font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="category" class="block text-[10px] font-bold text-muted-foreground uppercase tracking-widest mb-2">Semantic Category</label>
                        <select name="category" id="category" 
                            class="block w-full border-border bg-secondary/30 rounded-2xl focus:ring-primary focus:border-primary px-4 py-3">
                            @foreach(\App\Models\Category::all() as $cat)
                                <option value="{{ $cat->name }}" {{ old('category', $news->category) == $cat->name ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category') <p class="mt-1 text-xs text-destructive font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="source" class="block text-[10px] font-bold text-muted-foreground uppercase tracking-widest mb-2">Source / Author</label>
                        <input type="text" name="source" id="source" value="{{ old('source', $news->source) }}" 
                            class="block w-full border-border bg-secondary/30 rounded-2xl focus:ring-primary focus:border-primary px-4 py-3" 
                            placeholder="Nama penulis atau sumber...">
                        @error('source') <p class="mt-1 text-xs text-destructive font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="published_at" class="block text-[10px] font-bold text-muted-foreground uppercase tracking-widest mb-2">Publication Date</label>
                        <input type="datetime-local" name="published_at" id="published_at" value="{{ old('published_at', $news->published_at?->format('Y-m-d\TH:i')) }}" 
                            class="block w-full border-border bg-secondary/30 rounded-2xl focus:ring-primary focus:border-primary px-4 py-3">
                        @error('published_at') <p class="mt-1 text-xs text-destructive font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2 border-t border-border pt-6">
                        <label class="block text-[10px] font-bold text-muted-foreground uppercase tracking-widest mb-4">Poster Image</label>
                        
                        @if($news->image)
                        <div class="mb-4">
                            <img src="{{ $news->image }}" alt="Current Poster" class="w-32 h-32 object-cover rounded-xl border border-border shadow-sm">
                            <p class="text-[10px] text-muted-foreground mt-2 italic">Current Image: {{ $news->image }}</p>
                        </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="image_file" class="block text-[10px] font-bold text-muted-foreground uppercase tracking-widest mb-2">Upload New File</label>
                                <input type="file" name="image_file" id="image_file" 
                                    class="block w-full text-xs text-muted-foreground file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                                @error('image_file') <p class="mt-1 text-xs text-destructive font-bold">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="image_url" class="block text-[10px] font-bold text-muted-foreground uppercase tracking-widest mb-2">Or Use Image URL</label>
                                <input type="text" name="image_url" id="image_url" value="{{ old('image_url', (str_starts_with($news->image, 'http') ? $news->image : '')) }}" 
                                    class="block w-full border-border bg-secondary/30 rounded-2xl focus:ring-primary focus:border-primary px-4 py-3 text-xs" 
                                    placeholder="https://unsplash.com/...">
                                @error('image_url') <p class="mt-1 text-xs text-destructive font-bold">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="content" class="block text-[10px] font-bold text-muted-foreground uppercase tracking-widest mb-2">Article Content</label>
                    <textarea name="content" id="content" rows="10" 
                        class="block w-full border-border bg-secondary/30 rounded-2xl focus:ring-primary focus:border-primary px-4 py-3" 
                        placeholder="Tulis isi berita di sini...">{{ old('content', $news->content) }}</textarea>
                    @error('content') <p class="mt-1 text-xs text-destructive font-bold">{{ $message }}</p> @enderror
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-primary text-primary-foreground py-4 rounded-2xl font-bold shadow-lg shadow-primary/20 hover:scale-[1.02] transition-all">
                        UPDATE ARTICLE & SYNC TRIPLES
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
