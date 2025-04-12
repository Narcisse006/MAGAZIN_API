<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Models\Produit;
use Illuminate\Http\Request;

class ProduitController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Produit::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'prix' => 'required|numeric',
            'quantity' => 'required|integer',
            'description' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $produit = new Produit();
        $produit->name = $request->name;
        $produit->prix = $request->prix;
        $produit->quantity = $request->quantity;
        $produit->description = $request->description;
        $produit->user_id = $request->user_id; 
        $produit->save();
        return response()->json([
            'message' => 'Produit created successfully',
            'produit' => $produit
        ], 201);
        //return Produit::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'prix' => 'required|numeric',
            'quantity' => 'required|integer',
            'description' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $produit = Produit::find($id);
        $produit->name = $request->name;
        $produit->prix = $request->prix;
        $produit->quantity = $request->quantity;
        $produit->description = $request->description;
        $produit->user_id = $request->user_id;
        $produit->save();
        return ($produit);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $produit = Produit::findOrFail($id);
        $produit->delete();
        return response()->json(['message' => 'Produit deleted successfully'], 200);
    }

    public function searchid($id)
    {
        return Produit::where('id', 'like', '%'.$id. '%')->get();
    }

}
