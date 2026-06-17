<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HopeTrack — Gestion RH</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50" style="font-family: 'Inter', sans-serif;">

    <!-- Nav -->
    <nav class="bg-white border-b border-gray-100 px-6 py-4 flex items-center justify-between">

        <!-- Logo + Nom -->
        <div class="flex items-center gap-3">
            <img
                src="{{ asset('image/logo-hope.png') }}"
                alt="Logo HopeTrack"
                class="h-12 w-auto">

            <div>
                <p class="font-bold text-gray-800 text-lg leading-none">HopeTrack</p>
                <p class="text-xs text-gray-400">Gestion RH</p>
            </div>
        </div>

        <!-- Boutons -->
        <div class="flex gap-3">
            <a href="{{ route('login') }}"
                class="px-5 py-2.5 text-sm font-semibold text-gray-700 hover:text-indigo-600 transition">
                Connexion
            </a>

            <a href="{{ route('register') }}"
                class="px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-sm font-semibold rounded-xl shadow-md hover:shadow-lg transition">
                S'inscrire
            </a>
        </div>

    </nav>

    <!-- Hero -->
    <section class="max-w-6xl mx-auto px-6 py-20 text-center">
        <div class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-50 text-indigo-700 rounded-full text-sm font-semibold mb-6">
            ✨ Plateforme RH moderne
        </div>
        <h1 class="text-5xl md:text-6xl font-black text-gray-900 leading-tight mb-6">
            Gérez votre équipe<br>
            <span class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">avec simplicité</span>
        </h1>
        <p class="text-xl text-gray-500 max-w-2xl mx-auto mb-10">
            HopeTrack centralise le pointage GPS, les congés et les tâches de vos employés dans une interface moderne et intuitive.
        </p>
        <div class="flex gap-4 justify-center flex-wrap">
            <a href="{{ route('login') }}" class="px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-2xl shadow-xl hover:shadow-2xl transition-all text-lg">
                Commencer →
            </a>
            <a href="{{ route('register') }}" class="px-8 py-4 bg-white text-gray-700 font-bold rounded-2xl shadow-md hover:shadow-lg transition-all text-lg border border-gray-100">
                Créer un compte
            </a>
        </div>
    </section>

    <!-- Features -->
    <section class="max-w-6xl mx-auto px-6 pb-20">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all">
                <div class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-2xl flex items-center justify-center mb-4 shadow">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <h3 class="font-bold text-gray-800 text-lg mb-2">Pointage GPS</h3>
                <p class="text-gray-500 text-sm">Enregistrez les entrées et sorties avec géolocalisation. Détection automatique des retards.</p>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-2xl flex items-center justify-center mb-4 shadow">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="font-bold text-gray-800 text-lg mb-2">Gestion des congés</h3>
                <p class="text-gray-500 text-sm">Demandes de congé et permissions en ligne. Validation rapide par les administrateurs.</p>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-pink-500 rounded-2xl flex items-center justify-center mb-4 shadow">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <h3 class="font-bold text-gray-800 text-lg mb-2">Suivi des tâches</h3>
                <p class="text-gray-500 text-sm">Assignez et suivez les tâches par priorité. Les employés mettent à jour leur avancement en temps réel.</p>
            </div>

        </div>
    </section>

    <footer class="bg-gray-950 text-white mt-20">

        <div class="max-w-6xl mx-auto px-6 py-12">

            <div class="grid md:grid-cols-3 gap-10">

                <!-- Logo et Description -->
                <div>

                    <div class="flex items-center gap-4 mb-4">

                        <img
                            src="{{ asset('public/image/logo-hope.png') }}"
                            alt="HopeTrack"
                            class="h-14 w-auto bg-white p-1 rounded-lg shadow">

                        <div>

                            <h3 class="font-bold text-2xl text-white">
                                HopeTrack
                            </h3>

                            <p class="text-gray-300 text-sm">
                                Gestion RH intelligente
                            </p>

                        </div>

                    </div>

                    <p class="text-gray-200 leading-relaxed">
                        Une solution moderne pour la gestion des employés,
                        le pointage GPS, les congés, les rapports et le suivi des tâches.
                    </p>

                </div>

                <!-- Navigation -->
                <div>

                    <h4 class="font-bold text-xl text-white mb-5">
                        Navigation
                    </h4>

                    <ul class="space-y-3">

                        <li>
                            <a href="/"
                                class="text-gray-200 hover:text-blue-400 transition duration-300">
                                🏠 Accueil
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('login') }}"
                                class="text-gray-200 hover:text-blue-400 transition duration-300">
                                🔐 Connexion
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('register') }}"
                                class="text-gray-200 hover:text-blue-400 transition duration-300">
                                📝 Inscription
                            </a>
                        </li>

                    </ul>

                </div>

                <!-- Contact -->
                <div>

                    <h4 class="font-bold text-xl text-white mb-5">
                        Contact
                    </h4>

                    <div class="space-y-3 text-gray-200">

                        <p class="flex items-center gap-2">
                            📍 <span>Cotonou, Bénin</span>
                        </p>

                        <p class="flex items-center gap-2">
                            📧 <span>contact@hopegroupe.com</span>
                        </p>

                        <p class="flex items-center gap-2">
                            📞 <span>+229 01 60 27 67 72</span>
                        </p>

                        <p class="flex items-center gap-2">
                            🌐 <span>www.hopegroupe.com</span>
                        </p>

                    </div>

                </div>

            </div>

            <!-- Ligne de séparation -->
            <div class="border-t border-gray-700 mt-10 pt-6">

                <p class="text-center text-gray-300 text-sm">
                    © {{ date('Y') }}
                    <span class="font-semibold text-white">HopeTrack</span>
                    — Tous droits réservés.
                </p>

                <p class="text-center text-gray-400 text-xs mt-2">
                    Développé pour la gestion intelligente des ressources humaines.
                </p>

            </div>

        </div>

    </footer>
</body>

</html>