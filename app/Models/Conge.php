<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Conge extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'motif',
        'description',
        'date_debut',
        'date_fin',
        'nombre_jours',
        'heure_debut',
        'heure_fin',
        'statut',
        'traite_par',
        'traite_le',
        'commentaire_admin',
    ];

    protected function casts(): array
    {
        return [
            'date_debut' => 'date',
            'date_fin'   => 'date',
            'traite_le'  => 'datetime',
        ];
    }

    // ─── Relations ───────────────────────────────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function adminTraitant()
    {
        return $this->belongsTo(User::class, 'traite_par');
    }

    // ─── Scopes ──────────────────────────────────────────────────────
    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }

    public function scopeApprouves($query)
    {
        return $query->where('statut', 'approuve');
    }

    public function scopeRefuses($query)
    {
        return $query->where('statut', 'refuse');
    }

    // ─── Helpers ─────────────────────────────────────────────────────
    public function estEnAttente(): bool
    {
        return $this->statut === 'en_attente';
    }

    public function estApprouve(): bool
    {
        return $this->statut === 'approuve';
    }

    public function estRefuse(): bool
    {
        return $this->statut === 'refuse';
    }
}
