<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ban_cells', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('hole_number');
            $table->integer('x');
            $table->integer('y');
            $table->timestamp('created_at')->useCurrent();

            $table->index('hole_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ban_cells');
    }
};
