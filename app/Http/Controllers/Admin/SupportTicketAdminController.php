<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\SupportTicketReply;
use App\Models\SupportTicketAttachment;
use App\Mail\TicketReplyMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class SupportTicketAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = SupportTicket::with(['organizer', 'replies'])->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('ticket_id', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhereHas('organizer', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        $tickets = $query->paginate(15);

        return view('admin.support.index', compact('tickets'));
    }

    public function show(SupportTicket $ticket)
    {
        $ticket->load(['replies.attachments', 'organizer']);

        return view('admin.support.show', compact('ticket'));
    }

    public function reply(Request $request, SupportTicket $ticket)
    {
        $request->validate([
            'message' => 'required|string',
            'attachments.*' => 'file|mimes:jpg,jpeg,png,gif,pdf,doc,docx,txt,zip|max:10240',
        ]);

        $reply = SupportTicketReply::create([
            'ticket_id'     => $ticket->id,
            'replier_id'    => Auth::guard('admin')->id(),
            'replier_type'  => 'admin',
            'message'       => $request->message,
        ]);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('support-tickets/' . $ticket->id, 'public');

                SupportTicketAttachment::create([
                    'ticket_id'  => $ticket->id,
                    'reply_id'   => $reply->id,
                    'file_name'  => $file->getClientOriginalName(),
                    'file_path'  => $path,
                    'file_type'  => $file->getClientMimeType(),
                    'file_size'  => $file->getSize(),
                ]);
            }
        }

        $ticket->update([
            'status' => 'replied',
            'last_replied_at' => now(),
        ]);

        // Send email to organizer
        Mail::to($ticket->organizer->email)->send(
            new TicketReplyMail($ticket, $request->message)
        );

        return back()->with('success', 'Reply sent successfully! Organizer has been notified.');
    }

    public function close(SupportTicket $ticket)
    {
        $ticket->update(['status' => 'closed']);

        return back()->with('success', 'Ticket has been closed.');
    }
}
