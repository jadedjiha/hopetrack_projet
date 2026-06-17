<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeController extends Controller
{
    // 📋 Liste des employés
    public function index()
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $employes = User::where('role', 'employe')
            ->withCount(['pointages', 'taches', 'conges'])
            ->latest()
            ->get();

        return view('admin.employes.index', compact('employes'));
    }

    // ➕ Formulaire création
    public function create()
    {
        abort_if(auth()->user()->role !== 'admin', 403);
        return view('admin.employes.create');
    }

    // 💾 Enregistrement
    public function store(Request $request)
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:6|confirmed',
            'telephone'     => 'nullable|string|max:20',
            'poste'         => 'nullable|string|max:255',
            'departement'   => 'nullable|string|max:255',
            'date_embauche' => 'nullable|date',
        ]);

        User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'role'          => 'employe',
            'telephone'     => $request->telephone,
            'poste'         => $request->poste,
            'departement'   => $request->departement,
            'date_embauche' => $request->date_embauche,
            'is_active'     => true,
        ]);

        return redirect()->route('employes.index')
            ->with('success', 'Employé créé avec succès ✅');
    }

    // 👁️ Fiche employé
    public function show($id)
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $employe = User::where('role', 'employe')->findOrFail($id);

        $pointages = $employe->pointages()->latest()->take(10)->get();
        $taches    = $employe->taches()->latest()->take(10)->get();
        $conges    = $employe->conges()->latest()->take(5)->get();

        return view('admin.employes.show', compact('employe', 'pointages', 'taches', 'conges'));
    }

    // ✏️ Formulaire édition
    public function edit($id)
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $employe = User::where('role', 'employe')->findOrFail($id);
        return view('admin.employes.edit', compact('employe'));
    }

    // 💾 Mise à jour
    public function update(Request $request, $id)
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $employe = User::where('role', 'employe')->findOrFail($id);

        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,' . $employe->id,
            'telephone'     => 'nullable|string|max:20',
            'poste'         => 'nullable|string|max:255',
            'departement'   => 'nullable|string|max:255',
            'date_embauche' => 'nullable|date',
        ]);

        $data = $request->only(['name', 'email', 'telephone', 'poste', 'departement', 'date_embauche']);

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6|confirmed']);
            $data['password'] = Hash::make($request->password);
        }

        $employe->update($data);

        return redirect()->route('employes.index')
            ->with('success', 'Employé mis à jour ✅');
    }

    // 🔄 Activer / Désactiver
    public function toggleActif($id)
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $employe = User::where('role', 'employe')->findOrFail($id);
        $employe->update(['is_active' => !$employe->is_active]);

        $msg = $employe->is_active ? 'Employé activé ✅' : 'Employé désactivé ⛔';
        return back()->with('success', $msg);
    }

    // 🗑️ Suppression
    public function destroy($id)
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $employe = User::where('role', 'employe')->findOrFail($id);
        $employe->delete();

        return redirect()->route('employes.index')
            ->with('success', 'Employé supprimé ✅');
    }
}
