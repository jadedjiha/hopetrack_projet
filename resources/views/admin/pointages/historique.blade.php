<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-gray-800">Historique des pointages</h1>
    </x-slot>

    <div class="space-y-5">

        <!-- Filtres -->
        <div class="bg-white border border-gray-200 rounded-xl px-4 py-3">
            <form method="GET" action="{{ route('pointages.historique') }}" class="flex flex-wrap gap-3 items-end">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Employé</label>
                    <select name="employe_id" class="input-field !py-2 !w-auto">
                        <option value="">Tous</option>
                        @foreach($employes as $e)
                        <option value="{{ $e->id }}" {{ request('employe_id') == $e->id ? 'selected' : '' }}>{{ $e->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Date</label>
                    <input type="date" name="date" value="{{ request('date') }}" class="input-field !py-2 !w-auto">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Type</label>
                    <select name="type" class="input-field !py-2 !w-auto">
                        <option value="">Tous</option>
                        <option value="entree" {{ request('type') === 'entree' ? 'selected' : '' }}>Entrée</option>
                        <option value="sortie" {{ request('type') === 'sortie' ? 'selected' : '' }}>Sortie</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Statut</label>
                    <select name="statut" class="input-field !py-2 !w-auto">
                        <option value="">Tous</option>
                        <option value="present" {{ request('statut') === 'present' ? 'selected' : '' }}>Présent</option>
                        <option value="retard"  {{ request('statut') === 'retard'  ? 'selected' : '' }}>Retard</option>
                    </select>
                </div>
                <button type="submit" class="btn-primary">Filtrer</button>
                @if(request()->hasAny(['employe_id','date','type','statut']))
                <a href="{{ route('pointages.historique') }}" class="text-sm text-gray-400 hover:text-gray-600 py-2">Réinitialiser</a>
                @endif
            </form>
        </div>

        <!-- Table -->
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="text-sm font-semibold text-gray-900">Tous les pointages</h2>
                <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2.5 py-1 rounded-full">{{ $pointages->total() }} enregistrement(s)</span>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="table-header">Employé</th>
                            <th class="table-header">Type</th>
                            <th class="table-header">Date</th>
                            <th class="table-header">Heure</th>
                            <th class="table-header">Statut</th>
                            <th class="table-header">Distance bureau</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($pointages as $p)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="table-cell font-medium text-gray-900">{{ $p->user->name ?? 'N/A' }}</td>
                            <td class="table-cell">
                                <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $p->type === 'entree' ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ ucfirst($p->type) }}
                                </span>
                            </td>
                            <td class="table-cell text-gray-600">{{ $p->date->format('d/m/Y') }}</td>
                            <td class="table-cell font-medium text-gray-800">{{ $p->heure }}</td>
                            <td class="table-cell">
                                @if($p->type === 'sortie')
                                    <span class="text-gray-300 text-xs">—</span>
                                @elseif($p->statut === 'retard')
                                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-amber-100 text-amber-800">Retard {{ $p->minutes_retard }}min</span>
                                @else
                                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800">Présent</span>
                                @endif
                            </td>
                            <td class="table-cell text-gray-500">
                                {{ $p->distance_bureau ? number_format($p->distance_bureau) . ' m' : '—' }}
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="table-cell text-center text-gray-400 py-10">Aucun pointage trouvé.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($pointages->hasPages())
            <div class="px-5 py-4 border-t border-gray-100">
                {{ $pointages->withQueryString()->links() }}
            </div>
            @endif
        </div>

    </div>
</x-app-layout>
