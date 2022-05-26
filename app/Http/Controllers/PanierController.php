<?php

namespace App\Http\Controllers;
use App\Models\Panier;
use App\Models\Produit;
use Illuminate\Http\Request;

class PanierController extends Controller
{
    public function ajouterPanier(Request $request){

        $quantite = $request->quantite;
        $taille = $request->taille;
        $produit_id = $request->produit_id;
        $user_id = $request->user_id;
        $panier =  new Panier();
        $panier->quantite = $quantite;
        $panier->produit_id = $produit_id;
        $panier->user_id = $user_id;
        $panier->taille = $taille;
        $panier->save();
        return response()->json("le panier est bien enregistrer");

    }

    public function getPanier($user_id){
        $panier = Panier::where(["user_id"=>$user_id,"commande_id"=>0])->get();   
     
        $list_produitPanier = array();
        $prixTot = 0;
        $x=0;
        foreach($panier as $pan){
            $produit = Produit::find($pan->produit_id);
            if($produit->is_promo==1){
                $x=$produit->nouveauPrix;
            }else{
                $x=$produit->prix;
            }
            $prixTot = $prixTot + $x*$pan->quantite;
            array_push($list_produitPanier,(object)[
                'id'=>$pan->id,
                'quantite'=>$pan->quantite,
                'taille'=>$pan->taille,
                'produit_id'=>$pan->produit_id,
                'user_id'=>$pan->user_id,
                'created_at'=>$pan->created_at,
                'updated_at'=>$pan->updated_at,
                'produit_nom'=>$produit->nom,
                'produit_img'=>$produit->image1,
                'produit_prix'=>$x,
                'produit_quantite'=>$produit->quantite,
                'total'=>$x*$pan->quantite,
               
            ]);
        
            
          
    }
    

    return (object)['prix_tot'=>$prixTot,'list_produitPanier'=>$list_produitPanier];

}


public function deletePanier(Panier $panier){

    $panier->delete();
        return response()->json("le panier est supprimer");
    
}


public function ViderPanier($user_id){
    $value = 0;
    $panier = Panier::where(['commande_id'=>$value,'user_id'=>$user_id])->get();
   
    return $panier;
}
public function maxProduit(){
    $valeur = 0;
    $somProd = 0;
    $sommeProduit=array();
    $paniers = Panier::where('commande_id','<>',$valeur)
    ->get()->groupBy("produit_id");

    foreach($paniers as $panier){
       $somProd =  $panier->sum('quantite');  
       foreach($panier as $pan){
        $id = $pan->produit_id;
        $produit = Produit::where('id',$id)->first();
       }
       array_push($sommeProduit,(object)[
        'quantite_total'=>$somProd,
        'produit_nom'=>$produit->nom,
        'produit_image'=>$produit->image1,
        'produit_detail'=>$produit->detail,

       ]);
      
    }
    return max($sommeProduit);
 
}

public function minProduit(){
    $valeur = 0;
    $somProd = 0;
    $sommeProduit=array();
    $paniers = Panier::where('commande_id','<>',$valeur)
    ->get()->groupBy("produit_id");

    foreach($paniers as $panier){
       $somProd =  $panier->sum('quantite');  
       foreach($panier as $pan){
        $id = $pan->produit_id;
        $produit = Produit::where('id',$id)->first();
       }
       array_push($sommeProduit,(object)[
        'quantite_total'=>$somProd,
        'produit_nom'=>$produit->nom,
        'produit_image'=>$produit->image1,
        'produit_detail'=>$produit->detail,

       ]);
      
    }
    return min($sommeProduit);
 
}



}

