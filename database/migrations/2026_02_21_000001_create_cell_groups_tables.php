<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 傷みグループ
        Schema::create('damage_cell_groups', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('hole_number');
            $table->string('comment')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index('hole_number');
        });

        // 禁止グループ
        Schema::create('ban_cell_groups', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('hole_number');
            $table->string('comment')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index('hole_number');
        });

        // 雨天グループ
        Schema::create('rain_cell_groups', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('hole_number');
            $table->string('comment')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index('hole_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('damage_cell_groups');
        Schema::dropIfExists('ban_cell_groups');
        Schema::dropIfExists('rain_cell_groups');
    }
};
