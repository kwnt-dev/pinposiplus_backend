<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PinHistorySeeder extends Seeder
{
    public function run(): void
    {
        $today = now();
        $yesterday = $today->copy()->subDay()->format('Y-m-d');
        $twoDaysAgo = $today->copy()->subDays(2)->format('Y-m-d');

        // 18ホール × 2日分のテストデータ
        $data = [
            // [hole_number, x, y, date]
            // 1日前
            [1, 25, 48, $yesterday],
            [2, 38, 40, $yesterday],
            [3, 25, 29, $yesterday],
            [4, 30, 46, $yesterday],
            [5, 33, 43, $yesterday],
            [6, 28, 28, $yesterday],
            [7, 32, 47, $yesterday],
            [8, 32, 33, $yesterday],
            [9, 38, 43, $yesterday],
            [10, 22, 35, $yesterday],
            [11, 36, 41, $yesterday],
            [12, 25, 24, $yesterday],
            [13, 35, 45, $yesterday],
            [14, 25, 44, $yesterday],
            [15, 34, 27, $yesterday],
            [16, 16, 35, $yesterday],
            [17, 36, 37, $yesterday],
            [18, 29, 26, $yesterday],

            // 2日前
            [1, 35, 33, $twoDaysAgo],
            [2, 26, 30, $twoDaysAgo],
            [3, 35, 38, $twoDaysAgo],
            [4, 27, 24, $twoDaysAgo],
            [5, 33, 28, $twoDaysAgo],
            [6, 30, 45, $twoDaysAgo],
            [7, 30, 27, $twoDaysAgo],
            [8, 20, 41, $twoDaysAgo],
            [9, 28, 25, $twoDaysAgo],
            [10, 38, 38, $twoDaysAgo],
            [11, 28, 27, $twoDaysAgo],
            [12, 27, 40, $twoDaysAgo],
            [13, 30, 21, $twoDaysAgo],
            [14, 33, 32, $twoDaysAgo],
            [15, 35, 42, $twoDaysAgo],
            [16, 40, 43, $twoDaysAgo],
            [17, 18, 45, $twoDaysAgo],
            [18, 33, 43, $twoDaysAgo],
        ];

        foreach ($data as [$hole, $x, $y, $date]) {
            DB::table('pin_history')->insert([
                'id' => Str::uuid(),
                'date' => $date,
                'hole_number' => $hole,
                'x' => $x,
                'y' => $y,
                'submitted_by' => null,
                'created_at' => now(),
            ]);
        }
    }
}
