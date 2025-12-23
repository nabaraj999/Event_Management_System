<x-mail::message>
{{-- Clean Header with Brand Color --}}
<x-mail::panel class="bg-primary text-white text-center py-10 rounded-t-none">
    <h1 class="text-4xl font-bold mb-2">We've Replied to Your Ticket!</h1>
    <p class="text-xl text-orange-100">Your support request has been updated</p>
</x-mail::panel>

{{-- Greeting & Ticket Info --}}
<x-mail::panel class="pt-8">
    <p class="text-lg">Hello {{ $ticket->organizer->name }},</p>
    <p class="text-lg mt-4">Great news — our support team has responded to your ticket.</p>

    <x-mail::table class="mt-8 w-full">
        <tr>
            <td class="font-semibold text-gray-700 py-2">Ticket ID:</td>
            <td class="pl-6 py-2 text-lg"><strong>#{{ $ticket->ticket_id }}</strong></td>
        </tr>
        <tr>
            <td class="font-semibold text-gray-700 py-2">Subject:</td>
            <td class="pl-6 py-2">{{ $ticket->subject }}</td>
        </tr>
        <tr>
            <td class="font-semibold text-gray-700 py-2">Status:</td>
            <td class="pl-6 py-2">
                <span class="px-4 py-2 bg-green-100 text-green-800 rounded-full font-medium">
                    Replied
                </span>
            </td>
        </tr>
    </x-mail::table>
</x-mail::panel>

{{-- Latest Reply --}}
<x-mail::panel class="my-8">
    <h2 class="text-2xl font-bold text-darkBlue mb-6">Latest Response from Support Team</h2>
    <div class="bg-gray-50 border-l-4 border-primary p-8 rounded-r-lg text-gray-800 leading-relaxed text-lg">
        {!! nl2br(e($replyMessage)) !!}
    </div>
</x-mail::panel>

{{-- Call to Action --}}
<x-mail::button :url="$url" color="primary" class="text-xl py-4 px-10">
    View Full Conversation & Reply
</x-mail::button>

{{-- Footer --}}
<x-mail::panel class="text-center text-gray-500 text-sm mt-12 pt-8 border-t">
    <p>Thank you for using <strong>{{ config('app.name') }}</strong></p>
    <p class="mt-2">If you have more questions, just reply to this email or visit your ticket.</p>
    <p class="mt-4">&copy; {{ now()->year }} {{ config('app.name') }}. All rights reserved.</p>
</x-mail::panel>
</x-mail::message>
