<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Avrillo Test App</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-black text-white/50">
        <div class="bg-black text-white/50">
            <div class="relative min-h-screen flex flex-col items-center">
                <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl flex flex-1 flex-col">
                    <header class="p-8">
                        <div class="flex flex-col items-center gap-6 sm:justify-between sm:flex-row">
                            <span class="text-xl">Avrillo Test</span>
                            
                            @auth
                                <div class="flex gap-8">
                                    <a href="/quotes" class="text-lg hover:underline">Quotes</a>
                                    <a href="/logout" class="text-lg hover:underline">Log Out</a>
                                </div>
                            @endauth
                        </div>
                    </header>

                    <main class="mt-6 h-full grow">
                        {{ $slot }}
                    </main>

                    <footer class="py-16 text-center text-sm mt-auto">
                        By Robert Mills
                    </footer>
                </div>
            </div>
        </div>
    </body>
</html>
