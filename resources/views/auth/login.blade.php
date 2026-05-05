<x-guest-layout>
    <div class="mb-10 text-center">
        <h1 class="text-3xl font-serif font-bold text-foreground mb-2">Login Admin</h1>
        <p class="text-sm text-muted-foreground font-medium">Akses dasbor manajemen semantik.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-[10px] font-bold text-muted-foreground uppercase tracking-widest mb-2">Alamat Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" 
                class="block w-full border-border bg-secondary/30 rounded-2xl focus:ring-primary focus:border-primary px-4 py-3 transition-all" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center mb-2">
                <label for="password" class="block text-[10px] font-bold text-muted-foreground uppercase tracking-widest">Kata Sandi</label>
                @if (Route::has('password.request'))
                    <a class="text-[10px] font-bold text-primary hover:underline uppercase tracking-widest" href="{{ route('password.request') }}">
                        Lupa?
                    </a>
                @endif
            </div>
            <input id="password" type="password" name="password" required autocomplete="current-password" 
                class="block w-full border-border bg-secondary/30 rounded-2xl focus:ring-primary focus:border-primary px-4 py-3 transition-all" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" class="rounded-md border-border bg-secondary/30 text-primary shadow-sm focus:ring-primary focus:ring-offset-0" name="remember">
            <label for="remember_me" class="ms-3 text-xs font-bold text-muted-foreground uppercase tracking-widest cursor-pointer select-none">Ingat sesi ini</label>
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full bg-primary text-primary-foreground py-4 rounded-2xl font-bold shadow-lg shadow-primary/20 hover:scale-[1.02] transition-all flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                MASUK KE DASBOR
            </button>
        </div>

        @if (Route::has('register'))
            <div class="text-center pt-4">
                <p class="text-xs text-muted-foreground font-medium">Belum punya akun? <a href="{{ route('register') }}" class="text-primary font-bold hover:underline">Daftar di sini</a></p>
            </div>
        @endif
    </form>
</x-guest-layout>
