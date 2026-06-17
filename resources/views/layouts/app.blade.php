<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>


    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <title>HopeTrack</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])


</head>

<body class="bg-slate-100 font-sans">

    <div class="flex min-h-screen">

        ```
        <!-- SIDEBAR -->
        <aside class="w-72 bg-white border-r border-gray-200 shadow-lg flex flex-col">

            <!-- LOGO -->
            <div class="p-6 border-b border-gray-100">

                <div class="flex items-center gap-3">

                    <img src="{{ asset('image/logo-hope.png') }}"
                        alt="Hope Groupe"
                        class="w-14 h-14 rounded-xl shadow">

                    <div>
                        <h1 class="text-2xl font-extrabold text-blue-600">
                            HopeTrack
                        </h1>

                        <p class="text-xs text-gray-500">
                            Hope Groupe
                        </p>
                    </div>

                </div>

            </div>

            <!-- MENU -->
            <nav class="flex-1 p-4 space-y-2 overflow-y-auto">

                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-4 px-5 py-4 rounded-2xl transition
            {{ request()->routeIs('dashboard') ? 'bg-blue-100 text-blue-700 font-bold' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700' }}">

                    <span class="text-xl">📊</span>
                    Dashboard
                </a>

                <a href="{{ route('taches.index') }}"
                    class="flex items-center gap-4 px-5 py-4 rounded-2xl transition
            {{ request()->routeIs('taches.*') ? 'bg-blue-100 text-blue-700 font-bold' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700' }}">

                    <span class="text-xl">📝</span>
                    Tâches
                </a>

                <a href="{{ route('conges.index') }}"
                    class="flex items-center gap-4 px-5 py-4 rounded-2xl transition
            {{ request()->routeIs('conges.*') ? 'bg-blue-100 text-blue-700 font-bold' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700' }}">

                    <span class="text-xl">📅</span>
                    Congés
                </a>

                <a href="{{ route('rapports.index') }}"
                    class="flex items-center gap-4 px-5 py-4 rounded-2xl transition
            {{ request()->routeIs('rapports.*') ? 'bg-blue-100 text-blue-700 font-bold' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700' }}">

                    <span class="text-xl">📈</span>
                    Rapports
                </a>

                @if(Auth::user()->role == 'admin')

                <a href="{{ route('employes.index') }}"
                    class="flex items-center gap-4 px-5 py-4 rounded-2xl transition
            {{ request()->routeIs('employes.*') ? 'bg-blue-100 text-blue-700 font-bold' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700' }}">

                    <span class="text-xl">👥</span>
                    Employés
                </a>

                @endif

                <a href="{{ route('profile.edit') }}"
                    class="flex items-center gap-4 px-5 py-4 rounded-2xl transition
            {{ request()->routeIs('profile.*') ? 'bg-blue-100 text-blue-700 font-bold' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700' }}">

                    <span class="text-xl">⚙️</span>
                    Mon Profil
                </a>

            </nav>

            <!-- PROFIL UTILISATEUR -->
            <div class="p-5 border-t border-gray-100 bg-white">

                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-4 shadow-sm">

                    <div class="flex items-center gap-3">

                        <div class="w-12 h-12 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-lg">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>

                        <div>
                            <p class="font-bold text-gray-800">
                                {{ Auth::user()->name }}
                            </p>

                            <p class="text-sm text-gray-500 capitalize">
                                {{ Auth::user()->role }}
                            </p>
                        </div>

                    </div>

                    <a href="{{ route('profile.edit') }}"
                        class="mt-4 block text-center bg-white border border-gray-200 hover:bg-gray-50 py-2 rounded-xl text-sm font-semibold transition">

                        Modifier mon profil

                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="mt-3">

                        @csrf

                        <button type="submit"
                            class="w-full bg-red-500 hover:bg-red-600 text-white py-3 rounded-xl font-semibold transition">

                            Déconnexion

                        </button>

                    </form>

                </div>

            </div>

        </aside>

        <!-- CONTENU -->
        <main class="flex-1 p-8 overflow-y-auto">

            @isset($header)
            <div class="mb-8">
                {{ $header }}
            </div>
            @endisset

            {{ $slot }}

        </main>


    </div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

</body>

</html>