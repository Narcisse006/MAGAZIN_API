<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\OutputController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\StockController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route pour récupérer l'utilisateur authentifié
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Routes publiques
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');


// Routes protégées par le middleware auth:sanctum ça marchais pas donc je l'ai désactivé de mon projet
//Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/produits', [ProduitController::class, 'index']);
    Route::post('/produits', [ProduitController::class, 'store']);
    Route::get('/produits/searchid/{id}', [ProduitController::class, 'searchid']);
    Route::post('/produits/{id}', [ProduitController::class, 'update']);
    Route::delete('/produits/{id}', [ProduitController::class, 'destroy']);
//});

Route::prefix('produits/{produit}')->group(function () {
    Route::apiResource('entries', EntryController::class)->only(['index', 'store']);
    Route::apiResource('outputs', OutputController::class)->only(['index', 'store']);
});

//Pour afficher l'etat du stock d'un produit
Route::get('/produits/{produit}/stock', [StockController::class, 'show']);

//Pour afficher l'etat du stock de tous les produits
Route::get('/stocks', [StockController::class, 'index']);