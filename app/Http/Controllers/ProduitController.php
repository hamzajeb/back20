<?php

namespace App\Http\Controllers;
use App\Models\Produit;
use App\Models\favoris;
use App\Models\SousCategorie;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $produits = Produit::with('favorites')->get();
        // return new contactCollection($contacts);
        return response()->json($produits);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if($request->hasFile('image1')){
            $completeFilename1=$request->file('image1')->getClientOriginalName();
            $fileNameOnly1=pathinfo($completeFilename1,PATHINFO_FILENAME);
            $extention1=$request->file('image1')->getClientOriginalExtension();
            $comPic1=str_replace(' ','_',$fileNameOnly1).'-'.rand().'_'.time().'.'. $extention1;
            $path1=$request->file('image1')->move('public/produits',$comPic1);
            // $file=$request->file('image1');
            // $uplodpath="public/produits";
            // $originalimage1=$file->getClientOriginalName();
            // $file->move($uplodpath,$originalimage);
        }
        if($request->hasFile('image2')){
            $completeFilename2=$request->file('image2')->getClientOriginalName();
            $fileNameOnly2=pathinfo($completeFilename2,PATHINFO_FILENAME);
            $extention2=$request->file('image2')->getClientOriginalExtension();
            $comPic2=str_replace(' ','_',$fileNameOnly2).'-'.rand().'_'.time().'.'. $extention2; 
            $path2=$request->file('image2')->move('public/produits',$comPic2);               
        }
        if($request->hasFile('image3')){
            $completeFilename3=$request->file('image3')->getClientOriginalName();
            $fileNameOnly3=pathinfo($completeFilename3,PATHINFO_FILENAME);
            $extention3=$request->file('image3')->getClientOriginalExtension();
            $comPic3=str_replace(' ','_',$fileNameOnly3).'-'.rand().'_'.time().'.'. $extention3; 
            $path3=$request->file('image3')->move('public/produits',$comPic3);               
        }
        $x=SousCategorie::find($request->sous_categorie_id);
        $produit=Produit::create([
            'nom'=> $request->nom,
            'quantite'=> $request->quantite,
            'prix'=> $request->prix,
            'image1'=> $path1,
            'image2'=> $path2,
            'image3'=> $path3,
            'detail'=> $request->detail,
            'description'=> $request->description,
            'sous_categorie_id'=> $request->sous_categorie_id,
            'sous_categorie'=> $x->nom,
        ]);
        return response()->json([
            'message' => 'produit enregistree',
            'produit'=>$produit
    
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function modifierProduit(Request $request, $id)
    {
        //
        $produit1 = Produit::where('id', $id)->latest()->first();
        if($request->hasFile('image1')){
            $completeFilename1=$request->file('image1')->getClientOriginalName();
            $fileNameOnly1=pathinfo($completeFilename1,PATHINFO_FILENAME);
            $extention1=$request->file('image1')->getClientOriginalExtension();
            $comPic1=str_replace(' ','_',$fileNameOnly1).'-'.rand().'_'.time().'.'. $extention1;
            $path1=$request->file('image1')->move('public/produits',$comPic1);
            // $file=$request->file('image1');
            // $uplodpath="public/produits";
            // $originalimage1=$file->getClientOriginalName();
            // $file->move($uplodpath,$originalimage);
        }
        if($request->hasFile('image2')){
            $completeFilename2=$request->file('image2')->getClientOriginalName();
            $fileNameOnly2=pathinfo($completeFilename2,PATHINFO_FILENAME);
            $extention2=$request->file('image2')->getClientOriginalExtension();
            $comPic2=str_replace(' ','_',$fileNameOnly2).'-'.rand().'_'.time().'.'. $extention2; 
            $path2=$request->file('image2')->move('public/produits',$comPic2);               
        }
        if($request->hasFile('image3')){
            $completeFilename3=$request->file('image3')->getClientOriginalName();
            $fileNameOnly3=pathinfo($completeFilename3,PATHINFO_FILENAME);
            $extention3=$request->file('image3')->getClientOriginalExtension();
            $comPic3=str_replace(' ','_',$fileNameOnly3).'-'.rand().'_'.time().'.'. $extention3; 
            $path3=$request->file('image3')->move('public/produits',$comPic3);               
        }
        $x=SousCategorie::find($request->sous_categorie_id);
        $produit1->update([
            'nom'=> $request->nom,
            'quantite'=> $request->quantite,
            'prix'=> $request->prix,
            'image1'=> $path1,
            'image2'=> $path2,
            'image3'=> $path3,
            'detail'=> $request->detail,
            'description'=> $request->description,
            'sous_categorie_id'=> $request->sous_categorie_id,
            'sous_categorie'=> $x->nom,
        ]);
        return response()->json([
            'message' => 'produit modifiee',
            'produit'=>$produit1->nom
    
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produit $produit)
    {
        //
        $produit->delete();
        return response()->json([
            'message'=>"La suppression est réussite"
        ]);

    }

    

    public function ajouterFavoris(Request $request){
        $favoris=Favoris::create([
            'user_id'=> $request->user_id,
            'produit_id'=> $request->produit_id,

        ]);
        return response()->json([
            'message' => 'ajouter au Favoris',
            'favoris'=>$favoris
        ]);
    }

    public function supprimerFavoris($idProduit,$idUser){
        $favoris=favoris::where([
            'produit_id' => $idProduit,
            'user_id' => $idUser,
        ]);
        $favoris->delete();
        return response()->json([
            'message'=>"supprimer de favoris"
        ]);
    }

    public function favProduits($id){
        $favorites = Produit::with('favorites')->get()->find($id);
        return  response()->json($favorites);
    }

    public function ajouterPromo($id,Request $request){
        $produit = Produit::where('id', $id)->latest()->first();
        $produit->update([
            'is_promo'=> $request->is_promo,
            'date_chrono'=>$request->date_chrono,
            'pourcentage'=>$request->pourcentage,
            'nouveauPrix'=>$request->nouveauPrix,
        ]);
        return response()->json([
            'message' => 'Promo enregistre',
            'produit'=>$produit
    
        ]);
        
    }
    

}
