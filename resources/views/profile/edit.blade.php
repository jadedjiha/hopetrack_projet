<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-gray-800">Mon profil</h1>
    </x-slot>

    <div class="max-w-3xl space-y-5">

        @if(session('status') === 'profile-updated')
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl px-4 py-3 text-sm font-medium">✓ Profil mis à jour</div>
        @endif
        @if(session('status') === 'password-updated')
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl px-4 py-3 text-sm font-medium">✓ Mot de passe mis à jour</div>
        @endif

        <!-- Infos personnelles -->
        <div class="bg-white border border-gray-200 rounded-xl p-6">
            <h2 class="text-sm font-semibold text-gray-900 mb-5">Informations personnelles</h2>

            @if($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 text-sm">
                <ul class="list-disc list-inside space-y-1">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
                @csrf @method('PATCH')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Nom complet *</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="input-field">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Email *</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="input-field">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Téléphone</label>
                        <input type="text" name="telephone" value="{{ old('telephone', $user->telephone) }}" placeholder="+229 XX XX XX XX" class="input-field">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Poste</label>
                        <input type="text" name="poste" value="{{ old('poste', $user->poste) }}" placeholder="Ex: Développeur..." class="input-field">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Département</label>
                        <input type="text" name="departement" value="{{ old('departement', $user->departement) }}" placeholder="Ex: Informatique..." class="input-field">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Date d'embauche</label>
                        <input type="date" name="date_embauche" value="{{ old('date_embauche', $user->date_embauche ? \Carbon\Carbon::parse($user->date_embauche)->format('Y-m-d') : '') }}" class="input-field">
                    </div>
                </div>

                <div class="flex items-center gap-2 p-3 bg-gray-50 rounded-lg">
                    <span class="text-xs text-gray-500">Rôle :</span>
                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-emerald-100 text-emerald-800' }}">
                        {{ ucfirst($user->role) }}
                    </span>
                    <span class="text-xs text-gray-400">(non modifiable)</span>
                </div>

                <button type="submit" class="btn-primary">Enregistrer les modifications</button>
            </form>
        </div>

        <!-- Mot de passe -->
        <div class="bg-white border border-gray-200 rounded-xl p-6">
            <h2 class="text-sm font-semibold text-gray-900 mb-5">Changer le mot de passe</h2>

            @if($errors->updatePassword->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 text-sm">
                <ul class="list-disc list-inside space-y-1">@foreach($errors->updatePassword->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                @csrf @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Mot de passe actuel</label>
                        <input type="password" name="current_password" autocomplete="current-password" class="input-field">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Nouveau</label>
                        <input type="password" name="password" autocomplete="new-password" class="input-field">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Confirmer</label>
                        <input type="password" name="password_confirmation" autocomplete="new-password" class="input-field">
                    </div>
                </div>
                <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white font-semibold px-5 py-2.5 rounded-xl transition-colors text-sm">Mettre à jour le mot de passe</button>
            </form>
        </div>

        <!-- Zone danger -->
        <div class="bg-white border border-red-200 rounded-xl p-6">
            <h2 class="text-sm font-semibold text-red-600 mb-2">Zone dangereuse</h2>
            <p class="text-sm text-gray-500 mb-4">La suppression de votre compte est définitive et irréversible.</p>
            <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                class="btn-danger">Supprimer mon compte</button>

            <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                <form method="POST" action="{{ route('profile.destroy') }}" class="p-6">
                    @csrf @method('DELETE')
                    <h2 class="text-base font-bold text-gray-900 mb-1">Confirmer la suppression</h2>
                    <p class="text-sm text-gray-500 mb-4">Entrez votre mot de passe pour confirmer.</p>
                    <input type="password" name="password" placeholder="Votre mot de passe" class="input-field mb-2">
                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mb-4" />
                    <div class="flex justify-end gap-3">
                        <x-secondary-button x-on:click="$dispatch('close')">Annuler</x-secondary-button>
                        <x-danger-button>Supprimer définitivement</x-danger-button>
                    </div>
                </form>
            </x-modal>
        </div>

    </div>
</x-app-layout>
