<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">
                📊 Centre de Rapports
            </h2>

            <p class="text-gray-500 mt-1">
                Génération et exportation des rapports de suivi des employés
            </p>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

        <!-- Présences -->
        <div class="bg-white rounded-2xl shadow border border-gray-100 p-6">

            <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center text-3xl mb-4">
                📍
            </div>

            <h3 class="text-xl font-bold text-gray-800">
                Rapport des Présences
            </h3>

            <p class="text-gray-500 mt-2 mb-6">
                Historique complet des pointages et présences des employés.
            </p>

            <div class="flex gap-3">

                <a href="{{ route('rapports.presences.pdf') }}"
                    class="flex-1 text-center bg-red-500 hover:bg-red-600 text-white py-3 rounded-xl font-semibold transition">
                    PDF
                </a>

                <a href="{{ route('rapports.presences.excel') }}"
                    class="flex-1 text-center bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-semibold transition">
                    Excel
                </a>

            </div>

        </div>

        <!-- Congés -->
        <div class="bg-white rounded-2xl shadow border border-gray-100 p-6">

            <div class="w-16 h-16 bg-yellow-100 rounded-xl flex items-center justify-center text-3xl mb-4">
                📅
            </div>

            <h3 class="text-xl font-bold text-gray-800">
                Rapport des Congés
            </h3>

            <p class="text-gray-500 mt-2 mb-6">
                Suivi des demandes de congés, permissions et validations.
            </p>

            <div class="flex gap-3">

                <a href="{{ route('rapports.conges.pdf') }}"
                    class="flex-1 text-center bg-red-500 hover:bg-red-600 text-white py-3 rounded-xl font-semibold transition">
                    PDF
                </a>

                <a href="{{ route('rapports.conges.excel') }}"
                    class="flex-1 text-center bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-semibold transition">
                    Excel
                </a>

            </div>

        </div>

        <!-- Retards -->
        <div class="bg-white rounded-2xl shadow border border-gray-100 p-6">

            <div class="w-16 h-16 bg-red-100 rounded-xl flex items-center justify-center text-3xl mb-4">
                ⏰
            </div>

            <h3 class="text-xl font-bold text-gray-800">
                Rapport des Retards
            </h3>

            <p class="text-gray-500 mt-2 mb-6">
                Analyse des retards enregistrés par les employés.
            </p>

            <div class="flex gap-3">

                <a href="{{ route('rapports.retards.pdf') }}"
                    class="flex-1 text-center bg-red-500 hover:bg-red-600 text-white py-3 rounded-xl font-semibold transition">
                    PDF
                </a>

                <a href="{{ route('rapports.retards.excel') }}"
                    class="flex-1 text-center bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-semibold transition">
                    Excel
                </a>

            </div>

        </div>

    </div>

</x-app-layout>