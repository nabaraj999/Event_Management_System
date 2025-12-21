<x-organizer.organizer-layout title="Manage Bookings">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
          integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8">
        <div class="bg-white shadow-2xl rounded-2xl overflow-hidden">

            <!-- Header + Search -->
            <div class="bg-[#063970] text-white px-6 py-5 lg:px-8 lg:py-6">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <h1 class="text-2xl lg:text-3xl font-bold">Manage Bookings</h1>
                        <p class="opacity-90 text-sm lg:text-base mt-1">All event ticket bookings</p>
                    </div>

                    <!-- Search Form -->
                    <form method="GET" action="{{ route('org.bookings.index') }}" class="flex flex-col sm:flex-row gap-3">
                        <input type="text" name="query" value="{{ request('query') }}"
                               placeholder="Search by ID, name, email, phone or token"
                               class="w-full sm:w-80 px-4 py-3 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-white" />

                        <div class="flex gap-3">
                            <button type="submit"
                                    class="w-full sm:w-auto px-6 py-3 bg-white text-[#FF7A28] font-bold rounded-lg hover:bg-gray-100 transition shadow">
                                Search
                            </button>

                            @if(request('query'))
                                <a href="{{ route('org.bookings.index') }}"
                                   class="w-full sm:w-auto text-center px-6 py-3 bg-white text-[#FF7A28] font-bold rounded-lg hover:bg-gray-100 transition shadow">
                                    Clear
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="mx-6 lg:mx-8 mt-4 lg:mt-6 bg-orange-50 border-l-4 border-[#FF7A28] text-orange-800 px-5 py-4 rounded-r-lg text-sm lg:text-base">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Responsive Table / Cards -->
            <div class="overflow-x-auto">

                <!-- Desktop Table -->
                <table class="w-full text-sm text-left text-gray-700 hidden lg:table">
                    <thead class="text-xs uppercase bg-gray-100 text-gray-600">
                        <tr>
                            <th class="px-6 py-4">#</th>
                            <th class="px-6 py-4">Attendee</th>
                            <th class="px-6 py-4">Event</th>
                            <th class="px-6 py-4">Total Amount</th>
                            <th class="px-6 py-4 text-center">Payment</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $index => $booking)
                            <tr class="bg-white border-b hover:bg-orange-50 transition">
                                <td class="px-6 py-5 font-medium">#{{ $booking->id }}</td>
                                <td class="px-6 py-5">
                                    <p class="font-semibold text-[#063970]">{{ $booking->full_name }}</p>
                                    <p class="text-xs text-gray-500">{{ $booking->email }}</p>
                                </td>
                                <td class="px-6 py-5 font-medium">
                                    {{ Str::limit($booking->event->title ?? 'N/A', 40) }}
                                </td>
                                <td class="px-6 py-5 font-semibold text-[#FF7A28]">
                                    NPR {{ number_format($booking->total_amount, 2) }}
                                </td>
                                <td class="px-6 py-5 text-center">
                                    @include('organizer.bookings.partials.payment-badge', ['status' => $booking->payment_status])
                                </td>
                                <td class="px-6 py-5 text-center">
                                    @include('organizer.bookings.partials.booking-status-badge', ['status' => $booking->status])
                                </td>

                                <td class="px-6 py-5 text-center">
                                    <a href="{{ route('org.bookings.show', $booking) }}"
                                       class="px-5 py-2 bg-[#063970] text-white rounded-lg hover:bg-[#052e5c] transition text-sm font-medium">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-20 text-center text-gray-500 text-lg">
                                    @if(request('query'))
                                        No results for "<strong>{{ request('query') }}</strong>"
                                    @else
                                        No bookings found
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Mobile Cards -->
                <div class="lg:hidden">
                    @forelse($bookings as $booking)
                        <div class="m-4 p-5 bg-white border border-gray-200 rounded-xl shadow hover:shadow-lg transition">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <h3 class="font-bold text-[#063970] text-lg">#{{ $booking->id }}</h3>
                                    <p class="text-xs text-gray-500">
                                        {{ $booking->created_at->format('d M Y, h:i A') }}
                                    </p>
                                </div>
                                <div class="flex gap-2 flex-wrap">
                                    @include('organizer.bookings.partials.payment-badge', ['status' => $booking->payment_status])
                                    @include('organizer.bookings.partials.booking-status-badge', ['status' => $booking->status])
                                </div>
                            </div>

                            <div class="space-y-3 text-sm">
                                <div>
                                    <p class="text-gray-500">Attendee</p>
                                    <p class="font-semibold text-[#063970]">{{ $booking->full_name }}</p>
                                    <p class="text-gray-600">{{ $booking->email }}</p>
                                </div>

                                <div>
                                    <p class="text-gray-500">Event</p>
                                    <p class="font-medium">{{ $booking->event->title ?? 'N/A' }}</p>
                                </div>

                                <div class="flex justify-between items-end">
                                    <div>
                                        <p class="text-gray-500">Total Amount</p>
                                        <p class="font-bold text-2xl text-[#FF7A28]">
                                            NPR {{ number_format($booking->total_amount, 2) }}
                                        </p>
                                    </div>
                                    <a href="{{ route('org.bookings.show', $booking) }}"
                                       class="px-6 py-3 bg-[#063970] text-white rounded-lg hover:bg-[#052e5c] transition font-medium">
                                        View →
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="m-6 p-10 text-center text-gray-500 bg-gray-50 rounded-xl">
                            <p class="text-xl mb-4">
                                @if(request('query'))
                                    No results found
                                @else
                                    No bookings yet
                                @endif
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            <div class="bg-gray-50 px-6 py-4 flex flex-col sm:flex-row items-center justify-between border-t text-sm">
                <div class="text-gray-600 mb-3 sm:mb-0">
                    Showing {{ $bookings->firstItem() ?? 0 }} to {{ $bookings->lastItem() ?? 0 }} of {{ $bookings->total() }} entries
                </div>
                <div>
                    {{ $bookings->appends(request()->query())->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    </div>
</x-organizer.organizer-layout>
