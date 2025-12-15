<x-admin.admin-layout>

<div class="py-8 px-4 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="bg-darkBlue text-white rounded-2xl shadow-xl p-8 mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold">Manage Bookings</h1>
                <p class="text-blue-200 mt-1">View and manage all event ticket bookings</p>
            </div>
        </div>
    </div>

    <!-- Search & Filters Bar -->
    <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
        <form method="GET" action="{{ route('admin.bookings.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Booking ID</label>
                <input type="number" name="booking_id" value="{{ request('booking_id') }}" placeholder="e.g. 123"
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">User (Name/Email)</label>
                <input type="text" name="user" value="{{ request('user') }}" placeholder="e.g. John or john@example.com"
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Payment Status</label>
                <select name="payment_status" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
                    <option value="">All</option>
                    <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                    <option value="refunded" {{ request('payment_status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Booking Status</label>
                <select name="status" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
                    <option value="">All</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Sort By</label>
                <select name="sort" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
                    <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>Newest First</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                    <option value="amount_desc" {{ request('sort') == 'amount_desc' ? 'selected' : '' }}>Highest Amount</option>
                    <option value="amount_asc" {{ request('sort') == 'amount_asc' ? 'selected' : '' }}>Lowest Amount</option>
                </select>
            </div>
        </form>

        <div class="flex justify-end mt-4 gap-3">
            <button type="submit" form="filter-form"
                    class="px-6 py-3 bg-primary text-white font-bold rounded-xl hover:bg-orange-600 transition shadow-lg">
                Apply Filters
            </button>
            @if(request()->hasAny(['booking_id', 'user', 'payment_status', 'status', 'sort']))
                <a href="{{ route('admin.bookings.index') }}"
                   class="px-6 py-3 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-100 transition">
                    Clear All
                </a>
            @endif
        </div>
    </div>

    <!-- Active Filters -->
    @if(request()->hasAny(['booking_id', 'user', 'payment_status', 'status', 'sort']))
        <div class="mb-6 flex flex-wrap gap-2">
            @if(request('booking_id')) <span class="inline-flex items-center px-4 py-2 bg-primary/10 text-primary rounded-full text-sm font-medium">ID: {{ request('booking_id') }} <a href="{{ request()->except('booking_id') }}" class="ml-2 text-primary hover:text-orange-700">×</a></span> @endif
            @if(request('user')) <span class="inline-flex items-center px-4 py-2 bg-primary/10 text-primary rounded-full text-sm font-medium">User: {{ request('user') }} <a href="{{ request()->except('user') }}" class="ml-2 text-primary hover:text-orange-700">×</a></span> @endif
            @if(request('payment_status')) <span class="inline-flex items-center px-4 py-2 bg-primary/10 text-primary rounded-full text-sm font-medium">Payment: {{ ucfirst(request('payment_status')) }} <a href="{{ request()->except('payment_status') }}" class="ml-2 text-primary hover:text-orange-700">×</a></span> @endif
            @if(request('status')) <span class="inline-flex items-center px-4 py-2 bg-primary/10 text-primary rounded-full text-sm font-medium">Status: {{ ucfirst(request('status')) }} <a href="{{ request()->except('status') }}" class="ml-2 text-primary hover:text-orange-700">×</a></span> @endif
            @if(request('sort') && request('sort') != 'latest') <span class="inline-flex items-center px-4 py-2 bg-primary/10 text-primary rounded-full text-sm font-medium">Sort: {{ ucwords(str_replace('_', ' ', request('sort'))) }} <a href="{{ request()->except('sort') }}" class="ml-2 text-primary hover:text-orange-700">×</a></span> @endif
        </div>
    @endif

    <!-- Bookings Table -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px] table-auto">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">User</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Event</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Total</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Payment</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Booked On</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($bookings as $booking)
                        <tr class="hover:bg-gray-50 transition text-sm">
                            <td class="px-4 py-4 font-medium text-gray-900">#{{ $booking->id }}</td>
                            <td class="px-4 py-4">
                                <div class="font-medium text-gray-900">{{ $booking->full_name }}</div>
                                <div class="text-xs text-gray-500">{{ $booking->email }}</div>
                            </td>
                            <td class="px-4 py-4 text-gray-900">
                                {{ Str::limit($booking->event->title ?? 'N/A', 35) }}
                            </td>
                            <td class="px-4 py-4 font-semibold text-gray-900">
                                NPR {{ number_format($booking->total_amount, 2) }}
                            </td>
                            <td class="px-4 py-4">
                                @switch($booking->payment_status)
                                    @case('paid')     <span class="px-2.5 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Paid</span> @break
                                    @case('pending')  <span class="px-2.5 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">Pending</span> @break
                                    @case('failed')   <span class="px-2.5 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">Failed</span> @break
                                    @case('refunded') <span class="px-2.5 py-1 text-xs font-medium bg-purple-100 text-purple-800 rounded-full">Refunded</span> @break
                                    @default          <span class="px-2.5 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">Unknown</span>
                                @endswitch
                            </td>
                            <td class="px-4 py-4">
                                @switch($booking->status)
                                    @case('confirmed') <span class="px-2.5 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">Confirmed</span> @break
                                    @case('pending')   <span class="px-2.5 py-1 text-xs font-medium bg-orange-100 text-orange-800 rounded-full">Pending</span> @break
                                    @case('cancelled') <span class="px-2.5 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">Cancelled</span> @break
                                    @default           <span class="px-2.5 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">{{ ucfirst($booking->status) }}</span>
                                @endswitch
                            </td>
                            <td class="px-4 py-4 text-gray-600">
                                <div>{{ $booking->created_at->format('d M Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $booking->created_at->format('h:i A') }}</div>
                            </td>
                            <td class="px-4 py-4">
                                <a href="{{ route('admin.bookings.show', $booking) }}"
                                   class="inline-block px-4 py-2 bg-primary text-white font-bold text-xs rounded-lg hover:bg-orange-600 transition shadow">
                                    Details
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                No bookings found matching your criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination (10 per page) -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            {{ $bookings->appends(request()->query())->links() }}
        </div>
    </div>
</div>

</x-admin.admin-layout>
