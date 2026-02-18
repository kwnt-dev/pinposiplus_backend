<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pin_sessions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('course');
            $table->string('status')->default('draft');
            $table->date('target_date')->nullable();
            $table->string('event_name')->nullable();
            $table->integer('groups_count')->nullable();
            $table->boolean('is_rainy')->default(false);
            $table->uuid('created_by')->nullable();
            $table->uuid('submitted_by')->nullable();
            $table->string('submitted_by_name')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->string('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pin_sessions');
    }
};
