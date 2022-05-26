<?php

namespace App\Http\Controllers;
use App\Models\Commentaire;
use App\Models\User;
use App\Models\Produit;
use Illuminate\Http\Request;

class CommentaireController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([

            'contenu' => 'required',
           

        ]);
       
        
        $contenu = $request->contenu;
        $produit_id = $request->produit_id;
        $user_id = $request->user_id;
        $commentaire =  new Commentaire();
        $commentaire->contenu = $contenu;
        $commentaire->produit_id = $produit_id;
        $commentaire->user_id = $user_id;
     
        $commentaire->save();
        return response()->json("le commentaire est bien enregistrer");

    }


    public function getCommentaire($produit_id){

        $commentaires = Commentaire::where('produit_id',$produit_id)->get();
        $list_commentaire_user = array();
        foreach($commentaires as $commentaire){
            $user = User::find($commentaire->user_id);
           array_push($list_commentaire_user,(object)[
            'id'=> $commentaire->id,
            'contenu'=> $commentaire->contenu,
            'id_accept'=> $commentaire->id_accept,
            'produit_id'=> $commentaire->produit_id,
            'user_id'=> $commentaire->user_id,
            'created_at'=> $commentaire->created_at->format('Y/m/d H:i'),
            'updated_at'=> $commentaire->updates_at,
            'user_nom' => $user->nom,
            'user_prenom'=> $user->prenom,
            ]              
              
        );
        
        }
        return response()->json($list_commentaire_user);

    }

    public function getAllCommentaires(){
        $commentaires =Commentaire::all();
        $list_commentaire_produit = array();
        $list_commentaire = array();
        foreach($commentaires as $comment){
            $user = User::find($comment->user_id);
            $produit = Produit::find($comment->produit_id);
            array_push($list_commentaire,(object)[
                'id'=> $comment->id,
                'contenu'=> $comment->contenu,
                'produit_id'=> $comment->produit_id,
                'user_id'=> $comment->user_id,
                'created_at'=> $comment->created_at->format('Y/m/d H:i'),
                'updated_at'=> $comment->updates_at,
                'user_nom' => $user->nom,
                'user_prenom'=> $user->prenom,
                'produit_nom'=>$produit->nom,
                'produit_prix'=>$produit->prix,
                'produit_image'=>$produit->image1,
            ]);     
        }

        $produits = Produit::all();
        foreach($produits as $produit){
            $commentaire_produits = array();
            foreach($list_commentaire as $commentaire ){                
                if($commentaire->produit_id ==  $produit->id){
                    array_push($commentaire_produits,$commentaire);
                }
            }
            array_push($list_commentaire_produit,(object)[
                "produit" => $produit,
                "commentaires" => $commentaire_produits
            ]);     
        }
        
        return response()->json($list_commentaire_produit);
    }

    public function deleteCommentaire(Commentaire $commentaire){
        $commentaire->delete();
        return response()->json("le commentaire est supprimer");
    }

}

