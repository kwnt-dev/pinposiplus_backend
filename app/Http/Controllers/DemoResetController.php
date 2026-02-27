<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class DemoResetController extends Controller
{
    public function reset(): JsonResponse
    {
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            DB::table('pins')->truncate();
            DB::table('pin_history')->truncate();
            DB::table('pin_sessions')->truncate();
            DB::table('damage_cells')->truncate();
            DB::table('damage_cell_groups')->truncate();
            DB::table('ban_cells')->truncate();
            DB::table('ban_cell_groups')->truncate();
            DB::table('rain_cells')->truncate();
            DB::table('rain_cell_groups')->truncate();
            DB::table('daily_schedules')->truncate();
            DB::table('users')->truncate();
            DB::table('personal_access_tokens')->truncate();

            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            Artisan::call('db:seed', ['--force' => true]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
