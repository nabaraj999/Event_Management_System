<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\SupportTicketReply;
use App\Models\SupportTicketAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\NewSupportTicketMail; // You'll create this mailable
use Illuminate\Support\Facades\Auth;

class SupportTicketController extends Controller
{
    /**
     * Display a listing of the organizer's tickets.
     */
    public function index()
    {
        $tickets = Auth::guard('organizer')->user()
            ->supportTickets()
            ->with('replies') // eager load replies
            ->latest()
            ->paginate(10);

        return view('organizer.support.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new ticket.
     */
    public function create()
    {
        return view('organizer.support.create');
    }

    /**
     * Store a newly created ticket.
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject'     => 'required|string|max:255',
            'message'     => 'required|string',
            'priority'    => 'required|in:normal,urgent',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:jpg,jpeg,png,gif,pdf,doc,docx,txt,zip|max:10240', // 10MB max per file
        ]);

        // Create the ticket
        $ticket = SupportTicket::create([
            'organizer_id' => Auth::guard('organizer')->id(),
            'subject'      => $request->subject,
            'message'      => $request->message,
            'priority'     => $request->priority,
            'status'       => 'open',
        ]);

        // Create the initial reply (organizer's message)
        $reply = SupportTicketReply::create([
            'ticket_id'     => $ticket->id,
            'replier_id'    => Auth::guard('organizer')->id(),
            'replier_type'  => 'organizer',
            'message'       => $request->message,
        ]);

        // Handle file attachments
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

        // Send email notification to Admin
       Mail::to(config('support.admin_email'))
    ->send(new NewSupportTicketMail($ticket));

        return redirect()
            ->route('org.support.index')
            ->with('success', 'Your support ticket has been submitted successfully! We will get back to you soon.');
    }

    /**
     * Display the specified ticket with conversation.
     */
    public function show(SupportTicket $ticket)
    {
        // Security: Ensure organizer can only view their own ticket
        if ($ticket->organizer_id !== Auth::guard('organizer')->id()) {
            abort(403);
        }

        $ticket->load(['replies.attachments', 'attachments']);

        // Mark as waiting for reply if last reply was from admin
        if ($ticket->replies->last()?->replier_type === 'admin') {
            $ticket->update(['status' => 'waiting_for_reply']);
        }

        return view('organizer.support.show', compact('ticket'));
    }

    /**
     * Add a reply to the ticket from organizer.
     */
    public function reply(Request $request, SupportTicket $ticket)
    {
        // Authorization
        if ($ticket->organizer_id !== Auth::guard('organizer')->id()) {
            abort(403);
        }

        $request->validate([
            'message'     => 'required|string',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:jpg,jpeg,png,gif,pdf,doc,docx,txt,zip|max:10240',
        ]);

        $reply = SupportTicketReply::create([
            'ticket_id'     => $ticket->id,
            'replier_id'    => Auth::guard('organizer')->id(),
            'replier_type'  => 'organizer',
            'message'       => $request->message,
        ]);

        // Handle attachments
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

        // Update ticket status
        $ticket->update([
            'status'           => 'open',
            'last_replied_at'  => now(),
        ]);

        return redirect()
            ->back()
            ->with('success', 'Your reply has been sent.');
    }
}
