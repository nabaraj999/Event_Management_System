<?php
// app/Models/SupportTicket.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SupportTicket extends Model
{
    protected $fillable = ['organizer_id', 'ticket_id', 'subject', 'message', 'priority', 'status'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($ticket) {
            $ticket->ticket_id = 'TKT-' . Carbon::now()->format('Ymd') . '-' . str_pad(self::count() + 1, 4, '0', STR_PAD_LEFT);
        });
    }

    public function organizer()
    {
        return $this->belongsTo(OrganizerApplication::class);
    }

    public function replies()
    {
        return $this->hasMany(SupportTicketReply::class, 'ticket_id')->orderBy('created_at');
    }

    public function attachments()
    {
        return $this->hasMany(SupportTicketAttachment::class, 'ticket_id');
    }
}
