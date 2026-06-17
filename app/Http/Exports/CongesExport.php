<?php

namespace App\Exports;

use App\Models\Conge;
use Maatwebsite\Excel\Concerns\FromCollection;

class CongesExport implements FromCollection
{
    public function collection()
    {
        return Conge::with('user')->get();
    }
}
