<?php

namespace App\Exports;

use App\Models\Pointage; // Remplace par ton modèle
use Maatwebsite\Excel\Concerns\FromCollection;

class PointagesExport implements FromCollection
{
    public function collection()
    {
        return Pointage::all(); // ou une requête personnalisée
    }
}
