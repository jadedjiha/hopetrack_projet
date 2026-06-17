<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-lg font-semibold text-gray-800">Mes congés</h1>
            <a href="{{ route('conges.create') }}" class="btn-success">+ Nouvelle demande</a>
        </div>
    </x-slot>

    <div class="max-w-4xl space-y-5">

        @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl px-4 py-3 text-sm font-medium">✓ {{ session('success') }}</div>
        @endif

        <!-- Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Total</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">En attente</p>
                <p class="text-2xl font-bold text-amber-600">{{ $stats['en_attente'] }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Approuvées</p>
                <p class="text-2xl font-bold text-emerald-600">{{ $stats['approuve'] }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Refusées</p>
                <p class="text-2xl font-bold text-red-500">{{ $stats['refuse'] }}</p>
            </div>
        </div>

        <!-- Filtre -->
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
                <button type="submit" class="btn-primary">Filtrer</button>
                @if(request('statut'))
                <a href="{{ route('conges.index') }}" class="text-sm text-gray-400 hover:text-gray-600 py-2">Réinitialiser</a>
                @endif
            </form>
        </div>

        <!-- Liste -->
        <div class="space-y-3">
        @forelse($conges as $c)
        <div class="bg-white border border-gray-200 rounded-xl p-5
            {{ $c->statut === 'approuve' ? 'border-l-4 border-l-emerald-400' : ($c->statut === 'refuse' ? 'border-l-4 border-l-red-400' : 'border-l-4 border-l-amber-400') }}">
            <div class="flex justify-between items-start gap-4">
                <div class="flex-1">
                    <div class="flex flex-wrap items-center gap-2 mb-1.5">
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $c->type === 'conge' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                            {{ ucfirst($c->type) }}
                        </span>
                        <span class="font-semibold text-gray-900">{{ $c->motif }}</span>
                    </div>
                    @if($c->description)
                    <p class="text-sm text-gray-500 mb-2">{{ $c->description }}</p>
                    @endif
                    <div class="flex flex-wrap gap-4 text-sm text-gray-500">
                        <span>{{ $c->date_debut->format('d/m/Y') }} → {{ $c->date_fin->format('d/m/Y') }}</span>
                        <span class="font-semibold text-gray-700">{{ $c->nombre_jours }} jour(s)</span>
                        <span class="text-xs text-gray-400">Soumis le {{ $c->created_at->format('d/m/Y') }}</span>
                    </div>
                    @if($c->statut === 'refuse' && $c->commentaire_admin)
                    <div class="mt-2 p-3 bg-red-50 border border-red-100 rounded-lg">
                        <p class="text-xs font-semibold text-red-600 mb-0.5">Motif du refus</p>
                        <p class="text-sm text-red-700">{{ $c->commentaire_admin }}</p>
                    </div>
                    @endif
                    @if($c->traite_le)
                    <p class="text-xs text-gray-400 mt-1.5">Traité le {{ $c->traite_le->format('d/m/Y à H:i') }}</p>
                    @endif
                </div>
                <div class="flex flex-col items-end gap-2 shrink-0">
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                        {{ $c->statut === 'en_attente' ? 'bg-amber-100 text-amber-800' : ($c->statut === 'approuve' ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800') }}">
                        {{ $c->statut === 'en_attente' ? 'En attente' : ($c->statut === 'approuve' ? 'Approuvé' : 'Refusé') }}
                    </span>
                    @if($c->statut === 'en_attente')
                    <form method="POST" action="{{ route('conges.annuler', $c->id) }}" onsubmit="return confirm('Annuler cette demande ?')">
                        @csrf @method('DELETE')
                        <button class="text-xs text-gray-400 hover:text-red-500 transition-colors font-medium">Annuler</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white border border-gray-200 rounded-xl p-12 text-center">
            <p class="text-gray-400 text-sm mb-3">Aucune demande pour le moment</p>
            <a href="{{ route('conges.create') }}" class="btn-primary">Faire une demande</a>
        </div>
        @endforelse
        </div>

    </div>
</x-app-layout>
