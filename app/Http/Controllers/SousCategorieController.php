<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SousCategorie;
use App\Models\Categorie;
use App\Models\Produit;

class SousCategorieController extends Controller
{
    
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SousCategorie::all();
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
        $request->validate([

            'nom' => 'required',
            'categorie_id' => 'required',
            'link' =>'required',

        ]);
        
        $nom = $request->nom;
        $link = $request->link;
        $cat_id = $request->categorie_id;
       
        $sousCategorie  =  new SousCategorie();
        $sousCategorie->nom = $nom;
        $sousCategorie->link = $link;
        $sousCategorie->categorie_id = $cat_id;
        $sousCategorie->save();
        
        
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
  
        
    public function update(Request $request, SousCategorie $souscategorie)
        {
            $request->validate([
    
                'nom' => 'required',
                'categorie_id' => 'required',
                'link' => 'required'
               
    
            ]);
            $id = $request->id;
    
            $souscategorie = SousCategorie::find($id);
            $souscategorie->update($request->all());
            return $souscategorie;
            
        }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SousCategorie $sousCategorie)
    {
        $sousCategorie->delete();
        return response()->json("la catégorie est supprimer");
    }

    public function catProduits($id){
        $souscategorie = SousCategorie::with('Produit')->get()->find($id);
        return  response()->json($souscategorie);
    }
    // with('favorites')->get()
   

    public function detailsProduits($id){

       
    }       

    public function getProd($id){
        if(Produit::where('id',$id)->exists())
            {
                $produit = Produit::where('id',$id)->first();
                return response()->json($produit);
            }
            else{
                return response()->json("produit not exist");
            }
        }
    
    

   
}