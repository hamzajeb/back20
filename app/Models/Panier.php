<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panier extends Model
{
    use HasFactory;

    protected $fillable = [
        "quantite",
        "taille",
        "user_id",
        "produit_id",
        "commande_id"

    ];

}
