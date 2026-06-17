<?php

namespace App\Http\Controllers;

use App\Models\Tache;
use App\Models\User;
use Illuminate\Http\Request;

class TacheController extends Controller
{
    // 📋 Liste des tâches
    public function index(Request $request)
    {
        $user = auth()->user();

        // 👑 ADMIN
        if ($user->role === 'admin') {

            $query = Tache::with('user')->latest();

            // Filtres
            if ($request->filled('statut')) {
                $query->where('statut', $request->statut);
            }
            if ($request->filled('priorite')) {
                $query->where('priorite', $request->priorite);
            }
            if ($request->filled('employe_id')) {
                $query->where('user_id', $request->employe_id);
            }

            $taches   = $query->get();
            $employes = User::where('role', 'employe')->get();

            // Stats rapides
            $stats = [
                'total'      => Tache::count(),
                'en_attente' => Tache::where('statut', 'en_attente')->count(),
                'en_cours'   => Tache::where('statut', 'en_cours')->count(),
                'terminee'   => Tache::where('statut', 'terminee')->count(),
                'rejetee'    => Tache::where('statut', 'rejetee')->count(),
            ];

            return view('admin.taches.index', compact('taches', 'employes', 'stats'));
        }

        // 👷 EMPLOYÉ
        $query = Tache::where('user_id', $user->id)->latest();

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $taches = $query->get();

        $stats = [
            'total'      => Tache::where('user_id', $user->id)->count(),
            'en_attente' => Tache::where('user_id', $user->id)->where('statut', 'en_attente')->count(),
            'en_cours'   => Tache::where('user_id', $user->id)->where('statut', 'en_cours')->count(),
            'terminee'   => Tache::where('user_id', $user->id)->where('statut', 'terminee')->count(),
        ];

        return view('taches.index', compact('taches', 'stats'));
    }

    // ➕ Création (admin)
    public function store(Request $request)
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $request->validate([
            'user_id'     => 'required|exists:users,id',
            'titre'       => 'required|string|max:255',
            'description' => 'required|string',
            'priorite'    => 'required|in:faible,moyenne,haute',
            'date_limite' => 'nullable|date|after_or_equal:today',
        ]);

        Tache::create([
            'user_id'     => $request->user_id,
            'admin_id'    => auth()->id(),
            'titre'       => $request->titre,
            'description' => $request->description,
            'priorite'    => $request->priorite,
            'date_limite' => $request->date_limite,
            'statut'      => 'en_attente',
        ]);

        return redirect()->back()->with('success', 'Tâche créée avec succès ✅');
    }

    // ✏️ Mise à jour statut (employé)
    public function update(Request $request, $id)
    {
        $tache = Tache::findOrFail($id);

        // Employé ne peut modifier que ses propres tâches
        if (auth()->user()->role === 'employe' && $tache->user_id !== auth()->id()) {
            abort(403);
        }

        // Bloquer si déjà clôturée
        if (in_array($tache->statut, ['terminee', 'rejetee'])) {
            return back()->with('error', 'Cette tâche est déjà clôturée ❌');
        }

        $request->validate([
            'statut'      => 'required|in:en_cours,terminee,rejetee',
            'commentaire' => 'nullable|string|max:1000',
        ]);

        $tache->statut      = $request->statut;
        $tache->commentaire = $request->commentaire;

        if (in_array($request->statut, ['terminee', 'rejetee'])) {
            $tache->termine_le = now();
        }

        $tache->save();

        $messages = [
            'terminee' => 'Tâche marquée comme terminée ✅',
            'rejetee'  => 'Tâche rejetée ❌',
            'en_cours' => 'Tâche mise en cours 🚀',
        ];

        return back()->with('success', $messages[$request->statut] ?? 'Tâche mise à jour ✅');
    }

    // ✏️ Modifier une tâche (admin)
    public function edit($id)
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $tache    = Tache::findOrFail($id);
        $employes = User::where('role', 'employe')->get();

        return view('admin.taches.edit', compact('tache', 'employes'));
    }

    // 💾 Enregistrer modification (admin)
    public function adminUpdate(Request $request, $id)
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $tache = Tache::findOrFail($id);

        $request->validate([
            'user_id'     => 'required|exists:users,id',
            'titre'       => 'required|string|max:255',
            'description' => 'required|string',
            'priorite'    => 'required|in:faible,moyenne,haute',
            'statut'      => 'required|in:en_attente,en_cours,terminee,rejetee',
            'date_limite' => 'nullable|date',
        ]);

        $tache->update([
            'user_id'     => $request->user_id,
            'titre'       => $request->titre,
            'description' => $request->description,
            'priorite'    => $request->priorite,
            'statut'      => $request->statut,
            'date_limite' => $request->date_limite,
            'commentaire' => $request->commentaire,
        ]);

        return redirect()->route('taches.index')->with('success', 'Tâche modifiée ✅');
    }

    // 🗑️ Supprimer (admin)
    public function destroy($id)
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        Tache::findOrFail($id)->delete();

        return back()->with('success', 'Tâche supprimée ✅');
    }
}
