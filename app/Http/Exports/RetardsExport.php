<?php

namespace App\Exports;

use App\Models\Pointage;
use Maatwebsite\Excel\Concerns\FromCollection;

class RetardsExport implements FromCollection
{
    public function collection()
    {
        return Pointage::with('user')
            ->where('minutes_retard', '>', 0)
            ->get();
    }
}
