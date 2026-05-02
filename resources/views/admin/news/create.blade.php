<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-serif font-bold text-2xl text-foreground leading-tight">
            {{ __('Injeksi Data Semantik Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-background border border-border shadow-sm rounded-2xl p-8">
                
                <div class="mb-10 pb-6 border-b border-border">
                    <h3 class="text-lg font-serif font-bold text-foreground mb-2">Metadata Berita</h3>
                    <p class="text-sm text-muted-foreground leading-relaxed">
                        Input data berita di bawah ini. Mesin akan melakukan pemetaan triple secara otomatis berdasarkan ontologi **Schema.org** dan menyimpannya ke dalam persistent triplestore.
                    </p>
                </div>

                <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Judul -->
                        <div class="col-span-2">
                            <label for="title" class="block text-xs font-bold uppercase tracking-widest text-muted-foreground mb-2">Judul Berita (schema:headline)</label>
                            <input id="title" name="title" type="text" value="{{ old('title') }}"
                                class="block w-full border-border bg-secondary/30 rounded-xl focus:ring-primary focus:border-primary text-lg font-serif" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>

                        <!-- Kategori -->
                        <div>
                            <label for="category" class="block text-xs font-bold uppercase tracking-widest text-muted-foreground mb-2">Kategori (articleSection)</label>
                                <select id="category" name="category" 
                                    class="block w-full border-border bg-secondary/30 rounded-xl focus:ring-primary focus:border-primary">
                                    @foreach(\App\Models\Category::all() as $cat)
                                        <option value="{{ $cat->name }}" {{ old('category') == $cat->name ? 'selected' : '' }}>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            <x-input-error class="mt-2" :messages="$errors->get('category')" />
                        </div>

                        <!-- Sumber -->
                        <div>
                            <label for="source" class="block text-xs font-bold uppercase tracking-widest text-muted-foreground mb-2">Sumber (schema:author)</label>
                            <input id="source" name="source" type="text" value="{{ old('source') }}"
                                class="block w-full border-border bg-secondary/30 rounded-xl focus:ring-primary focus:border-primary" placeholder="Nama Media/Penulis" />
                            <x-input-error class="mt-2" :messages="$errors->get('source')" />
                        </div>

                        <!-- Image Upload -->
                        <div class="col-span-1">
                            <label for="image_file" class="block text-xs font-bold uppercase tracking-widest text-muted-foreground mb-2">Upload Poster (Local)</label>
                            <input id="image_file" name="image_file" type="file" 
                                class="block w-full text-sm text-muted-foreground file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20" />
                            <x-input-error class="mt-2" :messages="$errors->get('image_file')" />
                        </div>

                        <!-- Image URL -->
                        <div class="col-span-1">
                            <label for="image_url" class="block text-xs font-bold uppercase tracking-widest text-muted-foreground mb-2">Atau Poster Image URL</label>
                            <input id="image_url" name="image_url" type="text" value="{{ old('image_url') }}"
                                class="block w-full border-border bg-secondary/30 rounded-xl focus:ring-primary focus:border-primary" placeholder="https://unsplash.com/..." />
                            <x-input-error class="mt-2" :messages="$errors->get('image_url')" />
                        </div>

                        <!-- Tanggal -->
                        <div class="col-span-2 md:col-span-1">
                            <label for="published_at" class="block text-xs font-bold uppercase tracking-widest text-muted-foreground mb-2">Waktu Publikasi</label>
                            <input id="published_at" name="published_at" type="datetime-local" 
                                class="block w-full border-border bg-secondary/30 rounded-xl focus:ring-primary focus:border-primary" required />
                            <x-input-error class="mt-2" :messages="$errors->get('published_at')" />
                        </div>
                    </div>

                    <!-- Isi Berita -->
                    <div>
                        <label for="content" class="block text-xs font-bold uppercase tracking-widest text-muted-foreground mb-2">Konten Berita (schema:articleBody)</label>
                        <textarea id="content" name="content" rows="8" 
                            class="block w-full border-border bg-secondary/30 rounded-xl focus:ring-primary focus:border-primary leading-relaxed" required></textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('content')" />
                    </div>

                    <div class="flex items-center justify-end gap-6 pt-6 border-t border-border">
                        <a href="{{ route('news.index') }}" class="text-sm font-bold text-muted-foreground hover:text-foreground transition-colors">Batal</a>
                        <button type="submit" class="inline-flex items-center px-8 py-3 bg-primary text-primary-foreground rounded-xl font-bold uppercase tracking-widest text-xs hover:bg-primary-hover transition-colors shadow-lg shadow-primary/20">
                            Simpan & Indeks Semantik
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-admin-layout>
