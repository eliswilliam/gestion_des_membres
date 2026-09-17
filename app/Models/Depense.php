<?php
// app/Models/Depense.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Depense extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'numero_membre',
        'type_evenement',
        'montant',
        'date_depense',
        'description',
        'reference',
        'created_by'
    ];

    protected $casts = [
        'date_depense' => 'date',
        'montant' => 'decimal:2'
    ];

    const TYPES_EVENEMENTS = [
        'enterrement' => 'Enterrement',
        'aide_sociale' => 'Aide sociale',
        'evenement_religieux' => 'Événement religieux',
        'urgence_medicale' => 'Urgence médicale',
        'projet_communautaire' => 'Projet communautaire',
        'mariage' => 'Mariage',
        'naissance' => 'Naissance',
        'autre' => 'Autre'
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function createur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getTypeEvenementLabelAttribute(): string
    {
        return self::TYPES_EVENEMENTS[$this->type_evenement] ?? $this->type_evenement;
    }

    public function getMontantFormateAttribute(): string
    {
        return number_format($this->montant, 0, ',', ' ') . ' FCFA';
    }

    public function scopeOfType($query, $type)
    {
        if ($type) {
            return $query->where('type_evenement', $type);
        }
        return $query;
    }

    public function scopeDateBetween($query, $start, $end)
    {
        if ($start && $end) {
            return $query->whereBetween('date_depense', [$start, $end]);
        }
        return $query;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($depense) {
            $lastId = static::max('id') + 1;
            $depense->reference = 'DEP-' . date('Ymd') . '-' . str_pad($lastId, 5, '0', STR_PAD_LEFT);
        });
    }
}