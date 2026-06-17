<?php

namespace App\Exports;

use App\Models\Pointage;
use Maatwebsite\Excel\Concerns\FromCollection;

class PointagesExport implements FromCollection
{
    public function collection()
    {
        return Pointage::with('user')->get();
    }
}
