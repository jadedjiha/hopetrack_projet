<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Tache extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'admin_id',
        'titre',
        'description',
        'priorite',
        'statut',
        'date_limite',
        'commentaire',
    ];

    protected function casts(): array
    {
        return [
            'date_limite' => 'date',
        ];
    }

    // 👷 Employé assigné
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 👑 Admin créateur
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    // 📌 Tâches en attente
    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }

    // 🚀 Tâches en cours
    public function scopeEnCours($query)
    {
        return $query->where('statut', 'en_cours');
    }

    // ✅ Tâches terminées
    public function scopeTerminees($query)
    {
        return $query->where('statut', 'terminee');
    }

    // 🔥 Tâches prioritaires
    public function scopeUrgentes($query)
    {
        return $query->where('priorite', 'haute');
    }

    // ⏰ Vérifie retard
    public function estEnRetard(): bool
    {
        return $this->date_limite
            && $this->date_limite->isPast()
            && $this->statut != 'terminee';
    }
}
