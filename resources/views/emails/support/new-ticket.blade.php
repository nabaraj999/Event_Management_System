<x-mail::message>
# New Support Ticket Received

**Ticket ID:** `{{ $ticket->ticket_id }}`
**Priority:** <span style="color: {{ $priority === 'urgent' ? 'red' : 'orange' }}; font-weight: bold;">{{ ucfirst($priority) }}</span>
**From:** {{ $organizer->name }} ({{ $organizer->email }})
**Subject:** {{ $ticket->subject }}

### Message:
<x-mail::panel>
{{ $ticket->message }}
</x-mail::panel>

@if($ticket->replies->first()->attachments->count() > 0)
### Attachments:
<x-mail::table>
| File Name | Size | Type |
|---------|------|------|
@foreach($ticket->replies->first()->attachments as $attachment)
| [{{ $attachment->file_name }}]({{ $attachment->getUrlAttribute() }}) | {{ number_format($attachment->file_size / 1024, 2) }} KB | {{ $attachment->file_type }} |
@endforeach
</x-mail::table>
@endif

<x-mail::button :url="$url">
View Ticket in Admin Panel
</x-mail::button>

Thanks,
{{ config('app.name') }} Support System
</x-mail::message>
