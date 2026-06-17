<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('employes.index') }}" class="text-gray-400 hover:text-gray-700 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h1 class="text-lg font-semibold text-gray-800">Fiche — {{ $employe->name }}</h1>
        </div>
    </x-slot>

    <div class="max-w-5xl space-y-5">

        @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl px-4 py-3 text-sm font-medium">✓ {{ session('success') }}</div>
        @endif

        <!-- Infos employé -->
        <div class="bg-white border border-gray-200 rounded-xl p-6">
            <div class="flex items-center gap-4 mb-5">
                <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-lg shrink-0">
                    {{ strtoupper(substr($employe->name, 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-900">{{ $employe->name }}</h2>
                    <p class="text-sm text-gray-500">{{ $employe->email }}</p>
                    <span class="inline-block mt-1 text-xs font-semibold px-2 py-0.5 rounded-full {{ $employe->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                        {{ $employe->is_active ? 'Actif' : 'Inactif' }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm mb-5">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Poste</p>
                    <p class="text-gray-800 font-medium">{{ $employe->poste ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Département</p>
                    <p class="text-gray-800 font-medium">{{ $employe->departement ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Téléphone</p>
                    <p class="text-gray-800 font-medium">{{ $employe->telephone ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Date d'embauche</p>
                    <p class="text-gray-800 font-medium">
                        {{ $employe->date_embauche ? \Carbon\Carbon::parse($employe->date_embauche)->format('d/m/Y') : '—' }}
                    </p>
                </div>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('employes.edit', $employe->id) }}" class="btn-primary">Modifier</a>
                <form method="POST" action="{{ route('employes.toggle', $employe->id) }}">
                    @csrf @method('PATCH')
                    <button class="{{ $employe->is_active ? 'bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200' : 'bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200' }} font-semibold px-4 py-2 rounded-xl text-sm transition-colors">
                        {{ $employe->is_active ? 'Désactiver' : 'Activer' }}
                    </button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            <!-- Derniers pointages -->
            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-900">Derniers pointages</h3>
                </div>
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="table-header">Date</th>
                            <th class="table-header">Type</th>
                            <th class="table-header">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($pointages as $p)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="table-cell text-gray-600">{{ $p->date }} {{ $p->heure }}</td>
                            <td class="table-cell">
                                <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $p->type === 'entree' ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ ucfirst($p->type) }}
                                </span>
                            </td>
                            <td class="table-cell">
                                <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $p->statut === 'retard' ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800' }}">
                                    {{ $p->statut === 'retard' ? 'Retard ('.$p->minutes_retard.'min)' : 'Présent' }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="table-cell text-center text-gray-400 py-6">Aucun pointage</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Tâches -->
            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-900">Tâches assignées</h3>
                </div>
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="table-header">Titre</th>
                            <th class="table-header">Priorité</th>
                            <th class="table-header">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($taches as $t)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="table-cell font-medium text-gray-800">{{ $t->titre }}</td>
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
                        </tr>
                        @empty
                        <tr><td colspan="3" class="table-cell text-center text-gray-400 py-6">Aucune tâche</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

        <!-- Historique congés -->
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <h3 class="text-sm font-semibold text-gray-900">Historique des congés</h3>
            </div>
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="table-header">Type</th>
                        <th class="table-header">Motif</th>
                        <th class="table-header">Période</th>
                        <th class="table-header">Jours</th>
                        <th class="table-header">Statut</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($conges as $c)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="table-cell">
                            <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $c->type === 'conge' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                {{ ucfirst($c->type) }}
                            </span>
                        </td>
                        <td class="table-cell text-gray-700">{{ $c->motif }}</td>
                        <td class="table-cell text-gray-600">{{ $c->date_debut->format('d/m/Y') }} → {{ $c->date_fin->format('d/m/Y') }}</td>
                        <td class="table-cell text-center font-semibold text-gray-700">{{ $c->nombre_jours }}j</td>
                        <td class="table-cell">
                            <span class="text-xs font-semibold px-2 py-0.5 rounded-full
                                {{ $c->statut === 'approuve' ? 'bg-emerald-100 text-emerald-800' : ($c->statut === 'refuse' ? 'bg-red-100 text-red-800' : 'bg-amber-100 text-amber-800') }}">
                                {{ $c->statut === 'approuve' ? 'Approuvé' : ($c->statut === 'refuse' ? 'Refusé' : 'En attente') }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="table-cell text-center text-gray-400 py-6">Aucun congé</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>
