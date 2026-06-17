<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-gray-800">Tableau de bord</h1>
    </x-slot>

    <div class="max-w-5xl space-y-6">

        @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl px-4 py-3 text-sm font-medium">
            ✓ {{ session('success') }}
        </div>
        @endif

        <!-- Stats -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Pointages ce mois</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_mois'] }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Jours présent</p>
                <p class="text-2xl font-bold text-emerald-600">{{ $stats['presents_mois'] }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Retards</p>
                <p class="text-2xl font-bold text-amber-600">{{ $stats['retards_mois'] }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Congés approuvés</p>
                <p class="text-2xl font-bold text-indigo-600">{{ $stats['conges_actifs'] }}</p>
            </div>
        </div>

        <!-- Pointage du jour -->
        <div class="bg-white border border-gray-200 rounded-xl p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-base font-semibold text-gray-900">Pointage du jour</h2>
                    <p class="text-sm text-gray-500">{{ now()->translatedFormat('l d F Y') }}</p>
                </div>
                <p class="text-xl font-bold text-indigo-600 tabular-nums" id="clock">--:--:--</p>
            </div>

            <!-- Message -->
            <div id="messageBox" class="hidden mb-4 px-4 py-3 rounded-lg text-sm font-medium"></div>

            <!-- Statut entrée / sortie -->
            <div class="grid grid-cols-2 gap-3 mb-5">
                <div class="rounded-lg border-2 p-3 {{ $pointageAujourdhui['entree'] ? 'border-emerald-300 bg-emerald-50' : 'border-gray-200 bg-gray-50' }}">
                    <p class="text-xs font-semibold uppercase tracking-wider mb-1 {{ $pointageAujourdhui['entree'] ? 'text-emerald-600' : 'text-gray-400' }}">Entrée</p>
                    @if($pointageAujourdhui['entree'])
                    <p class="text-lg font-bold text-gray-900">{{ $pointageAujourdhui['entree']->heure }}</p>
                    @if($pointageAujourdhui['entree']->statut === 'retard')
                    <span class="inline-block mt-1 text-xs font-semibold text-amber-700 bg-amber-100 px-2 py-0.5 rounded-full">Retard {{ $pointageAujourdhui['entree']->minutes_retard }}min</span>
                    @else
                    <span class="inline-block mt-1 text-xs font-semibold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-full">À l'heure</span>
                    @endif
                    @else
                    <p class="text-sm text-gray-400">Non pointée</p>
                    @endif
                </div>
                <div class="rounded-lg border-2 p-3 {{ $pointageAujourdhui['sortie'] ? 'border-blue-300 bg-blue-50' : 'border-gray-200 bg-gray-50' }}">
                    <p class="text-xs font-semibold uppercase tracking-wider mb-1 {{ $pointageAujourdhui['sortie'] ? 'text-blue-600' : 'text-gray-400' }}">Sortie</p>
                    @if($pointageAujourdhui['sortie'])
                    <p class="text-lg font-bold text-gray-900">{{ $pointageAujourdhui['sortie']->heure }}</p>
                    <span class="inline-block mt-1 text-xs font-semibold text-blue-700 bg-blue-100 px-2 py-0.5 rounded-full">Enregistrée</span>
                    @else
                    <p class="text-sm text-gray-400">Non pointée</p>
                    @endif
                </div>
            </div>

            <!-- Boutons -->
            <!-- Choix du site -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Site de travail
                </label>

                <select id="site"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500">
                    <option value="site1">Site de St Michel </option>
                    <option value="site2">Site de St Scoa-Gbeto</option>
                    <option value="site3">Site de Gbegamey</option>
                </select>
            </div>
            <div class="flex gap-3 flex-wrap">
                <button onclick="pointer('entree')" id="btnEntree"
                    {{ $pointageAujourdhui['entree'] ? 'disabled' : '' }}
                    class="{{ $pointageAujourdhui['entree'] ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : 'bg-emerald-600 hover:bg-emerald-700 text-white cursor-pointer' }} font-semibold px-5 py-2.5 rounded-lg text-sm transition-colors">
                    ↗ Pointer Entrée
                </button>
                <button onclick="pointer('sortie')" id="btnSortie"
                    {{ $pointageAujourdhui['sortie'] ? 'disabled' : '' }}
                    class="{{ $pointageAujourdhui['sortie'] ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : 'bg-blue-600 hover:bg-blue-700 text-white cursor-pointer' }} font-semibold px-5 py-2.5 rounded-lg text-sm transition-colors">
                    ↙ Pointer Sortie
                </button>
            </div>
        </div>

        <!-- Historique -->
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="text-base font-semibold text-gray-900">Historique récent</h2>
                <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2.5 py-1 rounded-full">{{ $pointages->count() }} entrées</span>
            </div>
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="table-header">Type</th>
                        <th class="table-header">Date</th>
                        <th class="table-header">Heure</th>
                        <th class="table-header">Statut</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pointages as $p)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="table-cell">
                            @if($p->type === 'entree')
                            <span class="badge-green">Entrée</span>
                            @else
                            <span class="badge-blue">Sortie</span>
                            @endif
                        </td>
                        <td class="table-cell text-gray-600">{{ $p->date->format('d/m/Y') }}</td>
                        <td class="table-cell font-medium">{{ $p->heure }}</td>
                        <td class="table-cell">
                            @if($p->type === 'sortie')
                            <span class="text-gray-400 text-xs">—</span>
                            @elseif($p->statut === 'retard')
                            <span class="badge-yellow">Retard {{ $p->minutes_retard }}min</span>
                            @else
                            <span class="badge-green">Présent</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="table-cell text-center text-gray-400 py-8">Aucun pointage</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    <script>
        function updateClock() {
            document.getElementById('clock').textContent = new Date().toLocaleTimeString('fr-FR');
        }
        updateClock();
        setInterval(updateClock, 1000);

        function showMessage(msg, ok) {
            const b = document.getElementById('messageBox');
            b.classList.remove('hidden');
            b.className = ok ?
                'mb-4 px-4 py-3 rounded-lg text-sm font-medium bg-emerald-50 border border-emerald-200 text-emerald-800' :
                'mb-4 px-4 py-3 rounded-lg text-sm font-medium bg-red-50 border border-red-200 text-red-800';
            b.textContent = msg;
        }

        function pointer(type) {
            const btn = document.getElementById(type === 'entree' ? 'btnEntree' : 'btnSortie');
            if (btn.disabled) return;
            if (!navigator.geolocation) {
                showMessage('GPS non disponible', false);
                return;
            }
            btn.disabled = true;
            btn.textContent = 'Localisation...';
            navigator.geolocation.getCurrentPosition(pos => {
                const site = document.getElementById('site').value;
                fetch("{{ route('pointage.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        type,
                        site,
                        latitude: pos.coords.latitude,
                        longitude: pos.coords.longitude
                    })
                }).then(r => r.json()).then(d => {
                    const ok = d.statut !== 'bloque';
                    showMessage(d.message, ok);
                    if (ok) setTimeout(() => location.reload(), 1500);
                    else btn.disabled = false;
                }).catch(() => {
                    showMessage('Erreur serveur', false);
                    btn.disabled = false;
                });
            }, () => {
                showMessage('Localisation refusée', false);
                btn.disabled = false;
            });
        }
    </script>
</x-app-layout>