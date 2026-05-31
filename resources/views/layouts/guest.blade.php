<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Login Admin - Portal Berita Semantik</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
        </style>
    </head>
    <body class="font-sans text-foreground antialiased bg-background">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative overflow-hidden">
            <!-- Background Decorative Elements -->
            <div class="absolute top-0 left-0 w-full h-full -z-10 overflow-hidden">
                <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] bg-primary/5 rounded-full blur-[120px]"></div>
                <div class="absolute top-[60%] -right-[10%] w-[50%] h-[50%] bg-primary/10 rounded-full blur-[150px]"></div>
            </div>

            <div class="mb-6">
                <a href="/" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-accent uppercase tracking-widest transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Portal
                </a>
            </div>

            <div class="w-full sm:max-w-md px-8 py-10 bg-white/70 backdrop-blur-2xl border border-white/20 shadow-[0_32px_64px_-12px_rgba(0,0,0,0.08)] rounded-[2.5rem]">
                {{ $slot }}
            </div>
            
            <div class="mt-8 text-center">
                <p class="text-[10px] text-muted-foreground font-bold uppercase tracking-[0.2em]">&copy; {{ date('Y') }} Semantic Engine Access Control</p>
            </div>
        </div>
    </body>
</html>
