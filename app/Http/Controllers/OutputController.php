<?php

namespace App\Http\Controllers;

use App\Models\Output;
use App\Models\Produit;
use Illuminate\Http\Request;

class OutputController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Produit $produit)
    {
        return response()->json($produit->outputs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Produit $produit)
    {
        // Validation des données
        $request->validate([
            'quantity' => 'required|integer|min:1', 
            'date' => 'required|date',             
            'user_id' => 'nullable|exists:users,id' 
        ]);

        // Vérifier si le stock est suffisant
        $currentStock = $produit->current_stock;
        if ($currentStock < $request->quantity) {
            return response()->json([
                'message' => 'Insufficient stock',
                'current_stock' => $currentStock
            ], 422);
        }

        // Réduire le stock du produit
        $produit->current_stock -= $request->quantity;
        $produit->save();

        // Enregistrer la sortie
        $output = $produit->outputs()->create([
            'quantity' => $request->quantity,
            'date' => $request->date,
            'user_id' => $request->user_id 
        ]);

        return response()->json([
            'message' => 'Output created successfully',
            'output' => $output
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Output $output)
    {
        return response()->json($output);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Output $output)
    {
        $output->update($request->only(['quantity', 'date']));
        return response()->json($output);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Output $output)
    {
        $output->delete();
        return response()->json(['message' => 'Output deleted successfully']);
    }
}
