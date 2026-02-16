<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pin_history', function (Blueprint $table) {
            $table->uuid('submitted_by')->nullable()->after('y');
        });
    }

    public function down(): void
    {
        Schema::table('pin_history', function (Blueprint $table) {
            $table->dropColumn('submitted_by');
        });
    }
};
