<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('employes.index') }}" class="text-gray-400 hover:text-gray-700 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-lg font-semibold text-gray-800">Nouvel employé</h1>
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

            <form method="POST" action="{{ route('employes.store') }}" class="space-y-5">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Nom complet *</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="input-field">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Email *</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="input-field">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Mot de passe *</label>
                        <input type="password" name="password" class="input-field">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Confirmer le mot de passe *</label>
                        <input type="password" name="password_confirmation" class="input-field">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Téléphone</label>
                        <input type="text" name="telephone" value="{{ old('telephone') }}" placeholder="+229 XX XX XX XX" class="input-field">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Poste</label>
                        <input type="text" name="poste" value="{{ old('poste') }}" placeholder="Ex: Développeur, Comptable..." class="input-field">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Département</label>
                        <input type="text" name="departement" value="{{ old('departement') }}" placeholder="Ex: Informatique, RH..." class="input-field">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Date d'embauche</label>
                        <input type="date" name="date_embauche" value="{{ old('date_embauche') }}" class="input-field">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Photo
                        </label>

                        <input type="file"
                            name="photo"
                            class="w-full border rounded-xl p-3">
                    </div>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="btn-primary">Créer l'employé</button>
                    <a href="{{ route('employes.index') }}" class="btn-gray">Annuler</a>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>