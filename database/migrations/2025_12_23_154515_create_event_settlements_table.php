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
        Schema::create('event_settlements', function (Blueprint $table) {
           $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->string('revenue_invoice_id'); // e.g., INV-483921 from report
            $table->decimal('gross_revenue', 12, 2);
            $table->decimal('commission', 12, 2);
            $table->decimal('net_payable', 12, 2);
            $table->string('settlement_invoice_id')->nullable(); // Admin uploads this
            $table->string('settlement_proof')->nullable(); // PDF path
            $table->timestamp('settled_at')->nullable();
            $table->foreignId('settled_by')->nullable()->constrained('admins');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique('event_id'); // One settlement per event
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_settlements');
    }
};
