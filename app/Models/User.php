<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'poste',
        'telephone',
        'departement',
        'date_embauche',
        'photo',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // 🔗 RELATIONS

    public function pointages()
    {
        return $this->hasMany(Pointage::class);
    }

    public function conges()
    {
        return $this->hasMany(Conge::class);
    }

    // 🧠 HELPERS (TRÈS UTILE)

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isEmploye()
    {
        return $this->role === 'employe';
    }
    public function taches()
    {
        return $this->hasMany(Tache::class);
    }
}
