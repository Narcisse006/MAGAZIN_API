<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use App\Models\Produit;
use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EntryController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entries = Entry::all();
        return response()->json($entries);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'quantity' => 'required|integer',
            'date' => 'required|date',
            'user_id' => 'required|exists:users,id'
        ]);

        $entry = new Entry();
        $entry->produit_id = $request->input('produit_id');
        $entry->quantity = $request->input('quantity');
        $entry->date = $request->input('date');
        $entry->user_id = $request->input('user_id');
        $entry->save();

        return response()->json([
            'message' => 'Entry created successfully',
            'entry' => $entry
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Entry $entry)
    {
        return response()->json($entry);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Entry $entry)
    {
        $entry->update($request->only(['quantity', 'date']));
        return response()->json($entry);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Entry $entry)
    {
        $entry->delete();
        return response()->json(['message' => 'Entry deleted successfully']);
    }
}
