<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DamageCell;

class DamageCellController extends Controller
{
    public function index(Request $request)
{
    $cells = DamageCell::where('hole_number', $request->hole_number)->get();
    return response()->json($cells);
}

public function store(Request $request)
{
    $validated = $request->validate([
        'hole_number' => 'required|integer|between:1,18',
        'x' => 'required|integer',
        'y' => 'required|integer',
    ]);

    $cell = DamageCell::create($validated);
    return response()->json($cell, 201);
}

public function destroy(string $id)
{
    $cell = DamageCell::findOrFail($id);
    $cell->delete();
    return response()->json(['message' => '削除しました']);
}
}
