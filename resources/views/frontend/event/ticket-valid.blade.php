<x-frontend.frontend-layout>
<div class="py-20 bg-green-50 min-h-screen">
    <div class="max-w-2xl mx-auto text-center">
        <h1 class="text-5xl font-bold text-green-600 mb-8">✓ Valid Ticket</h1>
        <div class="bg-white rounded-3xl shadow-2xl p-10">
            <p class="text-2xl mb-6">Welcome, {{ $booking->full_name }}!</p>
            <p class="text-xl"><strong>Event:</strong> {{ $booking->event->title }}</p>
            <p class="text-xl"><strong>Ticket:</strong> {{ $booking->bookingTickets->first()->eventTicket->name }}</p>
            <p class="text-xl"><strong>Quantity:</strong> {{ $booking->bookingTickets->first()->quantity }}</p>
            <p class="text-xl mt-8 text-green-600 font-bold">Enjoy the event! 🎉</p>
        </div>
    </div>
</div>
</x-frontend.frontend-layout>
