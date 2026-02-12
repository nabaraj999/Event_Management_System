<x-admin.admin-layout>

    <div class="py-6 px-4 max-w-7xl mx-auto">

        <!-- Header -->
        <div class="bg-[#063970] text-white rounded-xl shadow-md p-6 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold">Events</h1>
                    <p class="text-blue-100 text-sm mt-1 opacity-90">Manage all your events</p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <!-- Search -->
                    <form method="GET" action="{{ route('admin.events.index') }}" class="flex gap-2 min-w-[240px]">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search title or location..."
                               class="flex-1 px-4 py-2.5 rounded-lg bg-white/15 border border-white/30 text-white placeholder-blue-200 focus:outline-none focus:border-[#FF7A28] focus:ring-2 focus:ring-[#FF7A28]/30 text-sm">
                        <button type="submit"
                                class="px-5 py-2.5 bg-[#FF7A28] hover:bg-[#FF7A28]/90 text-white rounded-lg font-medium transition text-sm shadow-sm">
                            Search
                        </button>
                    </form>

                    <!-- Organizer Filter -->
                    <form method="GET" action="{{ route('admin.events.index') }}" class="flex gap-2">
                        <input type="hidden" name="search" value="{{ request('search') }}">

                        <select name="organizer_id"
                                onchange="this.form.submit()"
                                class="px-4 py-2.5 rounded-lg bg-white/15 border border-white/30 text-white focus:outline-none focus:border-[#FF7A28] focus:ring-2 focus:ring-[#FF7A28]/30 text-sm min-w-[200px]">
                            <option value="">All / Admin events</option>
                            @foreach($approved_organizers ?? [] as $org)
                                <option value="{{ $org->id }}"
                                    {{ request('organizer_id') == $org->id ? 'selected' : '' }}>
                                    {{ Str::limit($org->organization_name, 28) }}
                                    @if($org->contact_person) • {{ $org->contact_person }} @endif
                                </option>
                            @endforeach
                        </select>
                    </form>

                    <!-- Create Button -->
                    <a href="{{ route('admin.events.create') }}"
                       class="px-6 py-2.5 bg-[#FF7A28] hover:bg-[#FF7A28]/90 text-white rounded-lg font-medium shadow-sm transition text-sm whitespace-nowrap">
                        + New Event
                    </a>
                </div>
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-xl shadow border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[900px]">
                    <thead class="bg-gray-50">
                        <tr class="text-xs font-semibold text-gray-600 uppercase tracking-wide">
                            <th class="px-5 py-3.5 text-left w-12">#</th>
                            <th class="px-5 py-3.5 text-left">Event</th>
                            <th class="px-5 py-3.5 text-left">Organizer</th>
                            <th class="px-5 py-3.5 text-left">Category</th>
                            <th class="px-5 py-3.5 text-left">Date</th>
                            <th class="px-5 py-3.5 text-center">Status</th>
                            <th class="px-5 py-3.5 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($events as $event)
                            <tr class="hover:bg-orange-50/30 transition-colors">
                                <td class="px-5 py-4 text-center text-gray-500 font-medium">{{ $loop->iteration }}</td>

                                <td class="px-5 py-4">
                                    <div class="font-medium text-gray-900">{{ Str::limit($event->title, 45) }}</div>
                                    <div class="text-xs text-gray-500 mt-0.5">{{ $event->location ?: '—' }}</div>
                                </td>

                                <td class="px-5 py-4">
                                    @if($event->organizer)
                                        <div class="font-medium text-gray-800">{{ Str::limit($event->organizer->organization_name, 28) }}</div>
                                        <div class="text-xs text-gray-500">{{ $event->organizer->email }}</div>
                                    @else
                                        <span class="text-gray-500 italic text-xs">Admin</span>
                                    @endif
                                </td>

                                <td class="px-5 py-4">
                                    <span class="inline-block px-2.5 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded-md">
                                        {{ $event->category?->name ?? '—' }}
                                    </span>
                                </td>

                                <td class="px-5 py-4 text-gray-700 text-xs">
                                    {{ $event->start_date->format('d M Y') }}
                                    @if($event->end_date)
                                        <span class="text-gray-400"> → </span>{{ $event->end_date->format('d M Y') }}
                                    @endif
                                </td>

                                <td class="px-5 py-4 text-center">
                                    @php
                                        $now = now();
                                        $displayStatus = $event->status;

                                        if ($event->status === 'published') {
                                            if ($now < $event->start_date) $displayStatus = 'upcoming';
                                            elseif ($event->end_date && $now->gt($event->end_date)) $displayStatus = 'completed';
                                            else $displayStatus = 'ongoing';
                                        }
                                    @endphp

                                    @switch($displayStatus)
                                        @case('upcoming')
                                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">Upcoming</span>
                                            @break
                                        @case('ongoing')
                                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">Ongoing</span>
                                            @break
                                        @case('completed')
                                            <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-medium">Completed</span>
                                            @break
                                        @case('draft')
                                            <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-medium">Draft</span>
                                            @break
                                        @case('cancelled')
                                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-medium">Cancelled</span>
                                            @break
                                        @default
                                            <span class="px-3 py-1 bg-gray-200 text-gray-600 rounded-full text-xs font-medium">—</span>
                                    @endswitch
                                </td>

                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.events.edit', $event) }}"
                                           class="px-3.5 py-1.5 bg-[#063970] hover:bg-[#063970]/90 text-white text-xs font-medium rounded-md transition shadow-sm">
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="inline">
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
                                <td colspan="7" class="text-center py-16 text-gray-500">
                                    <p class="text-lg font-medium">No events found</p>
                                    <a href="{{ route('admin.events.create') }}"
                                       class="text-[#FF7A28] hover:underline mt-2 inline-block text-sm font-medium">
                                        → Create your first event
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-5 py-4 bg-gray-50 border-t text-center">
                {{ $events->appends(request()->query())->links('pagination::tailwind') }}
            </div>
        </div>

        <!-- Scripts -->
        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                @if (session('swal_success'))
                    Swal.fire({
                        icon: 'success',
                        title: 'Done!',
                        text: '{{ session('swal_success') }}',
                        confirmButtonColor: '#FF7A28',
                        timer: 3200,
                        timerProgressBar: true
                    });
                @endif
            </script>
        @endpush

    </x-admin.admin-layout>
