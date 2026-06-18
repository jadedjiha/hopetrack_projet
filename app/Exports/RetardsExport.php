<?php

namespace App\Exports;

use App\Models\Pointage; // ✅ On utilise le modèle Pointage
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RetardsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // On utilise le scope retards() pour filtrer les pointages en retard
        return Pointage::retards()
            ->with('user')
            ->get()
            ->map(function ($pointage) {
                return [
                    $pointage->id,
                    $pointage->user_id,
                    $pointage->user->name ?? 'N/A',
                    $pointage->date->format('d/m/Y'),
                    $pointage->heure,
                    $pointage->minutes_retard, // Durée du retard
                    $pointage->statut,
                    $pointage->note ?? 'Aucune',
                    $pointage->site,
                    $pointage->created_at->format('d/m/Y H:i'),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID',
            'ID Utilisateur',
            'Nom',
            'Date',
            'Heure',
            'Minutes de retard',
            'Statut',
            'Note',
            'Site',
            'Créé le',
        ];
    }
}
