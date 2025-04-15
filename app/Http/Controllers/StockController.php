<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display the current stock of a product.
     */
    public function index()
    {
        $products = Produit::all([
            'id', 
            'name', 
            'current_stock'
        ]);
        return response()->json($products);
    }
    /**
     * Display the specified product's stock.
     */
    public function show(Produit $produit)
    {
        return response()->json([
            'product_id' => $produit->id,
            'product_name' => $produit->name,
            'current_stock' => $produit->current_stock
        ]);
    }
}
