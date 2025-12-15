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
        Schema::table('bookings', function (Blueprint $table) {
            // Add unique token for QR code verification
            $table->string('ticket_token')->unique()->nullable()->after('payment_response');

            // Track if ticket was scanned at event
            $table->boolean('is_checked_in')->default(false)->after('ticket_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['ticket_token', 'is_checked_in']);
        });
    }
};
