<?php

namespace App\Http\Controllers;

use App\Models\Pointage;
use App\Models\Conge;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

use App\Exports\PointagesExport;
use App\Exports\CongesExport;
use App\Exports\RetardsExport;

class RapportController extends Controller
{
    public function index()
    {
        return view('rapports.index');
    }
    public function presencesPdf()
    {
        if (Auth::user()->role === 'admin') {

            $pointages = Pointage::with('user')
                ->whereHas('user', function ($q) {
                    $q->where('role', '!=', 'admin');
                })
                ->latest()
                ->get();
        } else {

            $pointages = Pointage::with('user')
                ->where('user_id', Auth::id())
                ->latest()
                ->get();
        }

        $pdf = Pdf::loadView(
            'rapports.presences-pdf',
            compact('pointages')
        );

        return $pdf->download('rapport_presences.pdf');
    }

    public function congesPdf()
    {
        if (Auth::user()->role === 'admin') {

            $conges = Conge::with('user')
                ->whereHas('user', function ($q) {
                    $q->where('role', '!=', 'admin');
                })
                ->latest()
                ->get();
        } else {

            $conges = Conge::with('user')
                ->where('user_id', Auth::id())
                ->latest()
                ->get();
        }


        $pdf = Pdf::loadView('rapports.conges-pdf', compact('conges'));

        return $pdf->download('rapport_conges.pdf');
    }

    public function retardsPdf()
    {
        if (Auth::user()->role === 'admin') {

            $retards = Pointage::with('user')
                ->whereHas('user', function ($q) {
                    $q->where('role', '!=', 'admin');
                })
                ->where('minutes_retard', '>', 0)
                ->orderByDesc('minutes_retard')
                ->get();
        } else {

            $retards = Pointage::with('user')
                ->where('user_id', Auth::id())
                ->where('minutes_retard', '>', 0)
                ->orderByDesc('minutes_retard')
                ->get();
        }

        $pdf = Pdf::loadView(
            'rapports.retards-pdf',
            compact('retards')
        );

        return $pdf->download('rapport_retards.pdf');
    }


    public function presencesExcel()
    {
        return Excel::download(
            new PointagesExport,
            'rapport_presences.xlsx'
        );
    }

    public function congesExcel()
    {
        return Excel::download(
            new CongesExport,
            'rapport_conges.xlsx'
        );
    }

    public function retardsExcel()
    {
        return Excel::download(
            new RetardsExport,
            'rapport_retards.xlsx'
        );
    }
}
