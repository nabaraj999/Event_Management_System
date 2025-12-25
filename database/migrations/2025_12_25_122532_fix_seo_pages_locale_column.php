<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // First, drop the composite unique index
        Schema::table('seo_pages', function (Blueprint $table) {
            $table->dropUnique(['page_key', 'locale']);
        });

        // Update all NULL locales to 'en'
        DB::table('seo_pages')->whereNull('locale')->update(['locale' => 'en']);

        // Now make column non-nullable with default
        Schema::table('seo_pages', function (Blueprint $table) {
            $table->string('locale')->default('en')->change();
        });

        // Re-add the composite unique index
        Schema::table('seo_pages', function (Blueprint $table) {
            $table->unique(['page_key', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::table('seo_pages', function (Blueprint $table) {
            $table->dropUnique(['page_key', 'locale']);
            $table->string('locale')->nullable()->default(null)->change();
            $table->unique(['page_key', 'locale']);
        });
    }
};
