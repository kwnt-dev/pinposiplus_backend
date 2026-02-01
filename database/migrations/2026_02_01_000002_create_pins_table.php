<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * ピン位置テーブル
     */
    public function up(): void
    {
        Schema::create('pins', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('hole_number');
            $table->integer('x');
            $table->integer('y');
            $table->uuid('created_by')->nullable();  // FK制約なし（ユーザー削除してもピンは残す）
            $table->timestamps();

            $table->index('hole_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pins');
    }
};