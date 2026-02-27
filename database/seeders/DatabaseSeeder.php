<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => '管理者',
            'email' => 'admin@gmail.com',
            'password' => 'admin',
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'スタッフ',
            'email' => 'staff@gmail.com',
            'password' => 'staff',
            'role' => 'staff',
        ]);

        $this->call([
            DamageCellSeeder::class,
            BanCellSeeder::class,
            RainCellSeeder::class,
            DailyScheduleSeeder::class,
            PinHistorySeeder::class,
        ]);
    }
}
