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
        Schema::table('event_categories', function (Blueprint $table) {
            // Add organizer_id after category_id for logical order
            $table->foreignId('organizer_id')
                  ->nullable() // Allow null temporarily for existing rows
                  ->constrained('organizer_applications') // Change if your table name is different (e.g., 'organizers')
                  ->cascadeOnUpdate()
                  ->nullOnDelete(); // Keep events even if organizer is deleted

            // Add index for performance
            $table->index('organizer_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_categories', function (Blueprint $table) {
            $table->dropForeign(['organizer_id']);
            $table->dropIndex(['organizer_id']);
            $table->dropColumn('organizer_id');
        });
    }
};
