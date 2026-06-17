<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pointage;
use App\Models\User;
use App\Models\Conge;
use App\Models\Tache;

class PointageController extends Controller
{
    // 📍 Sites de l'entreprise (Géofencing)
    private $sites = [
        [
            'nom' => 'Site 1',
            'lat' => 6.364435652269113,
            'lng' => 2.4268071402473006,
        ],
        [
            'nom' => 'Site 2',
            'lat' => 6.363162502577201,
            'lng' => 2.4308809404723424,
        ],
        [
            'nom' => 'Site 3',
            'lat' => 6.367247505836985,
            'lng' => 2.408078913041647,
        ]
    ];

    // Distance maximale autorisée en mètres (1.5 km)
    private $distanceMax = 1500;

    public function index()
    {
        $user = auth()->user();

        if (!$user) {
            return redirect('/login');
        }

        $aujourdhui = now()->toDateString();

        // 👑 SECTION ADMIN
        if ($user->role === 'admin') {

            $pointages_aujourd_hui = Pointage::with('user')
                ->whereDate('date', $aujourdhui)
                ->latest()
                ->get();

            $conges_en_attente = Conge::with('user')
                ->where('statut', 'en_attente')
                ->latest()
                ->get();

            $stats = [
                'total_employes' => User::where('role', 'employe')
                    ->where('is_active', true)
                    ->count(),

                'presents_aujourd_hui' => Pointage::whereDate('date', $aujourdhui)
                    ->where('type', 'entree')
                    ->count(),

                'conges_en_attente' => $conges_en_attente->count(),

                'taches_en_cours' => Tache::where('statut', 'en_cours')->count(),
            ];

            return view('admin.dashboard', compact('pointages_aujourd_hui', 'stats', 'conges_en_attente'));
        }

        // 👷 SECTION EMPLOYÉ
        $pointages = Pointage::where('user_id', $user->id)
            ->latest()
            ->take(30)
            ->get();

        $pointageAujourdhui = [
            'entree' => Pointage::where('user_id', $user->id)
                ->whereDate('date', $aujourdhui)
                ->where('type', 'entree')
                ->first(),

            'sortie' => Pointage::where('user_id', $user->id)
                ->whereDate('date', $aujourdhui)
                ->where('type', 'sortie')
                ->first(),
        ];

        $debutMois = now()->startOfMonth()->toDateString();

        $stats = [
            'total_mois' => Pointage::where('user_id', $user->id)
                ->whereDate('date', '>=', $debutMois)
                ->where('type', 'entree')
                ->count(),

            'presents_mois' => Pointage::where('user_id', $user->id)
                ->whereDate('date', '>=', $debutMois)
                ->where('type', 'entree')
                ->where('statut', 'present')
                ->count(),

            'retards_mois' => Pointage::where('user_id', $user->id)
                ->whereDate('date', '>=', $debutMois)
                ->where('statut', 'retard')
                ->count(),

            'conges_actifs' => Conge::where('user_id', $user->id)
                ->where('statut', 'approuve')
                ->where('date_fin', '>=', $aujourdhui)
                ->count(),
        ];

        return view('dashboard', compact('pointages', 'pointageAujourdhui', 'stats'));
    }

    public function historique(Request $request)
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $query = Pointage::with('user')->latest();

        if ($request->filled('employe_id')) {
            $query->where('user_id', $request->employe_id);
        }

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $pointages = $query->paginate(30);
        $employes = User::where('role', 'employe')->get();

        return view('admin.pointages.historique', compact('pointages', 'employes'));
    }

    public function store(Request $request)
    {
        try {
            $user = auth()->user();

            if (!$user) {
                return response()->json(['message' => 'Non autorisé ❌'], 401);
            }

            $request->validate([
                'type' => 'required|in:entree,sortie',
                'site' => 'required',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
            ]);

            $today = now()->toDateString();
            $now   = now();

            // ====================== GÉOLOCALISATION ======================
            $siteSelectionne = null;

            switch ($request->site) {

                case 'site1':
                    $siteSelectionne = $this->sites[0];
                    break;

                case 'site2':
                    $siteSelectionne = $this->sites[1];
                    break;

                case 'site3':
                    $siteSelectionne = $this->sites[2];
                    break;

                default:
                    return response()->json([
                        'message' => 'Site invalide'
                    ], 400);
            }

            // Vérification zone autorisée
            $distanceMin = $this->calculDistance(
                $siteSelectionne['lat'],
                $siteSelectionne['lng'],
                $request->latitude,
                $request->longitude
            );

            $siteProche = $siteSelectionne['nom'];

            // ====================== DOUBLE POINTAGE ======================
            $existe = Pointage::where('user_id', $user->id)
                ->where('date', $today)
                ->where('type', $request->type)
                ->exists();

            if ($existe) {
                return response()->json([
                    'message' => 'Vous avez déjà pointé ce type aujourd\'hui ❌',
                    'statut'  => 'bloque'
                ], 400);
            }

            // ====================== STATUT (retard) ======================
            $statut = 'present';
            $minutesRetard = 0;

            if ($request->type === 'entree') {
                $heureTravail = today()->setTime(9, 0, 0); // 09:00

                if ($now->greaterThan($heureTravail)) {
                    $minutesRetard = $heureTravail->diffInMinutes($now);
                    $statut = 'retard';
                }
            }

            // ====================== ENREGISTREMENT ======================
            Pointage::create([
                'user_id'        => $user->id,
                'type'           => $request->type,
                'date'           => $today,
                'heure'          => $now->format('H:i:s'),
                'latitude'       => $request->latitude,
                'longitude'      => $request->longitude,
                'distance_bureau' => round($distanceMin),
                'statut'         => $statut,
                'minutes_retard' => $minutesRetard,
                'valide'         => true,
                'site' => $siteProche,
            ]);

            // Message de succès
            $message = $request->type === 'entree'
                ? ($statut === 'retard'
                    ? "Entrée enregistrée sur {$siteProche} - Retard de {$minutesRetard} min ⚠️"
                    : "Entrée enregistrée sur {$siteProche} ✅")
                : "Sortie enregistrée sur {$siteProche} ✅";

            return response()->json([
                'message'     => $message,
                'site_proche' => $siteProche,
                'statut'      => $statut,
                'minutes_retard' => $minutesRetard
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur serveur ❌',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    // 📐 Algorithme de Haversine
    private function calculDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // mètres

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
