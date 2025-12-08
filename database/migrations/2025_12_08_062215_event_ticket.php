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
        // database/migrations/xxxx_xx_xx_create_event_tickets_table.php
        Schema::create('event_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');

            $table->string('name');                    // e.g., VIP, Normal, Early Bird, Student
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);           // 1500.00
            $table->integer('total_seats');            // how many available for this type
            $table->integer('sold_seats')->default(0);
            $table->integer('remaining_seats')->virtualAs('total_seats - sold_seats');

            $table->dateTime('sale_start')->nullable(); // ticket sale start time
            $table->dateTime('sale_end')->nullable();   // ticket sale end time

            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
