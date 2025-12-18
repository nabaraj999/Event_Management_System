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
       Schema::create('organizer_applications', function (Blueprint $table) {
    $table->id();
    $table->string('organization_name');
    $table->string('contact_person'); // or use as organizer name
    $table->string('email')->unique();
    $table->string('phone');
    $table->string('password')->nullable()->change();
    $table->string('company_type');
    $table->string('website')->nullable();
    $table->string('registration_document')->nullable();
    $table->string('profile_image')->nullable();
    $table->text('address');
    $table->text('description')->nullable();
    $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
    $table->timestamp('applied_at')->useCurrent();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizer_applications');
    }
};
