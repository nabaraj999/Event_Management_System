<x-admin.admin-layout title="Manage Bookings">

    <div class="py-6 px-4 max-w-7xl mx-auto">

        <!-- Header -->
        <div class="bg-[#063970] text-white rounded-xl shadow-md p-6 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold">Manage Bookings</h1>
                    <p class="text-blue-100 text-sm mt-1 opacity-90">All event ticket bookings</p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <form method="GET" action="{{ route('admin.bookings.index') }}" class="flex gap-2 min-w-[300px]">
                        <input type="text" name="query" value="{{ request('query') }}"
                               placeholder="Search ID, name, email, phone, token..."
                               class="flex-1 px-4 py-2.5 rounded-lg bg-white/15 border border-white/30 text-white placeholder-blue-200 focus:outline-none focus:border-[#FF7A28] focus:ring-2 focus:ring-[#FF7A28]/30 text-sm">
                        <button type="submit"
                                class="px-5 py-2.5 bg-[#FF7A28] hover:bg-[#FF7A28]/90 text-white rounded-lg font-medium transition text-sm shadow-sm">
                            Search
                        </button>

                        @if(request('query'))
                            <a href="{{ route('admin.bookings.index') }}"
                               class="px-5 py-2.5 bg-white/20 hover:bg-white/30 text-white rounded-lg font-medium transition text-sm shadow-sm">
                                Clear
                            </a>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-xl shadow border border-gray-200 overflow-hidden">

            @if(session('success'))
                <div class="mx-5 mt-5 p-4 bg-orange-50 border-l-4 border-[#FF7A28] text-orange-800 rounded-r text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto">

                <!-- Desktop Table (Amount column removed) -->
                <table class="w-full min-w-[900px] hidden lg:table">
                    <thead class="bg-gray-50">
                        <tr class="text-xs font-semibold text-gray-600 uppercase tracking-wide">
                            <th class="px-4 py-3 text-left w-16">ID</th>
                            <th class="px-4 py-3 text-left">Attendee</th>
                            <th class="px-4 py-3 text-left">Event</th>
                            <th class="px-4 py-3 text-center">Payment</th>
                            <th class="px-4 py-3 text-center">Status</th>
                            <th class="px-4 py-3 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($bookings as $booking)
                            <tr class="hover:bg-orange-50/30 transition-colors">
                                <td class="px-4 py-3 font-mono text-[#063970] font-medium">
                                    #{{ $booking->id }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-900 leading-tight">{{ $booking->full_name }}</div>
                                    <div class="text-xs text-gray-500">{{ $booking->email }}</div>
                                </td>
                                <td class="px-4 py-3 text-gray-900">
                                    {{ Str::limit($booking->event?->title ?? '—', 40) }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @include('admin.bookings.partials.payment-badge', ['status' => $booking->payment_status])
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @include('admin.bookings.partials.booking-status-badge', ['status' => $booking->status])
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('admin.bookings.show', $booking) }}"
                                       class="px-3 py-1.5 bg-[#063970] hover:bg-[#063970]/90 text-white text-xs font-medium rounded transition shadow-sm inline-block">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-14 text-gray-500">
                                    <p class="text-base font-medium">
                                        @if(request('query'))
                                            No bookings found for "{{ request('query') }}"
                                        @else
                                            No bookings yet
                                        @endif
                                    </p>
                                    <a href="{{ route('admin.bookings.index') }}"
                                       class="text-[#FF7A28] hover:underline mt-1.5 inline-block text-sm">
                                        → Refresh list
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Mobile Cards (Amount removed) -->
                <div class="lg:hidden divide-y divide-gray-200">
                    @forelse($bookings as $booking)
                        <div class="p-4 hover:bg-orange-50/30 transition">
                            <div class="flex items-start justify-between mb-2">
                                <div>
                                    <div class="font-mono text-base font-bold text-[#063970]">
                                        #{{ $booking->id }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $booking->created_at->format('d M Y') }}
                                    </div>
                                </div>
                                <div class="flex flex-wrap gap-1.5 justify-end">
                                    @include('admin.bookings.partials.payment-badge', ['status' => $booking->payment_status])
                                    @include('admin.bookings.partials.booking-status-badge', ['status' => $booking->status])
                                </div>
                            </div>

                            <div class="text-sm space-y-2 mb-3">
                                <div>
                                    <span class="text-xs text-gray-500">Attendee:</span>
                                    <span class="font-medium text-gray-900">{{ $booking->full_name }}</span>
                                    <span class="text-xs text-gray-600 block">{{ $booking->email }}</span>
                                </div>

                                <div>
                                    <span class="text-xs text-gray-500">Event:</span>
                                    <span class="font-medium text-gray-900">
                                        {{ Str::limit($booking->event?->title ?? '—', 35) }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <a href="{{ route('admin.bookings.show', $booking) }}"
                                   class="px-4 py-2 bg-[#063970] hover:bg-[#063970]/90 text-white rounded text-sm font-medium transition">
                                    View Details →
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-500">
                            <p class="text-base font-medium">
                                @if(request('query'))
                                    No matching bookings
                                @else
                                    No bookings yet
                                @endif
                            </p>
                            <a href="{{ route('admin.bookings.index') }}"
                               class="text-[#FF7A28] hover:underline mt-2 inline-block text-sm">
                                → Refresh list
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            <div class="px-5 py-4 bg-gray-50 border-t text-center sm:text-right text-sm text-gray-600">
                {{ $bookings->appends(request()->query())->links('pagination::tailwind') }}
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            @if (session('swal_success') || session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Done!',
                    text: '{{ session('swal_success') ?? session('success') }}',
                    confirmButtonColor: '#FF7A28',
                    timer: 3200,
                    timerProgressBar: true
                });
            @endif
        </script>
    @endpush

</x-admin.admin-layout>
