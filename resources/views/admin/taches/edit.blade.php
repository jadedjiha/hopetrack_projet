<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('taches.index') }}" class="text-gray-400 hover:text-gray-700 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h1 class="text-lg font-semibold text-gray-800">Modifier la tâche</h1>
        </div>
    </x-slot>

    <div class="max-w-2xl">
        <div class="bg-white border border-gray-200 rounded-xl p-6">

            @if($errors->any())
            <div class="mb-5 bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('taches.adminUpdate', $tache->id) }}" class="space-y-5">
                @csrf @method('PUT')

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Employé assigné *</label>
                    <select name="user_id" class="input-field">
                        @foreach($employes as $e)
                        <option value="{{ $e->id }}" {{ $tache->user_id == $e->id ? 'selected' : '' }}>{{ $e->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Titre *</label>
                    <input type="text" name="titre" value="{{ old('titre', $tache->titre) }}" class="input-field">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Description *</label>
                    <textarea name="description" rows="3" class="input-field">{{ old('description', $tache->description) }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Priorité</label>
                        <select name="priorite" class="input-field">
                            <option value="faible"  {{ $tache->priorite === 'faible'  ? 'selected' : '' }}>Faible</option>
                            <option value="moyenne" {{ $tache->priorite === 'moyenne' ? 'selected' : '' }}>Moyenne</option>
                            <option value="haute"   {{ $tache->priorite === 'haute'   ? 'selected' : '' }}>Haute</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Statut</label>
                        <select name="statut" class="input-field">
                            <option value="en_attente" {{ $tache->statut === 'en_attente' ? 'selected' : '' }}>En attente</option>
                            <option value="en_cours"   {{ $tache->statut === 'en_cours'   ? 'selected' : '' }}>En cours</option>
                            <option value="terminee"   {{ $tache->statut === 'terminee'   ? 'selected' : '' }}>Terminée</option>
                            <option value="rejetee"    {{ $tache->statut === 'rejetee'    ? 'selected' : '' }}>Rejetée</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Date limite</label>
                        <input type="date" name="date_limite"
                            value="{{ old('date_limite', $tache->date_limite ? $tache->date_limite->format('Y-m-d') : '') }}"
                            class="input-field">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Commentaire</label>
                        <input type="text" name="commentaire" value="{{ old('commentaire', $tache->commentaire) }}" placeholder="Optionnel..." class="input-field">
                    </div>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="btn-primary">Enregistrer</button>
                    <a href="{{ route('taches.index') }}" class="btn-gray">Annuler</a>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
