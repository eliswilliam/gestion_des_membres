<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_membre',
        'nom',
        'prenoms',
        'date_naissance',
        'lieu_naissance',
        'nom_pere',
        'nom_mere',
        'profession',
        'nationalite',
        'situation_matrimoniale',
        'adresse',
        'photo',
    ];

    public function cotisations()
    {
        return $this->hasMany(Cotisation::class); // Laravel utilise member_id automatiquement
    }

    public function getPhotoUrlAttribute(): ?string
    {
        if (!$this->photo) {
            return null;
        }

        // Si la photo est stockée en Base64 dans la base de données (Neon)
        if (str_starts_with($this->photo, 'data:')) {
            return $this->photo;
        }

        $disk = config('filesystems.default', 'public');

        if ($disk === 'gcs') {
            $bucket = config('filesystems.disks.gcs.bucket');
            return "https://storage.googleapis.com/{$bucket}/{$this->photo}";
        }

        return asset('storage/' . $this->photo);
    }
}
