<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-lg font-semibold text-gray-800">Employés</h1>
            <a href="{{ route('employes.create') }}" class="btn-primary">+ Nouvel employé</a>
        </div>
    </x-slot>

    <div class="space-y-5">

        @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl px-4 py-3 text-sm font-medium">✓ {{ session('success') }}</div>
        @endif

        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="table-header">Employé</th>
                            <th class="table-header">Poste</th>
                            <th class="table-header">Département</th>
                            <th class="table-header text-center">Pointages</th>
                            <th class="table-header text-center">Tâches</th>
                            <th class="table-header">Statut</th>
                            <th class="table-header">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($employes as $e)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="table-cell">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xs shrink-0">
                                        {{ strtoupper(substr($e->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 text-sm">{{ $e->name }}</p>
                                        <p class="text-xs text-gray-400">{{ $e->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="table-cell text-gray-600">{{ $e->poste ?? '—' }}</td>
                            <td class="table-cell text-gray-600">{{ $e->departement ?? '—' }}</td>
                            <td class="table-cell text-center">
                                <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-blue-100 text-blue-800">{{ $e->pointages_count }}</span>
                            </td>
                            <td class="table-cell text-center">
                                <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-purple-100 text-purple-800">{{ $e->taches_count }}</span>
                            </td>
                            <td class="table-cell">
                                @if($e->is_active)
                                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800">Actif</span>
                                @else
                                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-red-100 text-red-800">Inactif</span>
                                @endif
                            </td>
                            <td class="table-cell">
                                <div class="flex gap-1.5 flex-wrap">
                                    <a href="{{ route('employes.show', $e->id) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold px-2.5 py-1.5 rounded-lg transition-colors">Voir</a>
                                    <a href="{{ route('employes.edit', $e->id) }}" class="bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-semibold px-2.5 py-1.5 rounded-lg transition-colors">Modifier</a>
                                    <form method="POST" action="{{ route('employes.toggle', $e->id) }}">
                                        @csrf @method('PATCH')
                                        <button class="{{ $e->is_active ? 'bg-amber-50 hover:bg-amber-100 text-amber-700' : 'bg-emerald-50 hover:bg-emerald-100 text-emerald-700' }} text-xs font-semibold px-2.5 py-1.5 rounded-lg transition-colors">
                                            {{ $e->is_active ? 'Désactiver' : 'Activer' }}
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('employes.destroy', $e->id) }}" onsubmit="return confirm('Supprimer cet employé ?')">
                                        @csrf @method('DELETE')
                                        <button class="bg-red-50 hover:bg-red-100 text-red-700 text-xs font-semibold px-2.5 py-1.5 rounded-lg transition-colors">Supprimer</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="table-cell text-center text-gray-400 py-10">Aucun employé. <a href="{{ route('employes.create') }}" class="text-indigo-600 underline">Ajouter</a></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
