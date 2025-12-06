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
        Schema::create('company_infos', function (Blueprint $table) {
            $table->id();
            $table->string('name');                           // Company Name
            $table->string('tagline')->nullable();

            // Media
            $table->string('logo')->nullable();               // Path to logo
            $table->string('favicon')->nullable();            // Path to favicon
            $table->string('bg_image')->nullable();           // Hero/background image

            // Contact Info
            $table->string('location')->nullable();           // Address or city
            $table->string('email')->unique();
            $table->string('phone')->nullable();

            // Social Media Links
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('youtube')->nullable();
            $table->string('linkedin')->nullable();           // Correct spelling: linkedin
            $table->string('twitter')->nullable();            // Bonus
            $table->string('tiktok')->nullable();             // Bonus

            // About Us Section
            $table->string('about_us_title')->default('About Us');
            $table->longText('about_us_description')->nullable();
            $table->string('about_us_image')->nullable();

            // Legal & Registration
            $table->string('reg_no')->unique()->nullable();    // Company Registration No.
            $table->string('pan_no')->unique()->nullable();    // PAN (India) or Tax ID
            $table->string('gst_no')->nullable();              // GST No. (India) - very common
            $table->year('company_start')->nullable();        // Year established

            // Stats (for frontend counters)
            $table->integer('total_employees')->default(0);
            $table->integer('total_events')->default(0);
            $table->integer('satisfied_clients')->default(0);
            $table->string('net_worth')->nullable();           // e.g., "$50M+", "₹500 Crore"

            // Extra Useful Fields (Recommended)
            $table->string('website')->nullable();
            $table->text('address_full')->nullable();          // Complete address
            $table->string('map_link')->nullable();            // Google Maps embed/link
            $table->boolean('is_active')->default(true);
            $table->json('working_hours')->nullable();         // e.g., {"mon-fri": "9AM-6PM", ...}
            $table->json('extra_links')->nullable();           // Any other custom links

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_infos');
    }
};
