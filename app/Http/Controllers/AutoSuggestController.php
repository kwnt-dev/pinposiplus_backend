<?php

namespace App\Http\Controllers;

use App\Models\BanCell;
use App\Models\DamageCell;
use App\Models\PinHistory;
use App\Models\RainCell;

class AutoSuggestController extends Controller
{
    public function index()
    {
        $damageCells = DamageCell::all()->groupBy('hole_number');
        $banCells = BanCell::all()->groupBy('hole_number');
        $rainCells = RainCell::all()->groupBy('hole_number');

        $pastPins = PinHistory::orderBy('date', 'desc')
            ->get()
            ->groupBy('hole_number');

        return response()->json([
            'damage_cells' => $damageCells,
            'ban_cells' => $banCells,
            'rain_cells' => $rainCells,
            'past_pins' => $pastPins,
        ]);
    }
}
