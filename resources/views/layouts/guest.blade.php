<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>HopeTrack</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="antialiased bg-white">

    <div class="min-h-screen flex">

        <!-- ── CÔTÉ GAUCHE — BRANDING ──────────────────────────────── -->
        <div class="hidden lg:flex lg:w-1/2 xl:w-[55%] relative overflow-hidden bg-gradient-to-br from-indigo-900 via-indigo-800 to-purple-900 flex-col justify-between p-12">

            <!-- Pattern décoratif -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute -top-40 -right-40 w-96 h-96 bg-white/5 rounded-full"></div>
                <div class="absolute top-1/3 -left-20 w-72 h-72 bg-purple-500/20 rounded-full"></div>
                <div class="absolute -bottom-20 right-1/4 w-80 h-80 bg-indigo-400/10 rounded-full"></div>
                <svg class="absolute inset-0 w-full h-full opacity-5" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                            <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1"/>
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#grid)" />
                </svg>
            </div>

            <!-- Logo -->
            <div class="relative z-10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white rounded-2xl flex items-center justify-center shadow-lg">
                        <span class="text-indigo-700 font-black text-xl">H</span>
                    </div>
                    <span class="text-white font-bold text-xl">HopeTrack</span>
                </div>
            </div>

            <!-- Contenu central -->
            <div class="relative z-10 flex-1 flex flex-col justify-center py-12">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/10 backdrop-blur rounded-full text-white/80 text-xs font-medium mb-8 w-fit">
                    <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full animate-pulse"></span>
                    Plateforme RH en ligne
                </div>

                <h1 class="text-4xl xl:text-5xl font-black text-white leading-tight mb-6">
                    Gérez votre équipe<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-300 to-purple-300">en toute simplicité</span>
                </h1>

                <p class="text-indigo-200 text-lg leading-relaxed mb-10 max-w-md">
                    Pointage GPS, gestion des congés et suivi des tâches — tout en un seul endroit.
                </p>

                <!-- Features -->
                <div class="space-y-4">
                    @foreach([
                        ['icon' => '📍', 'text' => 'Pointage GPS avec détection des retards'],
                        ['icon' => '🏖️', 'text' => 'Gestion des congés et permissions'],
                        ['icon' => '✅', 'text' => 'Suivi des tâches par priorité'],
                    ] as $f)
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-white/10 rounded-xl flex items-center justify-center text-sm">{{ $f['icon'] }}</div>
                        <span class="text-indigo-100 text-sm">{{ $f['text'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Footer branding -->
            <div class="relative z-10 flex items-center gap-4">
                <div class="flex -space-x-2">
                    @foreach(['A','B','C','D'] as $l)
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 border-2 border-indigo-800 flex items-center justify-center text-white text-xs font-bold">{{ $l }}</div>
                    @endforeach
                </div>
                <p class="text-indigo-300 text-sm">Rejoint par des équipes partout</p>
            </div>

        </div>

        <!-- ── CÔTÉ DROIT — FORMULAIRE ─────────────────────────────── -->
        <div class="flex-1 flex flex-col justify-center px-6 sm:px-12 lg:px-16 xl:px-24 py-12 bg-white">

            <!-- Mobile logo -->
            <div class="lg:hidden flex items-center gap-2 mb-10">
                <div class="w-8 h-8 bg-gradient-to-br from-indigo-600 to-purple-700 rounded-xl flex items-center justify-center">
                    <span class="text-white font-black text-sm">H</span>
                </div>
                <span class="text-gray-800 font-bold text-lg">HopeTrack</span>
            </div>

            <div class="w-full max-w-sm mx-auto lg:mx-0">
                {{ $slot }}
            </div>

            <p class="text-center lg:text-left text-xs text-gray-400 mt-10 max-w-sm mx-auto lg:mx-0">
                © {{ date('Y') }} HopeTrack. Tous droits réservés.
            </p>

        </div>

    </div>

</body>
</html>
