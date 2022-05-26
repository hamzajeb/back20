<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'quantite',
        'prix',
        'image1',
        'image2',
        'image3',
        'detail',
        'description',
        'sous_categorie_id',
        'is_promo',
        'chrono_sec',
        'chrono_min',
        'chrono_hour',
        'sous_categorie',
        'chrono_h',
        'date_chrono',
        'pourcentage',
        'nouveauPrix'
    ];
    public function favorites(){
        return $this->hasMany(favoris::class);
    }
}
