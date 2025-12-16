<x-frontend.frontend-layout />

<div class="min-h-screen bg-gray-50 py-8 px-4 sm:py-12 sm:px-6">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-darkBlue mb-8 text-center sm:text-left">
            My Booking History
        </h1>

        @if($bookings->count() === 0)
            <div class="text-center py-16">
                <i class="fas fa-ticket-alt text-6xl text-gray-300 mb-4"></i>
                <p class="text-xl text-gray-600">You haven't booked any events yet.</p>
                <a href="{{ route('events.index') }}"
                   class="mt-6 inline-block bg-primary text-white px-8 py-3 rounded-lg font-semibold hover:bg-orange-600 transition">
                    Browse Events
                </a>
            </div>
        @else
            <div class="grid gap-8">
                @foreach($bookings as $booking)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col lg:flex-row">
                        <!-- Event Image -->
                        <div class="lg:w-80 h-56 lg:h-auto">
                            <img src="{{ $booking->event->banner_image ? asset('storage/' . $booking->event->banner_image) : asset('images/default-event.jpg') }}"
                                 alt="{{ $booking->event->title }}"
                                 class="w-full h-full object-cover">
                        </div>

                        <!-- Booking Details -->
                        <div class="flex-1 p-6 sm:p-8">
                            <div class="flex flex-col sm:flex-row justify-between items-start gap-4 mb-4">
                                <div>
                                    <h3 class="text-xl sm:text-2xl font-bold text-darkBlue">
                                        {{ $booking->event->title }}
                                    </h3>
                                    <p class="text-gray-600 mt-1 flex items-center text-sm sm:text-base">
                                        <i class="fas fa-calendar-alt mr-2"></i>
                                        {{ $booking->event->start_date->format('M d, Y') }}
                                        @if($booking->event->end_date)
                                            - {{ $booking->event->end_date->format('M d, Y') }}
                                        @endif
                                    </p>
                                    <p class="text-gray-500 text-sm mt-2 flex items-center">
                                        <i class="fas fa-map-marker-alt mr-2"></i>
                                        {{ Str::limit($booking->event->location, 40) }}
                                    </p>
                                </div>

                                <div class="text-center sm:text-right">
                                    <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold
                                        {{ $booking->payment_status === 'paid' ? 'bg-green-100 text-green-800' :
                                           ($booking->payment_status === 'failed' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                        {{ ucfirst($booking->payment_status) }}
                                    </span>
                                    <p class="mt-2 text-sm text-gray-600">
                                        Booking: {{ ucfirst($booking->status) }}
                                    </p>
                                </div>
                            </div>

                            <!-- Info Grid -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">
                                <div class="space-y-2 text-sm sm:text-base">
                                    <p><strong>Booked on:</strong> {{ $booking->created_at->format('M d, Y h:i A') }}</p>
                                    <p><strong>Name:</strong> {{ $booking->full_name }}</p>
                                    <p><strong>Email:</strong> {{ $booking->email }}</p>
                                    <p><strong>Phone:</strong> {{ $booking->phone }}</p>
                                    <p><strong>Transaction:</strong> {{ $booking->transaction_id ?? 'N/A' }}</p>
                                </div>

                                <div>
                                    <p class="text-2xl sm:text-3xl font-extrabold text-darkBlue">
                                        Rs. {{ number_format($booking->total_amount, 2) }}
                                    </p>

                                    <div class="mt-4">
                                        <p class="font-semibold text-gray-800">Tickets:</p>
                                        <ul class="mt-2 space-y-1 text-sm">
                                            @foreach($booking->bookingTickets as $bt)
                                                <li class="text-gray-700">
                                                    {{ $bt->quantity }} × {{ $bt->eventTicket->name }}
                                                    <span class="text-gray-500">
                                                        @ Rs. {{ number_format($bt->price_at_booking, 2) }}
                                                    </span>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <p class="mt-3 text-sm text-gray-600">
                                            Total: {{ $booking->bookingTickets->sum('quantity') }} ticket(s)
                                        </p>
                                    </div>

                                    @if($booking->is_checked_in)
                                        <p class="mt-4 text-green-600 font-bold flex items-center justify-end">
                                            <i class="fas fa-check-circle mr-2"></i> Checked In
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="mt-8 flex flex-wrap gap-3">
                                <button onclick="openTicketModal({{ $booking->id }})"
                                        class="bg-darkBlue text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary transition flex items-center">
                                    <i class="fas fa-ticket-alt mr-2"></i> View Ticket
                                </button>

                                @if($booking->payment_status === 'paid')
                                    <a href="{{ route('user.profile.invoice', $booking->ticket_token) }}"
                                       class="border border-darkBlue text-darkBlue px-6 py-3 rounded-lg font-semibold hover:bg-darkBlue hover:text-white transition flex items-center">
                                        <i class="fas fa-download mr-2"></i> Download Invoice
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-12 flex justify-center">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Ticket Modals with QR Code -->
@foreach($bookings as $booking)
<div id="ticket-modal-{{ $booking->id }}"
     class="fixed inset-0 bg-black bg-opacity-70 hidden flex items-center justify-center z-50 p-4 overflow-y-auto">
    <div class="bg-white rounded-2xl shadow-2xl max-w-3xl w-full my-8">
        <div class="bg-gradient-to-r from-darkBlue to-primary text-white p-6 sm:p-8 text-center relative">
            <h2 class="text-2xl sm:text-4xl font-extrabold">Event Ticket</h2>
            <p class="text-lg sm:text-xl mt-2 opacity-90">EventHUB</p>
            <button onclick="closeTicketModal({{ $booking->id }})"
                    class="absolute top-4 right-6 text-3xl hover:opacity-70">&times;</button>
        </div>

        <div class="p-6 sm:p-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="md:col-span-2 space-y-6">
                    <h3 class="text-2xl sm:text-3xl font-bold text-darkBlue">{{ $booking->event->title }}</h3>

                    <div class="space-y-4 text-base sm:text-lg">
                        <p class="flex items-center"><i class="fas fa-calendar-alt text-primary mr-4 w-8"></i>
                            <span>{{ $booking->event->start_date->format('l, F d, Y') }}
                                @if($booking->event->start_time) at {{ $booking->event->start_time }} @endif
                            </span>
                        </p>
                        <p class="flex items-center"><i class="fas fa-map-marker-alt text-primary mr-4 w-8"></i>
                            {{ $booking->event->location }}
                        </p>
                        <p class="flex items-center"><i class="fas fa-user text-primary mr-4 w-8"></i> {{ $booking->full_name }}</p>
                        <p class="flex items-center"><i class="fas fa-envelope text-primary mr-4 w-8"></i> {{ $booking->email }}</p>
                    </div>

                    <div class="mt-8 bg-gray-50 rounded-xl p-5">
                        <p class="font-bold text-gray-800 text-lg mb-3">Ticket Summary</p>
                        <div class="space-y-2">
                            @foreach($booking->bookingTickets as $bt)
                                <div class="flex justify-between text-gray-700">
                                    <span>{{ $bt->quantity }} × {{ $bt->eventTicket->name }}</span>
                                    <span>Rs. {{ number_format($bt->sub_total, 2) }}</span>
                                </div>
                            @endforeach
                        </div>
                        <hr class="my-4 border-dashed border-gray-300">
                        <div class="flex justify-between text-xl font-bold text-darkBlue">
                            <span>Total</span>
                            <span>Rs. {{ number_format($booking->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- QR Code Section -->
                <div class="flex flex-col items-center justify-center space-y-6">
                    <div class="bg-white p-4 rounded-2xl shadow-xl border-4 border-gray-100">
                        {!! QrCode::size(200)->generate(route('verify.ticket', $booking->ticket_token)) !!}
                    </div>
                    <div class="text-center">
                        <p class="text-xs text-gray-600">Scan at venue entrance</p>
                        <p class="mt-2 text-xs font-mono bg-gray-100 px-3 py-1 rounded">
                            {{ $booking->ticket_token }}
                        </p>
                        @if($booking->is_checked_in)
                            <p class="mt-4 px-6 py-2 bg-green-100 text-green-800 rounded-full font-bold text-sm">
                                CHECKED IN
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-10 text-center text-sm text-gray-500">
                <p>Thank you for booking with EventHUB!</p>
                <p class="mt-2">Present this digital ticket at the venue.</p>
            </div>
        </div>
    </div>
</div>
@endforeach

<script>
function openTicketModal(id) {
    document.getElementById('ticket-modal-' + id).classList.remove('hidden');
}
function closeTicketModal(id) {
    document.getElementById('ticket-modal-' + id).classList.add('hidden');
}
document.querySelectorAll('[id^="ticket-modal-"]').forEach(modal => {
    modal.addEventListener('click', (e) => {
        if (e.target === modal) closeTicketModal(modal.id.split('-')[2]);
    });
});
</script>

<style>
.bg-gradient-to-r { background: linear-gradient(to right, #063970, #FF7A28); }
</style>
