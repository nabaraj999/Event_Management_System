<x-organizer.organizer-layout  title="Booking #{{ $booking->id }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
          integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8">
        <div class="bg-white shadow-2xl rounded-2xl overflow-hidden">

            <!-- Header -->
            <div class="bg-[#063970] text-white px-6 py-6 lg:px-8 lg:py-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                    <div>
                        <h1 class="text-2xl lg:text-3xl font-bold">Booking #{{ $booking->id }}</h1>
                        <p class="opacity-90 text-sm lg:text-base mt-2">
                            {{ $booking->created_at->format('d M Y, h:i A') }}
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm opacity-80">Total Amount</p>
                        <p class="text-3xl lg:text-4xl font-bold text-[#FF7A28]">
                            NPR {{ number_format($booking->total_amount, 2) }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Flash Messages -->
            @if(session('success'))
                <div class="mx-6 lg:mx-8 mt-6 bg-orange-50 border-l-4 border-[#FF7A28] text-orange-800 px-5 py-4 rounded-r-lg text-sm lg:text-base">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mx-6 lg:mx-8 mt-6 bg-red-50 border-l-4 border-red-500 text-red-800 px-5 py-4 rounded-r-lg text-sm lg:text-base">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('info'))
                <div class="mx-6 lg:mx-8 mt-6 bg-blue-50 border-l-4 border-blue-500 text-blue-800 px-5 py-4 rounded-r-lg text-sm lg:text-base">
                    {{ session('info') }}
                </div>
            @endif

            <div class="p-6 lg:p-8">

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    <!-- Main Content (Left) -->
                    <div class="lg:col-span-2 space-y-8">

                        <!-- Customer Information -->
                        <div class="bg-white border border-gray-200 rounded-xl shadow hover:shadow-lg transition p-6">
                            <h2 class="text-xl font-bold text-[#063970] mb-5">Customer Information</h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm">
                                <div>
                                    <p class="text-gray-500 mb-1">Full Name</p>
                                    <p class="font-semibold text-[#063970]">{{ $booking->full_name }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 mb-1">Email</p>
                                    <p class="font-medium">{{ $booking->email }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 mb-1">Phone</p>
                                    <p class="font-medium">{{ $booking->phone }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 mb-1">Ticket Token</p>
                                    <p class="font-mono text-xs bg-gray-100 px-4 py-2 rounded-lg break-all">
                                        {{ $booking->ticket_token }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Ticket Details -->
                        <div class="bg-white border border-gray-200 rounded-xl shadow hover:shadow-lg transition p-6">
                            <h2 class="text-xl font-bold text-[#063970] mb-5">Ticket Details</h2>
                            <p class="text-lg font-semibold text-gray-800 mb-6">
                                {{ $booking->event->title ?? 'Event Deleted' }}
                            </p>

                            <div class="overflow-x-auto">
                                <table class="w-full text-sm border border-gray-200 rounded-lg">
                                    <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                                        <tr>
                                            <th class="px-6 py-4 text-left">Ticket Type</th>
                                            <th class="px-6 py-4 text-center">Quantity</th>
                                            <th class="px-6 py-4 text-right">Unit Price</th>
                                            <th class="px-6 py-4 text-right">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y">
                                        @foreach($booking->bookingTickets as $bt)
                                            <tr class="hover:bg-orange-50 transition">
                                                <td class="px-6 py-4">
                                                    {{ $bt->eventTicket->name ?? 'Deleted Ticket' }}
                                                </td>
                                                <td class="px-6 py-4 text-center font-medium">{{ $bt->quantity }}</td>
                                                <td class="px-6 py-4 text-right">
                                                    NPR {{ number_format($bt->price_at_booking, 2) }}
                                                </td>
                                                <td class="px-6 py-4 text-right font-semibold">
                                                    NPR {{ number_format($bt->sub_total, 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr class="bg-[#FF7A28]/5 font-bold">
                                            <td colspan="3" class="px-6 py-4 text-right text-[#063970]">
                                                Total
                                            </td>
                                            <td class="px-6 py-4 text-right text-2xl text-[#FF7A28]">
                                                NPR {{ number_format($booking->total_amount, 2) }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar (Right) -->
                    <div class="space-y-8">

                        <!-- Status Card -->
                        <div class="bg-white border border-gray-200 rounded-xl shadow hover:shadow-lg transition p-6">
                            <h3 class="text-xl font-bold text-[#063970] mb-5">Booking Status</h3>

                            <div class="space-y-6">
                                <div>
                                    <p class="text-sm text-gray-500 mb-2">Payment Status</p>
                                    @switch($booking->payment_status)
                                        @case('paid')
                                            <span class="px-4 py-2 rounded-full text-sm font-medium bg-green-100 text-green-800">Paid</span>
                                            @break
                                        @case('pending')
                                            <span class="px-4 py-2 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">Pending</span>
                                            @break
                                        @case('failed')
                                            <span class="px-4 py-2 rounded-full text-sm font-medium bg-red-100 text-red-800">Failed</span>
                                            @break
                                        @default
                                            <span class="px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-700">
                                                {{ ucfirst($booking->payment_status) }}
                                            </span>
                                    @endswitch
                                </div>

                                <div>
                                    <p class="text-sm text-gray-500 mb-2">Check-In Status</p>
                                    @if($booking->is_checked_in)
                                        <div>
                                            <span class="px-4 py-2 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                Checked In
                                            </span>
                                            <p class="text-xs text-gray-500 mt-2">
                                                {{ $booking->checked_in_at->format('d M Y, h:i A') }}
                                            </p>
                                        </div>
                                    @else
                                        <span class="px-4 py-2 rounded-full text-sm font-medium bg-orange-100 text-orange-800">
                                            Not Checked In
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Manual Check-In -->
                        @if(!$booking->is_checked_in && $booking->payment_status === 'paid')
                            <div class="bg-green-50 border-2 border-green-300 rounded-xl p-6 text-center">
                                <p class="font-bold text-lg text-green-800 mb-4">Manual Check-In</p>
                                <p class="text-sm text-gray-700 mb-6">
                                    Mark this attendee as checked in at the event venue.
                                </p>

                                <form action="{{ route('org.bookings.check-in', $booking) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit"
                                            onclick="return confirm('Check in Booking #{{ $booking->id }}?\n\nName: {{ addslashes($booking->full_name) }}\nThis action cannot be undone.')"
                                            class="w-full py-4 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg transition shadow-lg text-lg">
                                        Check In
                                    </button>
                                </form>
                            </div>
                        @endif

                        <!-- QR Code -->
                        @if($booking->ticket_token)
                            <div class="bg-white border border-gray-200 rounded-xl shadow hover:shadow-lg transition p-6 text-center">
                                <p class="text-xl font-bold text-[#063970] mb-5">Ticket QR Code</p>
                                <div class="inline-block p-4 bg-gray-50 rounded-xl">
                                    {!! QrCode::size(200)->generate(route('verify.ticket', $booking->ticket_token)) !!}
                                </div>
                                <p class="text-xs text-gray-500 mt-4">
                                    Scan this QR at the venue entrance
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Back Button -->
                <div class="mt-12 text-center">
                    <a href="{{ route('org.bookings.index') }}"
                       class="inline-flex items-center gap-3 px-8 py-4 bg-[#063970] hover:bg-[#052e5c] text-white font-bold rounded-lg transition shadow-lg text-lg">
                        ← Back to Bookings List
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-organizer.organizer-layout>
