<?php

namespace App\Http\Controllers;
use App\Models\Categorie;
use App\Models\SousCategorie;
use App\Models\Produit;
use Illuminate\Http\Request;
use App\Models\favoris;
class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Categorie::all();
    }

    public function dashboardCat(){
        $categories = Categorie::with('sousCategorie')->get();
        $sousCat=SousCategorie::all();
        // return new contactCollection($contacts);
        return response()->json($this->formater($categories,$sousCat));
    }

    public function formater($categories,$sousCat) //===resource controller
    {
        $j=0;
        $total=count($sousCat);
        $count = count($categories);
        for ($i = 0; $i < $count; $i++) {
            $data['name'] = $categories[$i]->nom;
            $data['y']=(($categories[$i]->sousCategorie()->count())/$total)*100;
            $x[$i] = $data;
        }
        return $x;
    }

    public function dashboardCat2(){
        $categories = Categorie::with('sousCategorie')->get();
        $sousCat=SousCategorie::with('Produit')->get();
        $produit=Produit::all();
        // return new contactCollection($contacts);
        return response()->json($this->formater2($categories,$sousCat,$produit));
    }

    public function formater2($categories,$sousCat,$produit) //===resource controller
    {
        $lp=count($produit);
        $lsC=count($sousCat);
        $lc = count($categories);
        for ($i = 0; $i < $lc; $i++) {
            $data['name'] = $categories[$i]->nom;
            $data['y']=0;
            for($j=0;$j<$lsC;$j++){
                if($categories[$i]->id==$sousCat[$j]->categorie_id){
                    // $data['y']=$data['y']+$sousCat[$j]->Produit()->count();
                    for($k=0;$k<$lp;$k++){
                        if($produit[$k]->sous_categorie_id==$sousCat[$j]->id){
                            $data['y']=$data['y']+$produit[$k]->quantite;
                        }

                    }
                }
            }
            $x[$i] = $data;
        }
        return $x;
    }

    public function dashboardfav(){

        $favoris=favoris::all();
        $lp=count($favoris);
        for($i=0;$i<$lp;$i++){
            $x=0;
            for($j=0;$j<$lp;$j++){
                if($favoris[$i]->produit_id==$favoris[$j]->produit_id){
                    $x=$x+1;
                }
            }
            $data['numbre']=$x;
            $data['id'] = $favoris[$i]->produit_id;
            
            $z[$i]=$data;
        }
        $r=[max($z)];
        $id=$r[0]['id'];
        $produit1 = Produit::where('id', $id)->latest()->first();
        // return new contactCollection($contacts);
        return response()->json([
            'produit'=>$produit1,
            'numbre'=>$r[0]['numbre']
        ]);
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
           

        ]);
       
        
        $nom = $request->nom;
   
        $categorie =  new Categorie();
        $categorie->nom = $nom;
     
        $categorie->save();
        return response()->json("la catégorie est bien enregistrer");

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
        $categorie = Categorie::find($id);
        return response()->json('done');
    }

    public function update(Request $request, Categorie $categorie)
    {
        $request->validate([

            'nom' => 'required',
           

        ]);
        $id = $request->id;

        $categorie = Categorie::find($id);
        $categorie->update($request->all());
        return $categorie;
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categorie $categorie)
    {
       
        $categorie->delete();
        return response()->json("la catégorie est supprimer");

        

    }

    public function getIndex(){
        $Categorie = Categorie::with('sousCategorie')->get();
        return  response()->json($Categorie);
    }

    public function getCategorieByuId($id){
        $categorie = Categorie::find($id);
        if(is_null($categorie)){
            return response()->json(['message' => 'Categorie introuvable'],404);
        }
        return response()->json(Categorie::find($id),200);
    }

}
