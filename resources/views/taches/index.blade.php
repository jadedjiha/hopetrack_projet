<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-gray-800">Mes tâches</h1>
    </x-slot>

    <div class="max-w-4xl space-y-5">

        @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl px-4 py-3 text-sm font-medium">✓ {{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 rounded-xl px-4 py-3 text-sm font-medium">{{ session('error') }}</div>
        @endif

        <!-- Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Total</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">En attente</p>
                <p class="text-2xl font-bold text-gray-500">{{ $stats['en_attente'] }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">En cours</p>
                <p class="text-2xl font-bold text-blue-600">{{ $stats['en_cours'] }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Terminées</p>
                <p class="text-2xl font-bold text-emerald-600">{{ $stats['terminee'] }}</p>
            </div>
        </div>

        <!-- Filtre -->
        <div class="bg-white border border-gray-200 rounded-xl px-4 py-3">
            <form method="GET" action="{{ route('taches.index') }}" class="flex flex-wrap gap-3 items-end">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Statut</label>
                    <select name="statut" class="input-field !py-2 !w-auto">
                        <option value="">Tous</option>
                        <option value="en_attente" {{ request('statut') === 'en_attente' ? 'selected' : '' }}>En attente</option>
                        <option value="en_cours"   {{ request('statut') === 'en_cours'   ? 'selected' : '' }}>En cours</option>
                        <option value="terminee"   {{ request('statut') === 'terminee'   ? 'selected' : '' }}>Terminée</option>
                        <option value="rejetee"    {{ request('statut') === 'rejetee'    ? 'selected' : '' }}>Rejetée</option>
                    </select>
                </div>
                <button type="submit" class="btn-primary">Filtrer</button>
                @if(request('statut'))
                <a href="{{ route('taches.index') }}" class="text-sm text-gray-400 hover:text-gray-600 py-2">Réinitialiser</a>
                @endif
            </form>
        </div>

        <!-- Liste -->
        @forelse($taches as $t)
        <div class="bg-white border border-gray-200 rounded-xl p-5 {{ $t->estEnRetard() ? 'border-l-4 border-l-red-400' : '' }}">
            <div class="flex justify-between items-start gap-4 mb-3">
                <div class="flex-1">
                    <div class="flex flex-wrap items-center gap-2 mb-1">
                        <h3 class="font-semibold text-gray-900">{{ $t->titre }}</h3>
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full
                            {{ $t->priorite === 'haute' ? 'bg-red-100 text-red-800' : ($t->priorite === 'moyenne' ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800') }}">
                            {{ ucfirst($t->priorite) }}
                        </span>
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full
                            {{ $t->statut === 'terminee' ? 'bg-emerald-100 text-emerald-800' : ($t->statut === 'en_cours' ? 'bg-blue-100 text-blue-800' : ($t->statut === 'rejetee' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-700')) }}">
                            {{ ucfirst(str_replace('_', ' ', $t->statut)) }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-600">{{ $t->description }}</p>
                    @if($t->date_limite)
                    <p class="text-xs text-gray-400 mt-1.5">
                        Date limite : {{ $t->date_limite->format('d/m/Y') }}
                        @if($t->estEnRetard()) <span class="text-red-600 font-semibold ml-1">— En retard</span> @endif
                    </p>
                    @endif
                </div>
            </div>

            @if(in_array($t->statut, ['terminee', 'rejetee']))
                @if($t->commentaire)
                <div class="mt-3 pt-3 border-t border-gray-100">
                    <p class="text-sm text-gray-500 italic">{{ $t->commentaire }}</p>
                    @if($t->termine_le)
                    <p class="text-xs text-gray-400 mt-1">Clôturée le {{ \Carbon\Carbon::parse($t->termine_le)->format('d/m/Y à H:i') }}</p>
                    @endif
                </div>
                @endif
            @else
            <form method="POST" action="{{ route('taches.update', $t->id) }}" class="mt-3 pt-3 border-t border-gray-100">
                @csrf @method('PUT')
                <div class="flex flex-wrap gap-3 items-end">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Statut</label>
                        <select name="statut" class="input-field !py-2 !w-auto">
                            <option value="en_cours"  {{ $t->statut === 'en_cours' ? 'selected' : '' }}>En cours</option>
                            <option value="terminee">Terminée</option>
                            <option value="rejetee">Rejetée</option>
                        </select>
                    </div>
                    <div class="flex-1 min-w-48">
                        <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Commentaire</label>
                        <input type="text" name="commentaire" value="{{ $t->commentaire }}" placeholder="Ajouter un commentaire..." class="input-field !py-2">
                    </div>
                    <button type="submit" class="btn-primary">Mettre à jour</button>
                </div>
            </form>
            @endif
        </div>
        @empty
        <div class="bg-white border border-gray-200 rounded-xl p-12 text-center">
            <p class="text-gray-400 font-medium text-sm">Aucune tâche assignée pour le moment</p>
        </div>
        @endforelse

    </div>
</x-app-layout>
