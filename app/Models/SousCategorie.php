<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SousCategorie extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'categorie_id',
        'link',
    ];

    public function Produit(){
        return $this->hasMany(Produit::class);
    }

}
