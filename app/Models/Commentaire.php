<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
    use HasFactory;
    protected $fillable = [
        "contenu",
        "is_accept",
        "produit_id",
        "user_id",

    ];

    public function user(){
        return this->belongsTo(User::class);
    }

    
    public function produit(){
        return this->belongsTo(Produit::class);
    }
    
}
