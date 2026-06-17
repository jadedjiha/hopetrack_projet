<x-guest-layout>

    <!-- Titre -->
    <div class="mb-8">
        <h2 class="text-3xl font-black text-gray-900">Bon retour 👋</h2>
        <p class="text-gray-500 mt-2 text-sm">Connectez-vous à votre espace HopeTrack</p>
    </div>

    <!-- Status -->
    @if(session('status'))
    <div class="mb-5 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-sm font-medium">
        {{ session('status') }}
    </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Adresse email</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                    </svg>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                    placeholder="vous@exemple.com"
                    class="w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-2xl text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all bg-gray-50 focus:bg-white">
            </div>
            @error('email')
            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Mot de passe -->
        <div>
            <div class="flex items-center justify-between mb-2">
                <label for="password" class="block text-sm font-semibold text-gray-700">Mot de passe</label>
                @if(Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-xs text-indigo-600 hover:text-indigo-700 font-medium transition">
                    Mot de passe oublié ?
                </a>
                @endif
            </div>
            <div class="relative" x-data="{ show: false }">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <input id="password" :type="show ? 'text' : 'password'" name="password" required autocomplete="current-password"
                    placeholder="••••••••"
                    class="w-full pl-11 pr-11 py-3.5 border border-gray-200 rounded-2xl text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all bg-gray-50 focus:bg-white">
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 transition">
                    <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <svg x-show="show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                    </svg>
                </button>
            </div>
            @error('password')
            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Se souvenir -->
        <div class="flex items-center gap-3">
            <input id="remember_me" type="checkbox" name="remember"
                class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
            <label for="remember_me" class="text-sm text-gray-600">Se souvenir de moi</label>
        </div>

        <!-- Bouton connexion -->
        <button type="submit"
            class="w-full py-3.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-2xl transition-all duration-200 shadow-lg hover:shadow-xl text-sm">
            Se connecter →
        </button>

    </form>

    <!-- Inscription -->
    <p class="mt-6 text-center text-sm text-gray-500">
        Pas encore de compte ?
        <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-700 font-semibold ml-1 transition">
            S'inscrire gratuitement
        </a>
    </p>

    <!-- Comptes de démo -->
    <div class="mt-8 pt-6 border-t border-gray-100">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Comptes de démonstration</p>
        <div class="space-y-2">
            <button onclick="fillDemo('admin@hopetrack.com')"
                class="w-full flex items-center justify-between px-4 py-3 bg-gray-50 hover:bg-indigo-50 hover:border-indigo-200 border border-gray-100 rounded-xl transition-all group">
                <div class="flex items-center gap-3">
                    <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center">
                        <span class="text-white text-xs font-bold">A</span>
                    </div>
                    <div class="text-left">
                        <p class="text-xs font-semibold text-gray-700">Admin</p>
                        <p class="text-xs text-gray-400">admin@hopetrack.com</p>
                    </div>
                </div>
                <svg class="w-4 h-4 text-gray-300 group-hover:text-indigo-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
            <button onclick="fillDemo('employe@hopetrack.com')"
                class="w-full flex items-center justify-between px-4 py-3 bg-gray-50 hover:bg-emerald-50 hover:border-emerald-200 border border-gray-100 rounded-xl transition-all group">
                <div class="flex items-center gap-3">
                    <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center">
                        <span class="text-white text-xs font-bold">E</span>
                    </div>
                    <div class="text-left">
                        <p class="text-xs font-semibold text-gray-700">Employé</p>
                        <p class="text-xs text-gray-400">employe@hopetrack.com</p>
                    </div>
                </div>
                <svg class="w-4 h-4 text-gray-300 group-hover:text-emerald-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
    </div>

    <script>
        function fillDemo(email) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = 'password';
        }
    </script>

</x-guest-layout>
