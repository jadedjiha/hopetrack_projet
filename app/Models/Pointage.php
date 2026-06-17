<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Pointage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'date',
        'heure',
        'latitude',
        'longitude',
        'distance_bureau',
        'statut',
        'minutes_retard',
        'valide',
        'note',
        'site',
    ];

    protected function casts(): array
    {
        return [
            'date'            => 'date',
            'latitude'        => 'float',
            'longitude'       => 'float',
            'minutes_retard'  => 'integer',
            'distance_bureau' => 'integer',
            'site'            => 'string',
            'valide'          => 'boolean',
        ];
    }

    // Relation
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // Scopes
    public function scopePresents($query)
    {
        return $query->where('statut', 'present');
    }

    public function scopeRetards($query)
    {
        return $query->where('statut', 'retard');
    }

    public function scopeAujourdhui($query)
    {
        return $query->whereDate('date', today());
    }
}
