<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportTicketReply extends Model
{
    protected $fillable = ['ticket_id', 'replier_id', 'replier_type', 'message'];

   public function ticket()
    {
        return $this->belongsTo(SupportTicket::class, 'ticket_id');
    }

    public function attachments()
    {
        return $this->hasMany(SupportTicketAttachment::class, 'reply_id');
    }

    public function replier()
    {
        return $this->morphTo('replier', 'replier_type', 'replier_id');
    }
}
