<?php

namespace App\Exports;

use App\Models\Conge; // Remplace par ton modèle si différent
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CongesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Conge::with('user')->get(); // Charge la relation user si elle existe
    }

    public function headings(): array
    {
        return [
            'ID',
            'ID Utilisateur',
            'Nom de l\'utilisateur',
            'Type de congé',
            'Date de début',
            'Date de fin',
            'Statut',
            'Raison',
            'Créé le',
        ];
    }
}
