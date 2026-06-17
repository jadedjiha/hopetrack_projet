<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conge;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CongeController extends Controller
{
    // 📄 Liste des demandes
    public function index(Request $request)
    {
        $user = Auth::user();

        // 👑 ADMIN
        if ($user->role === 'admin') {

            $query = Conge::with('user')->latest();

            if ($request->filled('statut')) {
                $query->where('statut', $request->statut);
            }
            if ($request->filled('type')) {
                $query->where('type', $request->type);
            }
            if ($request->filled('employe_id')) {
                $query->where('user_id', $request->employe_id);
            }

            $conges   = $query->get();
            $employes = User::where('role', 'employe')->get();

            $stats = [
                'total'       => Conge::count(),
                'en_attente'  => Conge::where('statut', 'en_attente')->count(),
                'approuve'    => Conge::where('statut', 'approuve')->count(),
                'refuse'      => Conge::where('statut', 'refuse')->count(),
            ];

            return view('admin.conges.index', compact('conges', 'employes', 'stats'));
        }

        // 👷 EMPLOYÉ
        $query = Conge::where('user_id', Auth::id())->latest();

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $conges = $query->get();

        $stats = [
            'total'      => Conge::where('user_id', Auth::id())->count(),
            'en_attente' => Conge::where('user_id', Auth::id())->where('statut', 'en_attente')->count(),
            'approuve'   => Conge::where('user_id', Auth::id())->where('statut', 'approuve')->count(),
            'refuse'     => Conge::where('user_id', Auth::id())->where('statut', 'refuse')->count(),
        ];

        return view('conges.index', compact('conges', 'stats'));
    }

    // ➕ Formulaire création
    public function create()
    {
        return view('conges.create');
    }

    // 💾 Enregistrement
    public function store(Request $request)
    {
        $request->validate([
            'type'       => 'required|in:conge,permission',
            'motif'      => 'required|string|max:255',
            'date_debut' => 'required|date',
            'date_fin'   => 'required|date|after_or_equal:date_debut',
        ]);

        $debut       = \Carbon\Carbon::parse($request->date_debut);
        $fin         = \Carbon\Carbon::parse($request->date_fin);
        $nombreJours = $debut->diffInDays($fin) + 1;

        Conge::create([
            'user_id'      => Auth::id(),
            'type'         => $request->type,
            'motif'        => $request->motif,
            'description'  => $request->description,
            'date_debut'   => $request->date_debut,
            'date_fin'     => $request->date_fin,
            'heure_debut'  => $request->heure_debut,
            'heure_fin'    => $request->heure_fin,
            'nombre_jours' => $nombreJours,
        ]);

        return redirect()->route('conges.index')
            ->with('success', 'Demande envoyée avec succès ✅');
    }

    // ✅ ADMIN — Approuver
    public function approuver($id)
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $conge = Conge::findOrFail($id);

        abort_if($conge->statut !== 'en_attente', 422);

        $conge->update([
            'statut'    => 'approuve',
            'traite_par' => Auth::id(),
            'traite_le' => now(),
        ]);

        return back()->with('success', 'Demande approuvée ✅');
    }

    // ❌ ADMIN — Refuser
    public function refuser(Request $request, $id)
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $conge = Conge::findOrFail($id);

        abort_if($conge->statut !== 'en_attente', 422);

        $request->validate([
            'commentaire_admin' => 'nullable|string|max:500',
        ]);

        $conge->update([
            'statut'            => 'refuse',
            'traite_par'        => Auth::id(),
            'traite_le'         => now(),
            'commentaire_admin' => $request->commentaire_admin,
        ]);

        return back()->with('success', 'Demande refusée ❌');
    }

    // 🗑️ ADMIN — Supprimer
    public function destroy($id)
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        Conge::findOrFail($id)->delete();

        return back()->with('success', 'Demande supprimée ✅');
    }

    // ↩️ EMPLOYÉ — Annuler sa propre demande (si en attente)
    public function annuler($id)
    {
        $conge = Conge::where('user_id', Auth::id())->findOrFail($id);

        abort_if($conge->statut !== 'en_attente', 422);

        $conge->delete();

        return back()->with('success', 'Demande annulée ✅');
    }
}
