<x-admin.admin-layout>

<div class="py-8 px-4 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="bg-darkBlue text-white rounded-2xl shadow-xl p-6 mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold">Booking #{{ $booking->id }}</h1>
                <p class="text-blue-200 text-sm mt-1">Detailed ticket booking information</p>
            </div>
            <div class="text-right">
                <div class="text-xs opacity-90">Booked on</div>
                <div class="text-lg font-semibold">
                    {{ $booking->created_at->format('d M Y') }}
                    <span class="text-sm opacity-80">{{ $booking->created_at->format('h:i A') }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Customer Card -->
            <div class="bg-white rounded-2xl shadow-xl p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Customer
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500">Name</p>
                        <p class="font-semibold text-gray-900">{{ $booking->full_name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Email</p>
                        <p class="font-medium text-gray-900">{{ $booking->email }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Phone</p>
                        <p class="font-medium text-gray-900">{{ $booking->phone }}</p>
                    </div>
                    @if($booking->user)
                        <div>
                            <p class="text-gray-500">Account</p>
                            <p class="font-medium text-primary">Registered (ID: {{ $booking->user->id }})</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Event & Tickets -->
            <div class="bg-white rounded-2xl shadow-xl p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h-4m-6 0H9"/></svg>
                    Event & Tickets
                </h2>
                <div class="mb-4">
                    <p class="text-sm text-gray-500">Event</p>
                    <p class="text-lg font-bold text-gray-900">{{ $booking->event->title ?? 'Event Deleted' }}</p>
                </div>

                <div class="overflow-hidden rounded-xl border border-gray-200">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">Ticket Type</th>
                                <th class="px-4 py-3 text-center font-semibold text-gray-700">Qty</th>
                                <th class="px-4 py-3 text-right font-semibold text-gray-700">Price</th>
                                <th class="px-4 py-3 text-right font-semibold text-gray-700">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($booking->bookingTickets as $bt)
                                <tr>
                                    <td class="px-4 py-3 font-medium text-gray-900">
                                        {{ $bt->eventTicket->name ?? 'Deleted' }}
                                    </td>
                                    <td class="px-4 py-3 text-center text-gray-700">{{ $bt->quantity }}</td>
                                    <td class="px-4 py-3 text-right text-gray-700">NPR {{ number_format($bt->price_at_booking, 2) }}</td>
                                    <td class="px-4 py-3 text-right font-semibold text-gray-900">NPR {{ number_format($bt->sub_total, 2) }}</td>
                                </tr>
                            @endforeach
                            <tr class="bg-primary/5 font-bold text-right">
                                <td colspan="3" class="px-4 py-3 text-gray-800">Total</td>
                                <td class="px-4 py-3 text-primary text-lg">NPR {{ number_format($booking->total_amount, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Status -->
            <div class="bg-white rounded-2xl shadow-xl p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Status</h3>
                <div class="space-y-4 text-sm">
                    <div>
                        <p class="text-gray-500 mb-1">Payment</p>
                        @switch($booking->payment_status)
                            @case('paid')     <span class="px-3 py-1.5 font-medium bg-green-100 text-green-800 rounded-full text-xs">Paid</span> @break
                            @case('pending')  <span class="px-3 py-1.5 font-medium bg-yellow-100 text-yellow-800 rounded-full text-xs">Pending</span> @break
                            @case('failed')   <span class="px-3 py-1.5 font-medium bg-red-100 text-red-800 rounded-full text-xs">Failed</span> @break
                            @case('refunded') <span class="px-3 py-1.5 font-medium bg-purple-100 text-purple-800 rounded-full text-xs">Refunded</span> @break
                            @default          <span class="px-3 py-1.5 font-medium bg-gray-100 text-gray-800 rounded-full text-xs">{{ ucfirst($booking->payment_status) }}</span>
                        @endswitch
                    </div>
                    <div>
                        <p class="text-gray-500 mb-1">Booking</p>
                        @switch($booking->status)
                            @case('confirmed') <span class="px-3 py-1.5 font-medium bg-blue-100 text-blue-800 rounded-full text-xs">Confirmed</span> @break
                            @case('pending')   <span class="px-3 py-1.5 font-medium bg-orange-100 text-orange-800 rounded-full text-xs">Pending</span> @break
                            @case('cancelled') <span class="px-3 py-1.5 font-medium bg-gray-100 text-gray-800 rounded-full text-xs">Cancelled</span> @break
                            @default           <span class="px-3 py-1.5 font-medium bg-gray-100 text-gray-800 rounded-full text-xs">{{ ucfirst($booking->status) }}</span>
                        @endswitch
                    </div>
                </div>
            </div>

            <!-- Payment Info -->
            <div class="bg-white rounded-2xl shadow-xl p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Payment</h3>
                <div class="text-sm space-y-3">
                    <div>
                        <p class="text-gray-500">Method</p>
                        <p class="font-medium capitalize">{{ str_replace('_', ' ', $booking->payment_method) }}</p>
                    </div>
                    @if($booking->transaction_id)
                        <div>
                            <p class="text-gray-500">Transaction ID</p>
                            <p class="font-mono text-xs bg-gray-100 px-3 py-2 rounded break-all">{{ $booking->transaction_id }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- QR Code -->
            @if($booking->ticket_token)
                <div class="bg-white rounded-2xl shadow-xl p-6 text-center">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Ticket QR Code</h3>
                    <div class="inline-block p-3 bg-white border-4 border-gray-200 rounded-xl shadow">
                        {!! QrCode::size(160)->generate(route('verify.ticket', $booking->ticket_token)) !!}
                    </div>
                    <p class="mt-3 text-xs text-gray-600">Scan at venue for entry</p>
                    <p class="mt-1 text-xs text-gray-500 font-mono">{{ $booking->ticket_token }}</p>
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-xl p-6 text-center">
                    <p class="text-gray-500 text-sm">No QR code (payment incomplete)</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Back Button -->
    <div class="mt-6">
        <a href="{{ route('admin.bookings.index') }}"
           class="inline-flex items-center px-5 py-2.5 bg-gray-600 text-white font-bold rounded-xl hover:bg-gray-700 transition text-sm">
            ← Back to Bookings
        </a>
    </div>
</div>

</x-admin.admin-layout>
