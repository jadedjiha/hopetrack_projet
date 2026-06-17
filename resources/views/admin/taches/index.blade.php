<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-gray-800">Gestion des tâches</h1>
    </x-slot>

    <div class="space-y-5">

        @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl px-4 py-3 text-sm font-medium">✓ {{ session('success') }}</div>
        @endif

        <!-- Stats -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
            @foreach([['label'=>'Total','val'=>$stats['total'],'color'=>'text-gray-900'],['label'=>'En attente','val'=>$stats['en_attente'],'color'=>'text-gray-500'],['label'=>'En cours','val'=>$stats['en_cours'],'color'=>'text-blue-600'],['label'=>'Terminées','val'=>$stats['terminee'],'color'=>'text-emerald-600'],['label'=>'Rejetées','val'=>$stats['rejetee'],'color'=>'text-red-500']] as $s)
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">{{ $s['label'] }}</p>
                <p class="text-2xl font-bold {{ $s['color'] }}">{{ $s['val'] }}</p>
            </div>
            @endforeach
        </div>

        <!-- Formulaire création -->
        <div class="bg-white border border-gray-200 rounded-xl p-5">
            <h2 class="text-sm font-semibold text-gray-900 mb-4">Assigner une nouvelle tâche</h2>
            <form method="POST" action="{{ route('taches.store') }}">
                @csrf
                @if($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 text-sm">
                    <ul class="list-disc list-inside space-y-1">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
                @endif
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Employé</label>
                        <select name="user_id" class="input-field">
                            @foreach($employes as $e)<option value="{{ $e->id }}">{{ $e->name }}</option>@endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Titre</label>
                        <input type="text" name="titre" value="{{ old('titre') }}" placeholder="Titre de la tâche" class="input-field">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Priorité</label>
                        <select name="priorite" class="input-field">
                            <option value="faible">Faible</option>
                            <option value="moyenne" selected>Moyenne</option>
                            <option value="haute">Haute</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Description</label>
                        <textarea name="description" rows="2" placeholder="Description..." class="input-field">{{ old('description') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Date limite</label>
                        <input type="date" name="date_limite" value="{{ old('date_limite') }}" class="input-field">
                    </div>
                </div>
                <button type="submit" class="btn-primary mt-4">Créer la tâche</button>
            </form>
        </div>

        <!-- Filtres -->
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
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Priorité</label>
                    <select name="priorite" class="input-field !py-2 !w-auto">
                        <option value="">Toutes</option>
                        <option value="haute"   {{ request('priorite') === 'haute'   ? 'selected' : '' }}>Haute</option>
                        <option value="moyenne" {{ request('priorite') === 'moyenne' ? 'selected' : '' }}>Moyenne</option>
                        <option value="faible"  {{ request('priorite') === 'faible'  ? 'selected' : '' }}>Faible</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Employé</label>
                    <select name="employe_id" class="input-field !py-2 !w-auto">
                        <option value="">Tous</option>
                        @foreach($employes as $e)
                        <option value="{{ $e->id }}" {{ request('employe_id') == $e->id ? 'selected' : '' }}>{{ $e->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn-primary">Filtrer</button>
                @if(request()->hasAny(['statut','priorite','employe_id']))
                <a href="{{ route('taches.index') }}" class="text-sm text-gray-400 hover:text-gray-600 py-2">Réinitialiser</a>
                @endif
            </form>
        </div>

        <!-- Table -->
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="text-sm font-semibold text-gray-900">Liste des tâches</h2>
                <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2.5 py-1 rounded-full">{{ $taches->count() }}</span>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="table-header">Employé</th>
                            <th class="table-header">Titre</th>
                            <th class="table-header">Priorité</th>
                            <th class="table-header">Statut</th>
                            <th class="table-header">Date limite</th>
                            <th class="table-header">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($taches as $t)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="table-cell font-medium text-gray-900">{{ $t->user->name ?? 'N/A' }}</td>
                            <td class="table-cell">
                                <p class="font-medium text-gray-900">{{ $t->titre }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ Str::limit($t->description, 50) }}</p>
                            </td>
                            <td class="table-cell">
                                <span class="text-xs font-semibold px-2 py-0.5 rounded-full
                                    {{ $t->priorite === 'haute' ? 'bg-red-100 text-red-800' : ($t->priorite === 'moyenne' ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800') }}">
                                    {{ ucfirst($t->priorite) }}
                                </span>
                            </td>
                            <td class="table-cell">
                                <span class="text-xs font-semibold px-2 py-0.5 rounded-full
                                    {{ $t->statut === 'terminee' ? 'bg-emerald-100 text-emerald-800' : ($t->statut === 'en_cours' ? 'bg-blue-100 text-blue-800' : ($t->statut === 'rejetee' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-700')) }}">
                                    {{ ucfirst(str_replace('_', ' ', $t->statut)) }}
                                </span>
                            </td>
                            <td class="table-cell text-gray-500">
                                @if($t->date_limite) {{ $t->date_limite->format('d/m/Y') }} @if($t->estEnRetard()) <span class="text-red-600 font-semibold ml-1 text-xs">Retard</span> @endif
                                @else <span class="text-gray-300">—</span> @endif
                            </td>
                            <td class="table-cell">
                                <div class="flex gap-2">
                                    <a href="{{ route('taches.edit', $t->id) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors">Modifier</a>
                                    <form method="POST" action="{{ route('taches.destroy', $t->id) }}" onsubmit="return confirm('Supprimer ?')">
                                        @csrf @method('DELETE')
                                        <button class="bg-red-50 hover:bg-red-100 text-red-700 text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors">Supprimer</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="table-cell text-center text-gray-400 py-10">Aucune tâche trouvée.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
