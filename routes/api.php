<?php

use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\SousCategorieController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\CommandeController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', [UserController::class, 'profile']);
    Route::get('/logout', [UserController::class, 'logout']);
});

Route::post('login/users', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

Route::resource('categorie', CategorieController::class);
Route::resource('sousCategorie', SousCategorieController::class);
Route::get('getIndex', [CategorieController::class,'getIndex']);
Route::get('catProduits/{id}', [SousCategorieController::class,'catProduits']);
Route::put('/categorie/{id}',[CategorieController::class,'update']);
Route::put('/sousCategorie/{id}',[SousCategorieController::class,'update']);

Route::apiResource('produits', ProduitController::class);
Route::post('modifierProduit/{id}', [ProduitController::class, 'modifierProduit']);
Route::post('ajouterFavoris', [ProduitController::class, 'ajouterFavoris']);
Route::delete('supprimerFavoris/{idProduit}/{idUser}', [ProduitController::class, 'supprimerFavoris']);
Route::get('favProduits/{id}', [ProduitController::class,'favProduits']);
Route::get('favUsers/{id}', [UserController::class,'favUsers']);


//route israe
Route::post('ajouterPanier',[PanierController::class,'ajouterPanier']);
Route::get('getPanier/{id}',[PanierController::class,'getPanier']);
Route::delete('deletePanier/{panier}',[PanierController::class,'deletePanier']);

Route::post('addCommentaire', [CommentaireController::class, 'store']);
Route::get('getCommentaire/{id}',[CommentaireController::class,'getCommentaire']);
Route::get('getAllCommentaire',[CommentaireController::class,'getAllCommentaires']);
Route::get('getProduits/{id}',[SousCategorieController::class,'getProd']);

Route::delete('deleteCommentaire/{commentaire}',[CommentaireController::class,'deleteCommentaire']);


Route::post('ajouterCommande',[CommandeController::class,'AjouterCommande']);
Route::get('viderPanier/{id}',[PanierController::class,'ViderPanier']);
Route::post('ajouterPromo/{id}', [ProduitController::class, 'ajouterPromo']);
Route::get('dashboardCat', [CategorieController::class,'dashboardCat']);
Route::get('dashboardCat2', [CategorieController::class,'dashboardCat2']);
Route::get('dashboardfav', [CategorieController::class,'dashboardfav']);

Route::get('maxProduit',[PanierController::class,'maxProduit']);
Route::get('minProduit',[PanierController::class,'minProduit']);