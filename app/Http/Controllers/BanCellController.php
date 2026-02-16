<?php

namespace App\Http\Controllers;

use App\Models\BanCell;
use Illuminate\Http\Request;

class BanCellController extends Controller
{
    public function index(Request $request)
    {
        $cells = BanCell::where('hole_number', $request->hole_number)->get();

        return response()->json($cells);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'hole_number' => 'required|integer|between:1,18',
            'x' => 'required|integer',
            'y' => 'required|integer',
        ]);

        $cell = BanCell::create($validated);

        return response()->json($cell, 201);
    }

    public function destroy(string $id)
    {
        $cell = BanCell::findOrFail($id);
        $cell->delete();

        return response()->json(['message' => '削除しました']);
    }
}
