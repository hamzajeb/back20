<?php

namespace App\Http\Controllers;
use App\Models\Panier;
use App\Models\Produit;
use App\Models\User;
use App\Models\Commande;


use Illuminate\Http\Request;

class CommandeController extends Controller
{
    public function AjouterCommande(Request $request){
        $subTotal = 0;
        $user = User::find($request->user_id);
        $element = Panier::find($request->user_id);
        $commande = new Commande;
        $commande->user_id = $request->user_id;
        $commande->save();

        Panier::where('user_id',$request->user_id)->update(['commande_id'=>$commande->id]);
        $produitsPanier = Panier::where('user_id',$request->user_id)->get();
        foreach($produitsPanier as $produitPanier){
            $produit  = Produit::where('id',$produitPanier->produit_id)->first();
            if($produit->quantite>$produitPanier->quantite){
            $nvQuantite = $produit->quantite - $produitPanier->quantite;
            $produit->update(['quantite'=>$nvQuantite]);
            }
            $subTotal = $subTotal + $produitPanier->quantite*$produit->prix;
        }
        
        return (object)['produits'=> $produitsPanier,'commande'=>$commande,'prod'=>$produit,'total'=>$subTotal];
      
    }
}
