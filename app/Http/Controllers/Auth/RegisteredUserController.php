<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Afficher la page d'inscription
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Traiter l'inscription
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'employe', // 👈 PAR DÉFAUT
        ]);

        // Événement Laravel
        event(new Registered($user));

        // ❌ PAS DE connexion automatique
        // Auth::login($user);

        // ✅ Redirection vers login
        return redirect()->route('login')->with('success', 'Compte créé avec succès, veuillez vous connecter.');
    }
}
