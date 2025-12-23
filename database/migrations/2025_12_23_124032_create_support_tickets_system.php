<?php
// database/migrations/xxxx_xx_xx_create_support_tickets_system.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Tickets Table
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organizer_id')->constrained('organizer_applications')->onDelete('cascade');
            $table->string('ticket_id')->unique(); // e.g., TKT-20251223-0001
            $table->string('subject');
            $table->text('message');
            $table->enum('priority', ['normal', 'urgent'])->default('normal');
            $table->enum('status', ['open', 'waiting_for_reply', 'replied', 'closed'])->default('open');
            $table->timestamp('last_replied_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();
        });

        // Ticket Replies Table
        Schema::create('support_ticket_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('support_tickets')->onDelete('cascade');
            $table->unsignedBigInteger('replier_id'); // organizer or admin ID
            $table->string('replier_type'); // 'organizer' or 'admin'
            $table->text('message');
            $table->timestamps();

            $table->index(['replier_id', 'replier_type']);
        });

        // Ticket Attachments Table
        Schema::create('support_ticket_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reply_id')->nullable()->constrained('support_ticket_replies')->onDelete('cascade');
            $table->foreignId('ticket_id')->constrained('support_tickets')->onDelete('cascade');
            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_type'); // image/png, application/pdf, etc.
            $table->unsignedBigInteger('file_size');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('support_ticket_attachments');
        Schema::dropIfExists('support_ticket_replies');
        Schema::dropIfExists('support_tickets');
    }
};
