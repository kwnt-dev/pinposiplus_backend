<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('damage_cells', function (Blueprint $table) {
            $table->uuid('group_id')->nullable()->after('id');
            $table->foreign('group_id')
                ->references('id')
                ->on('damage_cell_groups')
                ->cascadeOnDelete();
        });

        Schema::table('ban_cells', function (Blueprint $table) {
            $table->uuid('group_id')->nullable()->after('id');
            $table->foreign('group_id')
                ->references('id')
                ->on('ban_cell_groups')
                ->cascadeOnDelete();
        });

        Schema::table('rain_cells', function (Blueprint $table) {
            $table->uuid('group_id')->nullable()->after('id');
            $table->foreign('group_id')
                ->references('id')
                ->on('rain_cell_groups')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('damage_cells', function (Blueprint $table) {
            $table->dropForeign(['group_id']);
            $table->dropColumn('group_id');
        });

        Schema::table('ban_cells', function (Blueprint $table) {
            $table->dropForeign(['group_id']);
            $table->dropColumn('group_id');
        });

        Schema::table('rain_cells', function (Blueprint $table) {
            $table->dropForeign(['group_id']);
            $table->dropColumn('group_id');
        });
    }
};
