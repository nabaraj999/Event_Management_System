<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event;
use Illuminate\Support\Facades\Log;

class UpdateEventStatuses extends Command
{
    protected $signature = 'events:update-statuses';
    protected $description = 'Updates event statuses to ongoing or completed based on dates';

    public function handle()
    {
        $now = now();

        // 1. Published → Ongoing  (started but not finished)
        $updatedToOngoing = Event::query()
            ->where('status', 'published')
            ->where('start_date', '<=', $now)
            ->where(function ($q) use ($now) {
                $q->whereNull('end_date')
                  ->orWhere('end_date', '>=', $now);
            })
            ->update([
                'status'     => 'ongoing',
                'updated_by' => null, // or Auth::guard('admin')->id() if you want to track
            ]);

        // 2. Ongoing or Published → Completed  (ended)
        $updatedToCompleted = Event::query()
            ->whereIn('status', ['published', 'ongoing'])
            ->whereNotNull('end_date')
            ->where('end_date', '<', $now)
            ->update([
                'status'     => 'completed',
                'updated_by' => null,
            ]);

        $this->info("Updated {$updatedToOngoing} events to ongoing");
        $this->info("Updated {$updatedToCompleted} events to completed");

        Log::info("Event status update run", [
            'ongoing'   => $updatedToOngoing,
            'completed' => $updatedToCompleted,
        ]);
    }
}
