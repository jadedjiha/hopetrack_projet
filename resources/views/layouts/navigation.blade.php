<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- Logo -->
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <span class="text-lg font-bold text-blue-600 dark:text-blue-400">
                            HopeTrack
                        </span>
                    </a>
                </div>

                <!-- Menu desktop -->
                <div class="hidden space-x-6 sm:flex sm:ms-10 sm:items-center">

                    <a href="{{ route('dashboard') }}"
                        class="text-sm font-semibold {{ request()->routeIs('dashboard') ? 'text-blue-600 dark:text-blue-400 border-b-2 border-blue-600' : 'text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400' }} transition">
                        📍 Dashboard
                    </a>

                    <a href="{{ route('taches.index') }}"
                        class="text-sm font-semibold {{ request()->routeIs('taches.*') ? 'text-blue-600 dark:text-blue-400 border-b-2 border-blue-600' : 'text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400' }} transition">
                        ✅ Tâches
                    </a>

                    <a href="{{ route('conges.index') }}"
                        class="text-sm font-semibold {{ request()->routeIs('conges.*') ? 'text-blue-600 dark:text-blue-400 border-b-2 border-blue-600' : 'text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400' }} transition">
                        🏖️ Congés
                    </a>

                    @if(Auth::user()->role === 'admin')
                    <a href="{{ route('employes.index') }}"
                        class="text-sm font-semibold {{ request()->routeIs('employes.*') ? 'text-blue-600 dark:text-blue-400 border-b-2 border-blue-600' : 'text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400' }} transition">
                        👥 Employés
                    </a>
                    @endif

                    <a href="{{ route('profile.edit') }}"
                        class="text-sm font-semibold {{ request()->routeIs('profile.*') ? 'text-blue-600 dark:text-blue-400 border-b-2 border-blue-600' : 'text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400' }} transition">
                        👤 Profil
                    </a>

                </div>
            </div>

            <!-- User + Logout -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-4">

                <div class="flex flex-col items-end">
                    <span class="text-sm font-semibold text-gray-800 dark:text-white">
                        {{ Auth::user()->name }}
                    </span>
                    <span class="text-xs {{ Auth::user()->role === 'admin' ? 'text-red-500' : 'text-green-500' }} font-bold">
                        {{ Auth::user()->role }}
                    </span>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="bg-red-500 hover:bg-red-600 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
                        Déconnexion
                    </button>
                </form>

            </div>

            <!-- Mobile burger -->
            <div class="flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="text-gray-500 dark:text-gray-300 text-2xl focus:outline-none">
                    ☰
                </button>
            </div>

        </div>
    </div>

    <!-- Mobile menu -->
    <div x-show="open" class="sm:hidden px-4 pb-4 space-y-2">

        <a href="{{ route('dashboard') }}"
            class="block py-2 text-gray-700 dark:text-white font-semibold">
            📍 Dashboard
        </a>

        <a href="{{ route('taches.index') }}"
            class="block py-2 text-gray-700 dark:text-white font-semibold">
            ✅ Tâches
        </a>

        <a href="{{ route('conges.index') }}"
            class="block py-2 text-gray-700 dark:text-white font-semibold">
            🏖️ Congés
        </a>

        @if(Auth::user()->role === 'admin')
        <a href="{{ route('employes.index') }}"
            class="block py-2 text-gray-700 dark:text-white font-semibold">
            👥 Employés
        </a>
        @endif

        <a href="{{ route('profile.edit') }}"
            class="block py-2 text-gray-700 dark:text-white font-semibold">
            👤 Profil
        </a>

        <div class="pt-2 border-t dark:border-gray-600">
            <div class="text-sm text-gray-800 dark:text-white font-semibold">
                {{ Auth::user()->name }}
                <span class="text-xs {{ Auth::user()->role === 'admin' ? 'text-red-500' : 'text-green-500' }} ml-1">
                    ({{ Auth::user()->role }})
                </span>
            </div>

            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button type="submit"
                    class="bg-red-500 text-white text-sm font-semibold px-4 py-2 rounded-lg">
                    Déconnexion
                </button>
            </form>
        </div>

    </div>

</nav>
