<?php

namespace App\Http\Controllers;

use App\Models\Pin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PinController extends Controller
{
    public function index(Request $request)
    {
        $pins = Pin::with('creator')
            ->where('hole_number', $request->hole_number)
            ->get();
        return response()->json($pins);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'hole_number' => 'required|integer|between:1,18',
            'x' => 'required|integer',
            'y' => 'required|integer',
        ]);

        $validated['created_by'] = Auth::id();

        $pin = Pin::create($validated);
        return response()->json($pin, 201);
    }

    public function destroy(string $id)
    {
        $pin = Pin::findOrFail($id);
        $pin->delete();
        return response()->json(['message' => '削除しました']);
    }
}