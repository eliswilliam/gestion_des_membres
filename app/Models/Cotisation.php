<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Caisse;

class Cotisation extends Model
{
    use HasFactory;

    protected $table = 'cotisations';

    protected $fillable = [
        'member_id',
        'numero_membre',
        'mois',
        'annee',
        'montant',
        'date_paiement',
    ];
    

    /**
     * Relation : une cotisation appartient à un membre
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Scope : cotisation du mois courant
     */
    public function scopeMoisCourant($query)
    {
        return $query->where('mois', now()->month)
                     ->where('annee', now()->year);
    }

    /**
     * Vérifie si la cotisation est complète (1000 max)
     */
    public function estComplete()
    {
        return $this->montant >= 1000;
    }
}
