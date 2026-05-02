<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }} Admin</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-background text-foreground font-sans">
        <div class="flex min-h-screen">
            <!-- Sidebar -->
            <x-admin-sidebar />

            <!-- Main Content -->
            <main class="flex-1 flex flex-col min-w-0 bg-secondary/30">
                <!-- Top Header -->
                <header class="h-16 border-b border-border bg-background/50 backdrop-blur-md flex items-center justify-between px-8 sticky top-0 z-10">
                    <div class="flex items-center gap-4">
                        <h1 class="font-serif font-bold text-xl">{{ $header ?? 'Dashboard' }}</h1>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-2 px-3 py-1.5 bg-primary-soft border border-primary/10 rounded-lg">
                            <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                            <span class="text-[10px] font-bold text-primary uppercase tracking-widest">Triplestore Online</span>
                        </div>
                        <div class="h-8 w-[1px] bg-border mx-2"></div>
                        <span class="text-sm font-medium">{{ Auth::user()->name }}</span>
                    </div>
                </header>

                <!-- Page Content -->
                <div class="p-8">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>
