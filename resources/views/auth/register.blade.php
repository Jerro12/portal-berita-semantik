<x-guest-layout>
    <div class="mb-10 text-center">
        <h1 class="text-3xl font-serif font-bold text-foreground mb-2">Create Account</h1>
        <p class="text-sm text-muted-foreground font-medium">Join the semantic news management team.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-[10px] font-bold text-muted-foreground uppercase tracking-widest mb-2">Full Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" 
                class="block w-full border-border bg-secondary/30 rounded-2xl focus:ring-primary focus:border-primary px-4 py-3 transition-all" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-[10px] font-bold text-muted-foreground uppercase tracking-widest mb-2">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" 
                class="block w-full border-border bg-secondary/30 rounded-2xl focus:ring-primary focus:border-primary px-4 py-3 transition-all" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-[10px] font-bold text-muted-foreground uppercase tracking-widest mb-2">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password" 
                class="block w-full border-border bg-secondary/30 rounded-2xl focus:ring-primary focus:border-primary px-4 py-3 transition-all" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-[10px] font-bold text-muted-foreground uppercase tracking-widest mb-2">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" 
                class="block w-full border-border bg-secondary/30 rounded-2xl focus:ring-primary focus:border-primary px-4 py-3 transition-all" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-6">
            <button type="submit" class="w-full bg-primary text-primary-foreground py-4 rounded-2xl font-bold shadow-lg shadow-primary/20 hover:scale-[1.02] transition-all flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                REGISTER ACCOUNT
            </button>
        </div>

        <div class="text-center pt-4 border-t border-border mt-4">
            <p class="text-xs text-muted-foreground font-medium">Already have an account? <a href="{{ route('login') }}" class="text-primary font-bold hover:underline">Log in instead</a></p>
        </div>
    </form>
</x-guest-layout>
