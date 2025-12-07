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
        Schema::create('event_categories', function (Blueprint $table) {
           $table->id();
            $table->string('name');                    // e.g., Wedding, Corporate, Birthday
            $table->string('slug')->unique();           // URL-friendly: wedding-events
            $table->text('description')->nullable();

            $table->string('icon_type')->default('fontawesome'); // heroicon | fontawesome | custom
            $table->string('icon_name');                // e.g., "cake-candle", "fa-briefcase", or "custom-wedding"
            $table->text('custom_svg')->nullable();     // Store raw SVG if custom

            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0); // For manual ordering

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_categories');
    }
};
