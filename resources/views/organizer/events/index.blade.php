<x-organizer.organizer-layout>

    <div class="py-6 px-4 max-w-7xl mx-auto">

        <!-- Header -->
        <div class="bg-[#063970] text-white rounded-xl shadow-md p-6 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold">All Events</h1>
                    <p class="text-blue-100 text-sm mt-1 opacity-90">Manage your events</p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <form method="GET" action="{{ route('org.events.index') }}" class="flex gap-2 min-w-[240px]">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search events..."
                               class="flex-1 px-4 py-2.5 rounded-lg bg-white/15 border border-white/30 text-white placeholder-blue-200 focus:outline-none focus:border-[#FF7A28] focus:ring-2 focus:ring-[#FF7A28]/30 text-sm">
                        <button type="submit"
                                class="px-5 py-2.5 bg-[#FF7A28] hover:bg-[#FF7A28]/90 text-white rounded-lg font-medium transition text-sm shadow-sm">
                            Search
                        </button>
                    </form>

                    <a href="{{ route('org.events.create') }}"
                       class="px-6 py-2.5 bg-[#FF7A28] hover:bg-[#FF7A28]/90 text-white rounded-lg font-medium shadow-sm transition text-sm whitespace-nowrap">
                        + New Event
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-xl shadow border border-gray-200 overflow-hidden">

            <div class="overflow-x-auto">

                <!-- Desktop Table -->
                <table class="w-full min-w-[900px] hidden lg:table">
                    <thead class="bg-gray-50">
                        <tr class="text-xs font-semibold text-gray-600 uppercase tracking-wide">
                            <th class="px-5 py-3.5 text-left w-16">#</th>
                            <th class="px-5 py-3.5 text-left">Title</th>
                            <th class="px-5 py-3.5 text-left">Category</th>
                            <th class="px-5 py-3.5 text-left">Date</th>
                            <th class="px-5 py-3.5 text-center">Status</th>
                            <th class="px-5 py-3.5 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($events as $event)
                            <tr class="hover:bg-orange-50/30 transition-colors">
                                <td class="px-5 py-4 text-center text-gray-500 font-medium">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-5 py-4">
                                    <div class="font-medium text-gray-900">
                                        {{ Str::limit($event->title, 50) }}
                                    </div>
                                    <div class="text-xs text-gray-500 mt-0.5">
                                        {{ $event->location ?? '—' }}
                                    </div>
                                </td>

                                <td class="px-5 py-4">
                                    <span class="px-3 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded-md">
                                        {{ $event->category?->name ?? '—' }}
                                    </span>
                                </td>

                                <td class="px-5 py-4 text-gray-700 text-sm">
                                    {{ $event->start_date->format('d M Y') }}
                                    @if($event->end_date)
                                        <span class="text-gray-400"> → </span>
                                        {{ $event->end_date->format('d M Y') }}
                                    @endif
                                </td>

                                <td class="px-5 py-4 text-center">
                                    @php
                                        $status = $event->effective_status;
                                        $badgeClass = match($status) {
                                            'upcoming'  => 'bg-green-100 text-green-700',
                                            'ongoing'   => 'bg-blue-100 text-blue-700 font-semibold',
                                            'completed' => 'bg-gray-100 text-gray-600',
                                            'draft'     => 'bg-amber-100 text-amber-700',
                                            'cancelled' => 'bg-red-100 text-red-700',
                                            default     => 'bg-gray-200 text-gray-600',
                                        };
                                    @endphp

                                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $badgeClass }}">
                                        {{ ucfirst($status) }}
                                    </span>
                                </td>

                                <td class="px-5 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('org.events.edit', $event) }}"
                                           class="px-3.5 py-1.5 bg-[#063970] hover:bg-[#063970]/90 text-white text-xs font-medium rounded-md transition shadow-sm">
                                            Edit
                                        </a>

                                        <form action="{{ route('org.events.destroy', $event) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('Delete «{{ addslashes(Str::limit($event->title, 40)) }}» ?')"
                                                    class="px-3.5 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded-md transition shadow-sm">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-14 text-gray-500">
                                    <p class="text-base font-medium">No events found</p>
                                    <a href="{{ route('org.events.create') }}"
                                       class="text-[#FF7A28] hover:underline mt-2 inline-block text-sm font-medium">
                                        → Create your first event
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Mobile Cards -->
                <div class="lg:hidden divide-y divide-gray-200">
                    @forelse($events as $event)
                        <div class="p-4 hover:bg-orange-50/30 transition">
                            <div class="flex items-start justify-between mb-2">
                                <div>
                                    <div class="font-medium text-gray-900">
                                        {{ Str::limit($event->title, 45) }}
                                    </div>
                                    <div class="text-xs text-gray-500 mt-0.5">
                                        {{ $event->location ?? '—' }}
                                    </div>
                                </div>

                                @php
                                    $status = $event->effective_status;
                                    $badgeClass = match($status) {
                                        'upcoming'  => 'bg-green-100 text-green-700',
                                        'ongoing'   => 'bg-blue-100 text-blue-700',
                                        'completed' => 'bg-gray-100 text-gray-600',
                                        'draft'     => 'bg-amber-100 text-amber-700',
                                        'cancelled' => 'bg-red-100 text-red-700',
                                        default     => 'bg-gray-200 text-gray-600',
                                    };
                                @endphp

                                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $badgeClass }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </div>

                            <div class="text-xs space-y-1.5 mb-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Category:</span>
                                    <span class="text-gray-900">{{ $event->category?->name ?? '—' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Date:</span>
                                    <span class="text-gray-600">
                                        {{ $event->start_date->format('d M Y') }}
                                        @if($event->end_date) → {{ $event->end_date->format('d M Y') }} @endif
                                    </span>
                                </div>
                            </div>

                            <div class="flex gap-2">
                                <a href="{{ route('org.events.edit', $event) }}"
                                   class="flex-1 text-center py-2.5 bg-[#063970] hover:bg-[#063970]/90 text-white rounded text-sm font-medium transition">
                                    Edit
                                </a>

                                <form action="{{ route('org.events.destroy', $event) }}" method="POST" class="flex-1">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Delete «{{ addslashes(Str::limit($event->title, 40)) }}» ?')"
                                            class="w-full py-2.5 bg-red-600 hover:bg-red-700 text-white rounded text-sm font-medium transition">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-500">
                            <p class="text-base font-medium">No events found</p>
                            <a href="{{ route('org.events.create') }}"
                               class="text-[#FF7A28] hover:underline mt-2 inline-block text-sm font-medium">
                                → Create your first event
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            <div class="px-5 py-4 bg-gray-50 border-t text-center sm:text-right text-sm text-gray-600">
                {{ $events->appends(request()->query())->links('pagination::tailwind') }}
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            @if (session('swal_success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('swal_success') }}',
                    confirmButtonColor: '#FF7A28',
                    timer: 3200,
                    timerProgressBar: true
                });
            @endif
        </script>
    @endpush

</x-organizer.organizer-layout>
