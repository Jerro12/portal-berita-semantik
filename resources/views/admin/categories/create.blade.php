<x-admin-layout>
    <div class="max-w-3xl mx-auto space-y-8">
        <!-- Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('categories.index') }}" class="w-10 h-10 rounded-full border border-border flex items-center justify-center text-muted-foreground hover:bg-secondary transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h1 class="text-3xl font-serif font-bold text-foreground">New Category</h1>
                <p class="text-muted-foreground font-medium">Define a new news classification.</p>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-background border border-border rounded-[2rem] p-8 shadow-sm">
            <form action="{{ route('categories.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div>
                    <label for="name" class="block text-[10px] font-bold text-muted-foreground uppercase tracking-widest mb-2">Category Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
                        class="block w-full border-border bg-secondary/30 rounded-2xl focus:ring-primary focus:border-primary px-4 py-3" 
                        placeholder="e.g. Teknologi">
                    @error('name') <p class="mt-1 text-xs text-destructive font-bold">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="description" class="block text-[10px] font-bold text-muted-foreground uppercase tracking-widest mb-2">Description</label>
                    <textarea name="description" id="description" rows="4" 
                        class="block w-full border-border bg-secondary/30 rounded-2xl focus:ring-primary focus:border-primary px-4 py-3" 
                        placeholder="Explain what this category covers...">{{ old('description') }}</textarea>
                    @error('description') <p class="mt-1 text-xs text-destructive font-bold">{{ $message }}</p> @enderror
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-primary text-primary-foreground py-4 rounded-2xl font-bold shadow-lg shadow-primary/20 hover:scale-[1.02] transition-all">
                        SAVE CATEGORY
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
