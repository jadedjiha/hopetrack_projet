<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-gray-800">Dashboard Admin</h1>
    </x-slot>

    <div class="space-y-6">

        @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl px-4 py-3 text-sm font-medium">✓ {{ session('success') }}</div>
        @endif

        <!-- Stats -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Employés actifs</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_employes'] }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Présents aujourd'hui</p>
                <p class="text-2xl font-bold text-emerald-600">{{ $stats['presents_aujourd_hui'] }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Congés en attente</p>
                <p class="text-2xl font-bold text-amber-600">{{ $stats['conges_en_attente'] }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Tâches en cours</p>
                <p class="text-2xl font-bold text-indigo-600">{{ $stats['taches_en_cours'] }}</p>
            </div>
        </div>

        <!-- Accès rapides -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            <a href="{{ route('employes.index') }}" class="bg-white border border-gray-200 hover:border-indigo-300 hover:bg-indigo-50 rounded-xl p-4 flex flex-col items-center gap-2 transition-colors group">
                <div class="w-10 h-10 bg-indigo-100 group-hover:bg-indigo-200 rounded-xl flex items-center justify-center transition-colors">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <span class="text-sm font-medium text-gray-700">Employés</span>
            </a>
            <a href="{{ route('taches.index') }}" class="bg-white border border-gray-200 hover:border-purple-300 hover:bg-purple-50 rounded-xl p-4 flex flex-col items-center gap-2 transition-colors group">
                <div class="w-10 h-10 bg-purple-100 group-hover:bg-purple-200 rounded-xl flex items-center justify-center transition-colors">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <span class="text-sm font-medium text-gray-700">Tâches</span>
            </a>
            <a href="{{ route('conges.index') }}" class="bg-white border border-gray-200 hover:border-amber-300 hover:bg-amber-50 rounded-xl p-4 flex flex-col items-center gap-2 transition-colors group">
                <div class="w-10 h-10 bg-amber-100 group-hover:bg-amber-200 rounded-xl flex items-center justify-center transition-colors">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <span class="text-sm font-medium text-gray-700">Congés</span>
            </a>
            <a href="{{ route('employes.create') }}" class="bg-white border border-gray-200 hover:border-emerald-300 hover:bg-emerald-50 rounded-xl p-4 flex flex-col items-center gap-2 transition-colors group">
                <div class="w-10 h-10 bg-emerald-100 group-hover:bg-emerald-200 rounded-xl flex items-center justify-center transition-colors">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <span class="text-sm font-medium text-gray-700">Nouvel employé</span>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- Pointages du jour -->
            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="text-base font-semibold text-gray-900">Pointages du jour</h2>
                    <span class="text-xs text-gray-500">{{ now()->format('d/m/Y') }}</span>
                </div>
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="table-header">Employé</th>
                            <th class="table-header">Type</th>
                            <th class="table-header">Heure</th>
                            <th class="table-header">Statut</th>
                            <th class="table-header">Site</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($pointages_aujourd_hui as $p)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="table-cell font-medium">{{ $p->user->name ?? 'N/A' }}</td>
                            <td class="table-cell">
                                @if($p->type === 'entree') <span class="badge-green">Entrée</span>
                                @else <span class="badge-blue">Sortie</span>
                                @endif
                            </td>
                            <td class="table-cell font-medium">{{ $p->heure }}</td>
                            <td class="table-cell">
                                @if($p->statut === 'retard') <span class="badge-yellow">Retard {{ $p->minutes_retard }}min</span>
                                @else <span class="badge-green">Présent</span>
                                @endif
                            </td>
                            <td class="table-cell">{{ $p->site->name ?? 'N/A' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="table-cell text-center text-gray-400 py-6">Aucun pointage aujourd'hui</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Congés en attente -->
            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="text-base font-semibold text-gray-900">Congés à valider</h2>
                    @if($conges_en_attente->count() > 0)
                    <span class="badge-yellow">{{ $conges_en_attente->count() }}</span>
                    @endif
                </div>
                @if($conges_en_attente->count() > 0)
                <div class="divide-y divide-gray-100">
                    @foreach($conges_en_attente as $c)
                    <div class="px-5 py-3 flex items-start justify-between gap-3">
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $c->user->name ?? 'N/A' }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $c->motif }} — {{ $c->nombre_jours }}j ({{ $c->date_debut->format('d/m') }} → {{ $c->date_fin->format('d/m') }})</p>
                        </div>
                        <div class="flex gap-2 shrink-0">
                            <form method="POST" action="{{ route('conges.approuver', $c->id) }}">
                                @csrf @method('PATCH')
                                <button class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors">✓</button>
                            </form>
                            <form method="POST" action="{{ route('conges.refuser', $c->id) }}">
                                @csrf @method('PATCH')
                                <button class="bg-red-500 hover:bg-red-600 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors">✕</button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="px-5 py-8 text-center text-sm text-gray-400">Aucune demande en attente</div>
                @endif
            </div>

        </div>
    </div>

    </div>
</x-app-layout>