<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PointageController;
use App\Http\Controllers\TacheController;
use App\Http\Controllers\CongeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\RapportController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {

    // 📍 Dashboard & Pointage
    Route::get('/dashboard', [PointageController::class, 'index'])->name('dashboard');
    Route::post('/pointage', [PointageController::class, 'store'])->name('pointage.store');
    Route::get('/pointages/historique', [PointageController::class, 'historique'])->name('pointages.historique');

    // ✅ Tâches
    Route::get('/taches', [TacheController::class, 'index'])->name('taches.index');
    Route::post('/taches', [TacheController::class, 'store'])->name('taches.store');
    Route::get('/taches/{id}/edit', [TacheController::class, 'edit'])->name('taches.edit');
    Route::put('/taches/{id}', [TacheController::class, 'update'])->name('taches.update');
    Route::put('/taches/{id}/admin', [TacheController::class, 'adminUpdate'])->name('taches.adminUpdate');
    Route::delete('/taches/{id}', [TacheController::class, 'destroy'])->name('taches.destroy');

    // 🏖️ Congés
    Route::get('/conges', [CongeController::class, 'index'])->name('conges.index');
    Route::get('/conges/create', [CongeController::class, 'create'])->name('conges.create');
    Route::post('/conges', [CongeController::class, 'store'])->name('conges.store');
    Route::patch('/conges/{id}/approuver', [CongeController::class, 'approuver'])->name('conges.approuver');
    Route::patch('/conges/{id}/refuser', [CongeController::class, 'refuser'])->name('conges.refuser');
    Route::delete('/conges/{id}', [CongeController::class, 'destroy'])->name('conges.destroy');
    Route::delete('/conges/{id}/annuler', [CongeController::class, 'annuler'])->name('conges.annuler');

    // 👤 Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 👥 Gestion des employés (admin)
    Route::get('/employes', [EmployeController::class, 'index'])->name('employes.index');
    Route::get('/employes/create', [EmployeController::class, 'create'])->name('employes.create');
    Route::post('/employes', [EmployeController::class, 'store'])->name('employes.store');
    Route::get('/employes/{id}', [EmployeController::class, 'show'])->name('employes.show');
    Route::get('/employes/{id}/edit', [EmployeController::class, 'edit'])->name('employes.edit');
    Route::put('/employes/{id}', [EmployeController::class, 'update'])->name('employes.update');
    Route::patch('/employes/{id}/toggle', [EmployeController::class, 'toggleActif'])->name('employes.toggle');
    Route::delete('/employes/{id}', [EmployeController::class, 'destroy'])->name('employes.destroy');

    //Gestion des rapport 
    Route::get('/rapports', [RapportController::class, 'index'])
        ->name('rapports.index');

    Route::get('/rapports/presences/pdf', [RapportController::class, 'presencesPdf'])
        ->name('rapports.presences.pdf');

    Route::get('/rapports/conges/pdf', [RapportController::class, 'congesPdf'])
        ->name('rapports.conges.pdf');

    Route::get('/rapports/retards/pdf', [RapportController::class, 'retardsPdf'])
        ->name('rapports.retards.pdf');

    Route::get(
        '/rapports/presences/excel',
        [RapportController::class, 'presencesExcel']
    )
        ->name('rapports.presences.excel');

    Route::get(
        '/rapports/conges/excel',
        [RapportController::class, 'congesExcel']
    )
        ->name('rapports.conges.excel');

    Route::get(
        '/rapports/retards/excel',
        [RapportController::class, 'retardsExcel']
    )
        ->name('rapports.retards.excel');
});

// ⚠️ TRÈS IMPORTANT (NE JAMAIS SUPPRIMER)
require __DIR__ . '/auth.php';
