<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RainCell;

class RainCellController extends Controller
{
    public function index(Request $request)
{
    $cells = RainCell::where('hole_number', $request->hole_number)->get();
    return response()->json($cells);
}

public function store(Request $request)
{
    $validated = $request->validate([
        'hole_number' => 'required|integer|between:1,18',
        'x' => 'required|integer',
        'y' => 'required|integer',
    ]);

    $cell = RainCell::create($validated);
    return response()->json($cell, 201);
}

public function destroy(string $id)
{
    $cell = RainCell::findOrFail($id);
    $cell->delete();
    return response()->json(['message' => '削除しました']);
}
}
