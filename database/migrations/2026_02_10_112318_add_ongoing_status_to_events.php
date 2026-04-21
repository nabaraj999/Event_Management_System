<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private function shouldSkipEnumAlter(): bool
    {
        return Schema::getConnection()->getDriverName() === 'sqlite';
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if ($this->shouldSkipEnumAlter()) {
            return;
        }

        DB::statement("ALTER TABLE events MODIFY COLUMN status ENUM('draft', 'published', 'ongoing', 'completed', 'cancelled') DEFAULT 'draft'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if ($this->shouldSkipEnumAlter()) {
            return;
        }

        DB::statement("ALTER TABLE events MODIFY COLUMN status ENUM('draft', 'published', 'completed', 'cancelled') DEFAULT 'draft'");
    }
};
