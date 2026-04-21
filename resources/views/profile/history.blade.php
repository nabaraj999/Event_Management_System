<x-frontend.frontend-layout />

<!-- Page Header -->
<div class="bg-gradient-to-br from-darkBlue via-[#0a4f9e] to-darkBlue pt-28 pb-16 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-96 h-96 bg-primary/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 text-white">
        <p class="text-primary font-bold text-xs mb-2 uppercase tracking-widest">Account</p>
        <h1 class="font-raleway text-4xl sm:text-5xl font-black mb-2">My Bookings</h1>
        <p class="text-white/60 text-base">All your event bookings and digital tickets in one place</p>
    </div>
</div>

<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">

        @if($bookings->count() === 0)
            <!-- Empty State -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 py-24 text-center">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-ticket-alt text-gray-400 text-3xl"></i>
                </div>
                <h3 class="font-raleway font-black text-xl text-gray-600 mb-2">No Bookings Yet</h3>
                <p class="text-gray-400 text-sm mb-8">You haven't booked any events yet. Start exploring!</p>
                <a href="{{ route('events.index') }}"
                   class="btn-primary inline-flex items-center gap-2 px-8 py-3.5 text-white font-bold rounded-xl shadow-lg">
                    <i class="fas fa-search"></i> Browse Events
                </a>
            </div>

        @else
            <div class="space-y-6">
                @foreach($bookings as $booking)
                    @php
                        $statusColors = [
                            'paid'    => 'bg-green-100 text-green-700 border-green-200',
                            'failed'  => 'bg-red-100 text-red-700 border-red-200',
                            'pending' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                            'refunded'=> 'bg-purple-100 text-purple-700 border-purple-200',
                        ];
                        $statusIcons = [
                            'paid'    => 'fa-check-circle',
                            'failed'  => 'fa-times-circle',
                            'pending' => 'fa-clock',
                            'refunded'=> 'fa-undo',
                        ];
                        $colorClass = $statusColors[$booking->payment_status] ?? 'bg-gray-100 text-gray-600 border-gray-200';
                        $iconClass  = $statusIcons[$booking->payment_status]  ?? 'fa-circle';
                    @endphp

                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="flex flex-col lg:flex-row">

                            <!-- Event Image -->
                            <div class="lg:w-72 xl:w-80 h-52 lg:h-auto flex-shrink-0 relative overflow-hidden">
                                <img src="{{ $booking->event->banner_image ? asset('storage/' . $booking->event->banner_image) : 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=600' }}"
                                     alt="{{ $booking->event->title }}"
                                     class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-r from-transparent to-black/10 lg:bg-gradient-to-l"></div>
                            </div>

                            <!-- Details -->
                            <div class="flex-1 p-6 sm:p-8">
                                <!-- Top Row -->
                                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3 mb-5">
                                    <div>
                                        <h3 class="font-raleway font-black text-xl sm:text-2xl text-darkBlue leading-tight">
                                            {{ $booking->event->title }}
                                        </h3>
                                        <div class="flex flex-wrap items-center gap-3 mt-2 text-sm text-gray-500 font-medium">
                                            <span class="flex items-center gap-1.5">
                                                <i class="fas fa-calendar-alt text-primary text-xs"></i>
                                                {{ $booking->event->start_date->format('M d, Y') }}
                                                @if($booking->event->end_date)
                                                    &ndash; {{ $booking->event->end_date->format('M d, Y') }}
                                                @endif
                                            </span>
                                            <span class="flex items-center gap-1.5">
                                                <i class="fas fa-map-marker-alt text-primary text-xs"></i>
                                                {{ Str::limit($booking->event->location, 35) }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Status Badge -->
                                    <div class="flex-shrink-0">
                                        <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-xs font-black border {{ $colorClass }}">
                                            <i class="fas {{ $iconClass }} text-xs"></i>
                                            {{ ucfirst($booking->payment_status) }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Info Grid -->
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 py-4 border-t border-b border-gray-100 mb-5">
                                    <div>
                                        <p class="text-xs font-black text-gray-400 uppercase tracking-wider mb-1">Booked On</p>
                                        <p class="text-sm font-bold text-darkBlue">{{ $booking->created_at->format('M d, Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-black text-gray-400 uppercase tracking-wider mb-1">Attendee</p>
                                        <p class="text-sm font-bold text-darkBlue truncate">{{ $booking->full_name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-black text-gray-400 uppercase tracking-wider mb-1">Tickets</p>
                                        <p class="text-sm font-bold text-darkBlue">{{ $booking->bookingTickets->sum('quantity') }} ticket(s)</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-black text-gray-400 uppercase tracking-wider mb-1">Total Paid</p>
                                        <p class="text-base font-black text-primary">Rs. {{ number_format($booking->total_amount, 0) }}</p>
                                    </div>
                                </div>

                                <!-- Ticket List -->
                                <div class="flex flex-wrap gap-2 mb-5">
                                    @foreach($booking->bookingTickets as $bt)
                                        <span class="inline-flex items-center gap-1.5 bg-gray-100 text-gray-700 text-xs font-bold px-3 py-1.5 rounded-full">
                                            <i class="fas fa-ticket-alt text-primary text-xs"></i>
                                            {{ $bt->quantity }} × {{ $bt->eventTicket->name }}
                                            <span class="text-gray-500 font-normal">@ Rs. {{ number_format($bt->price_at_booking, 0) }}</span>
                                        </span>
                                    @endforeach
                                    @if($booking->is_checked_in)
                                        <span class="inline-flex items-center gap-1.5 bg-green-100 text-green-700 text-xs font-black px-3 py-1.5 rounded-full">
                                            <i class="fas fa-check-circle text-xs"></i> Checked In
                                        </span>
                                    @endif
                                </div>

                                <!-- Actions -->
                                <div class="flex flex-wrap gap-3">
                                    <button onclick="openTicketModal({{ $booking->id }})"
                                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-darkBlue text-white font-bold rounded-xl hover:bg-primary transition-colors text-sm shadow-md">
                                        <i class="fas fa-qrcode"></i> View Ticket
                                    </button>

                                    @if($booking->payment_status === 'paid')
                                        <a href="{{ route('user.profile.invoice', $booking->ticket_token) }}"
                                           class="inline-flex items-center gap-2 px-5 py-2.5 border-2 border-darkBlue text-darkBlue font-bold rounded-xl hover:bg-darkBlue hover:text-white transition-all text-sm">
                                            <i class="fas fa-download"></i> Download Invoice
                                        </a>
                                    @endif

                                    <a href="{{ route('events.show', $booking->event) }}"
                                       class="inline-flex items-center gap-2 px-5 py-2.5 border-2 border-gray-200 text-gray-600 font-bold rounded-xl hover:border-primary hover:text-primary transition-all text-sm">
                                        <i class="fas fa-external-link-alt"></i> View Event
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($bookings->hasPages())
                <div class="mt-10 flex justify-center">
                    {{ $bookings->links('pagination::tailwind') }}
                </div>
            @endif
        @endif

    </div>
</div>

<!-- Ticket Modals -->
@foreach($bookings as $booking)
<div id="ticket-modal-{{ $booking->id }}"
     class="fixed inset-0 bg-black/70 backdrop-blur-sm hidden items-center justify-center z-50 p-4 overflow-y-auto"
     style="display:none;">
    <div class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full my-8 overflow-hidden">

        <!-- Modal Header -->
        <div class="relative bg-gradient-to-r from-darkBlue to-primary px-8 py-7 text-center">
            <button onclick="closeTicketModal({{ $booking->id }})"
                    class="absolute top-4 right-4 w-8 h-8 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center transition-colors">
                <i class="fas fa-xmark text-white text-sm"></i>
            </button>
            <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-3">
                <i class="fas fa-ticket-alt text-white text-xl"></i>
            </div>
            <h2 class="font-raleway font-black text-2xl text-white">Event Ticket</h2>
            <p class="text-white/70 text-sm mt-1">EventHUB — Digital Entry Pass</p>
        </div>

        <!-- Dashed divider -->
        <div class="relative flex items-center px-8 py-2 bg-gray-50">
            <div class="w-7 h-7 bg-gray-100 rounded-full absolute -left-3.5 border-2 border-gray-200"></div>
            <div class="flex-1 border-t-2 border-dashed border-gray-200 mx-4"></div>
            <div class="w-7 h-7 bg-gray-100 rounded-full absolute -right-3.5 border-2 border-gray-200"></div>
        </div>

        <!-- Modal Body -->
        <div class="px-8 py-6">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-8">

                <!-- Event Info -->
                <div class="md:col-span-3 space-y-4">
                    <h3 class="font-raleway font-black text-xl text-darkBlue">{{ $booking->event->title }}</h3>

                    <div class="space-y-3">
                        <div class="flex items-center gap-3 text-sm text-gray-600">
                            <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-calendar-alt text-primary text-xs"></i>
                            </div>
                            <span class="font-medium">{{ $booking->event->start_date->format('l, F d, Y') }}
                                @if($booking->event->start_time) at {{ $booking->event->start_time }} @endif
                            </span>
                        </div>
                        <div class="flex items-center gap-3 text-sm text-gray-600">
                            <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-map-marker-alt text-primary text-xs"></i>
                            </div>
                            <span class="font-medium">{{ $booking->event->location }}</span>
                        </div>
                        <div class="flex items-center gap-3 text-sm text-gray-600">
                            <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-user text-primary text-xs"></i>
                            </div>
                            <span class="font-medium">{{ $booking->full_name }}</span>
                        </div>
                        <div class="flex items-center gap-3 text-sm text-gray-600">
                            <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-envelope text-primary text-xs"></i>
                            </div>
                            <span class="font-medium">{{ $booking->email }}</span>
                        </div>
                    </div>

                    <!-- Ticket Summary -->
                    <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100">
                        <p class="text-xs font-black text-gray-500 uppercase tracking-wider mb-3">Ticket Summary</p>
                        <div class="space-y-2">
                            @foreach($booking->bookingTickets as $bt)
                                <div class="flex justify-between text-sm text-gray-700 font-medium">
                                    <span>{{ $bt->quantity }} × {{ $bt->eventTicket->name }}</span>
                                    <span class="font-bold">Rs. {{ number_format($bt->sub_total, 0) }}</span>
                                </div>
                            @endforeach
                        </div>
                        <div class="flex justify-between items-center mt-3 pt-3 border-t border-dashed border-gray-200">
                            <span class="text-sm font-black text-darkBlue">Total</span>
                            <span class="text-lg font-black text-primary">Rs. {{ number_format($booking->total_amount, 0) }}</span>
                        </div>
                    </div>
                </div>

                <!-- QR Code -->
                <div class="md:col-span-2 flex flex-col items-center justify-start gap-4">
                    <div class="bg-white p-4 rounded-2xl shadow-md border-2 border-gray-100">
                        {!! QrCode::size(160)->generate(route('verify.ticket', $booking->ticket_token)) !!}
                    </div>
                    <div class="text-center">
                        <p class="text-xs font-black text-gray-500 uppercase tracking-wider mb-2">Scan at Venue</p>
                        <p class="text-xs font-mono bg-gray-100 px-3 py-1.5 rounded-lg text-gray-600 break-all">
                            {{ $booking->ticket_token }}
                        </p>
                        @if($booking->is_checked_in)
                            <div class="mt-3 inline-flex items-center gap-1.5 bg-green-100 text-green-700 text-xs font-black px-4 py-2 rounded-full">
                                <i class="fas fa-check-circle text-xs"></i> CHECKED IN
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <p class="text-center text-xs text-gray-400 mt-6 pb-2">
                Thank you for booking with EventHUB — Present this ticket at the venue entrance
            </p>
        </div>
    </div>
</div>
@endforeach

<script>
function openTicketModal(id) {
    const modal = document.getElementById('ticket-modal-' + id);
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function closeTicketModal(id) {
    const modal = document.getElementById('ticket-modal-' + id);
    modal.style.display = 'none';
    document.body.style.overflow = '';
}
document.querySelectorAll('[id^="ticket-modal-"]').forEach(modal => {
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            const id = modal.id.replace('ticket-modal-', '');
            closeTicketModal(id);
        }
    });
});
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        document.querySelectorAll('[id^="ticket-modal-"]').forEach(modal => {
            modal.style.display = 'none';
        });
        document.body.style.overflow = '';
    }
});
</script>
