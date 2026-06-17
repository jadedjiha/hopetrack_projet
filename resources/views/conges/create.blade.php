<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('conges.index') }}" class="text-gray-400 hover:text-gray-700 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h1 class="text-lg font-semibold text-gray-800">Nouvelle demande de congé</h1>
        </div>
    </x-slot>

    <div class="max-w-2xl">
        <div class="bg-white border border-gray-200 rounded-xl p-6">

            @if($errors->any())
            <div class="mb-5 bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 text-sm">
                <ul class="list-disc list-inside space-y-1">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
            @endif

            <form method="POST" action="{{ route('conges.store') }}" class="space-y-5" id="congeForm">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Type de demande</label>
                    <select name="type" id="typeSelect" onchange="toggleHeures(this.value)" class="input-field">
                        <option value="conge"      {{ old('type') === 'conge'      ? 'selected' : '' }}>Congé</option>
                        <option value="permission" {{ old('type') === 'permission' ? 'selected' : '' }}>Permission</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Motif *</label>
                    <input type="text" name="motif" value="{{ old('motif') }}" placeholder="Ex: Congé annuel, Maladie..." class="input-field">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Description <span class="text-gray-400 normal-case font-normal">(optionnel)</span></label>
                    <textarea name="description" rows="3" placeholder="Détails supplémentaires..." class="input-field">{{ old('description') }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Date de début *</label>
                        <input type="date" name="date_debut" value="{{ old('date_debut') }}" id="dateDebut" onchange="calculerJours()" class="input-field">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Date de fin *</label>
                        <input type="date" name="date_fin" value="{{ old('date_fin') }}" id="dateFin" onchange="calculerJours()" class="input-field">
                    </div>
                </div>

                <div id="compteurJours" class="hidden bg-indigo-50 border border-indigo-100 rounded-lg px-4 py-2.5 text-sm font-semibold text-indigo-700"></div>

                <div id="heuresSection" class="{{ old('type') === 'permission' ? '' : 'hidden' }} space-y-4 p-4 bg-gray-50 border border-gray-200 rounded-xl">
                    <p class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Horaires de la permission</p>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Heure de début</label>
                            <input type="time" name="heure_debut" value="{{ old('heure_debut') }}" class="input-field">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Heure de fin</label>
                            <input type="time" name="heure_fin" value="{{ old('heure_fin') }}" class="input-field">
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="btn-primary">Envoyer la demande</button>
                    <a href="{{ route('conges.index') }}" class="btn-gray">Annuler</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleHeures(type) {
            document.getElementById('heuresSection').classList.toggle('hidden', type !== 'permission');
        }
        function calculerJours() {
            const d1 = new Date(document.getElementById('dateDebut').value);
            const d2 = new Date(document.getElementById('dateFin').value);
            const el = document.getElementById('compteurJours');
            if (document.getElementById('dateDebut').value && document.getElementById('dateFin').value) {
                const diff = Math.round((d2 - d1) / 86400000) + 1;
                if (diff > 0) { el.textContent = diff + ' jour(s) de congé'; el.classList.remove('hidden'); }
                else el.classList.add('hidden');
            }
        }
        toggleHeures(document.getElementById('typeSelect').value);
        calculerJours();
    </script>
</x-app-layout>
