<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDamageCellRequest;
use App\Models\DamageCell;
use Illuminate\Http\Request;

class DamageCellController extends Controller
{
    public function index(Request $request)
    {
        $cells = DamageCell::where('hole_number', $request->hole_number)->get();

        return response()->json($cells);
    }

    public function store(StoreDamageCellRequest $request)
    {
        $validated = $request->validated();

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
