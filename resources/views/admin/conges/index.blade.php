<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-gray-800">Gestion des congés</h1>
    </x-slot>

    <div class="space-y-5">

        @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl px-4 py-3 text-sm font-medium">✓ {{ session('success') }}</div>
        @endif

        <!-- Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            <div class="bg-white border border-gray-200 rounded-xl p-4"><p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Total</p><p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p></div>
            <div class="bg-white border border-gray-200 rounded-xl p-4"><p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">En attente</p><p class="text-2xl font-bold text-amber-600">{{ $stats['en_attente'] }}</p></div>
            <div class="bg-white border border-gray-200 rounded-xl p-4"><p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Approuvées</p><p class="text-2xl font-bold text-emerald-600">{{ $stats['approuve'] }}</p></div>
            <div class="bg-white border border-gray-200 rounded-xl p-4"><p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Refusées</p><p class="text-2xl font-bold text-red-500">{{ $stats['refuse'] }}</p></div>
        </div>

        <!-- Filtres -->
        <div class="bg-white border border-gray-200 rounded-xl px-4 py-3">
            <form method="GET" action="{{ route('conges.index') }}" class="flex flex-wrap gap-3 items-end">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Statut</label>
                    <select name="statut" class="input-field !py-2 !w-auto">
                        <option value="">Tous</option>
                        <option value="en_attente" {{ request('statut') === 'en_attente' ? 'selected' : '' }}>En attente</option>
                        <option value="approuve"   {{ request('statut') === 'approuve'   ? 'selected' : '' }}>Approuvé</option>
                        <option value="refuse"     {{ request('statut') === 'refuse'     ? 'selected' : '' }}>Refusé</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Type</label>
                    <select name="type" class="input-field !py-2 !w-auto">
                        <option value="">Tous</option>
                        <option value="conge"      {{ request('type') === 'conge'      ? 'selected' : '' }}>Congé</option>
                        <option value="permission" {{ request('type') === 'permission' ? 'selected' : '' }}>Permission</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Employé</label>
                    <select name="employe_id" class="input-field !py-2 !w-auto">
                        <option value="">Tous</option>
                        @foreach($employes as $e)<option value="{{ $e->id }}" {{ request('employe_id') == $e->id ? 'selected' : '' }}>{{ $e->name }}</option>@endforeach
                    </select>
                </div>
                <button type="submit" class="btn-primary">Filtrer</button>
                @if(request()->hasAny(['statut','type','employe_id']))
                <a href="{{ route('conges.index') }}" class="text-sm text-gray-400 hover:text-gray-600 py-2">Réinitialiser</a>
                @endif
            </form>
        </div>

        <!-- Table -->
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="text-sm font-semibold text-gray-900">Demandes de congé</h2>
                <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2.5 py-1 rounded-full">{{ $conges->count() }}</span>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="table-header">Employé</th>
                            <th class="table-header">Type</th>
                            <th class="table-header">Motif</th>
                            <th class="table-header">Période</th>
                            <th class="table-header">Jours</th>
                            <th class="table-header">Statut</th>
                            <th class="table-header">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($conges as $c)
                        <tr class="hover:bg-gray-50 transition-colors" x-data="{ showRefus: false }">
                            <td class="table-cell font-medium text-gray-900">{{ $c->user->name ?? 'N/A' }}</td>
                            <td class="table-cell">
                                <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $c->type === 'conge' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">{{ ucfirst($c->type) }}</span>
                            </td>
                            <td class="table-cell">
                                <p class="text-gray-900">{{ $c->motif }}</p>
                                @if($c->description)<p class="text-xs text-gray-400 mt-0.5">{{ Str::limit($c->description, 40) }}</p>@endif
                            </td>
                            <td class="table-cell text-gray-600">{{ $c->date_debut->format('d/m/Y') }} → {{ $c->date_fin->format('d/m/Y') }}</td>
                            <td class="table-cell text-center font-semibold text-gray-700">{{ $c->nombre_jours }}j</td>
                            <td class="table-cell">
                                @if($c->statut === 'en_attente')
                                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-amber-100 text-amber-800">En attente</span>
                                @elseif($c->statut === 'approuve')
                                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800">Approuvé</span>
                                    @if($c->traite_le)<p class="text-xs text-gray-400 mt-0.5">{{ $c->traite_le->format('d/m/Y') }}</p>@endif
                                @else
                                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-red-100 text-red-800">Refusé</span>
                                    @if($c->commentaire_admin)<p class="text-xs text-gray-400 mt-0.5 italic">{{ Str::limit($c->commentaire_admin, 30) }}</p>@endif
                                @endif
                            </td>
                            <td class="table-cell">
                                @if($c->statut === 'en_attente')
                                <div class="space-y-1.5">
                                    <form method="POST" action="{{ route('conges.approuver', $c->id) }}">
                                        @csrf @method('PATCH')
                                        <button class="w-full bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors">Approuver</button>
                                    </form>
                                    <button @click="showRefus = !showRefus" class="w-full bg-red-50 hover:bg-red-100 text-red-700 text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors border border-red-200">Refuser</button>
                                    <div x-show="showRefus" x-cloak>
                                        <form method="POST" action="{{ route('conges.refuser', $c->id) }}">
                                            @csrf @method('PATCH')
                                            <textarea name="commentaire_admin" rows="2" placeholder="Motif du refus..." class="input-field !text-xs mb-1"></textarea>
                                            <button class="w-full bg-red-600 hover:bg-red-700 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors">Confirmer</button>
                                        </form>
                                    </div>
                                </div>
                                @else
                                <div class="flex items-center gap-2">
                                    <span class="text-xs text-gray-400">Traité</span>
                                    <form method="POST" action="{{ route('conges.destroy', $c->id) }}" onsubmit="return confirm('Supprimer ?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-400 hover:text-red-600 text-xs transition-colors">Supprimer</button>
                                    </form>
                                </div>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="table-cell text-center text-gray-400 py-10">Aucune demande trouvée.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
