<x-admin.admin-layout title="Event Tickets">

    <div class="py-6 px-4 max-w-7xl mx-auto">

        <!-- Header – same style as events index -->
        <div class="bg-[#063970] text-white rounded-xl shadow-md p-6 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold">Event Tickets</h1>
                    <p class="text-blue-100 text-sm mt-1 opacity-90">Manage all ticket types</p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <!-- Search -->
                    <form method="GET" action="{{ route('admin.event-tickets.index') }}" class="flex gap-2 min-w-[240px]">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search ticket name, event..."
                               class="flex-1 px-4 py-2.5 rounded-lg bg-white/15 border border-white/30 text-white placeholder-blue-200 focus:outline-none focus:border-[#FF7A28] focus:ring-2 focus:ring-[#FF7A28]/30 text-sm">
                        <button type="submit"
                                class="px-5 py-2.5 bg-[#FF7A28] hover:bg-[#FF7A28]/90 text-white rounded-lg font-medium transition text-sm shadow-sm">
                            Search
                        </button>
                    </form>

                    <!-- Create Button -->
                    <a href="{{ route('admin.event-tickets.create') }}"
                       class="px-6 py-2.5 bg-[#FF7A28] hover:bg-[#FF7A28]/90 text-white rounded-lg font-medium shadow-sm transition text-sm whitespace-nowrap">
                        + New Ticket
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-xl shadow border border-gray-200 overflow-hidden">

            <!-- Success message -->
            @if(session('success'))
                <div class="mx-5 mt-5 p-4 bg-orange-50 border-l-4 border-[#FF7A28] text-orange-800 rounded-r text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto">

                <!-- Desktop Table -->
                <table class="w-full min-w-[900px] hidden lg:table">
                    <thead class="bg-gray-50">
                        <tr class="text-xs font-semibold text-gray-600 uppercase tracking-wide">
                            <th class="px-5 py-3.5 text-left w-16">ID</th>
                            <th class="px-5 py-3.5 text-left">Event</th>
                            <th class="px-5 py-3.5 text-left">Ticket Type</th>
                            <th class="px-5 py-3.5 text-center">Status</th>
                            <th class="px-5 py-3.5 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($tickets as $ticket)
                            <tr class="hover:bg-orange-50/30 transition-colors">
                                <td class="px-5 py-4 font-mono text-[#063970] font-medium">
                                    #{{ $ticket->id }}
                                </td>

                                <td class="px-5 py-4">
                                    <div class="font-medium text-gray-900">
                                        {{ Str::limit($ticket->event?->title ?? '—', 45) }}
                                    </div>
                                    <div class="text-xs text-gray-500 mt-0.5">
                                        ID: {{ $ticket->event_id }}
                                    </div>
                                </td>

                                <td class="px-5 py-4">
                                    <div class="font-medium text-gray-900">{{ $ticket->name }}</div>
                                    @if($ticket->description)
                                        <div class="text-xs text-gray-500 mt-0.5">
                                            {{ Str::limit($ticket->description, 70) }}
                                        </div>
                                    @endif
                                </td>

                                <td class="px-5 py-4 text-center">
                                    <span class="px-3 py-1 rounded-full text-xs font-medium
                                           {{ $ticket->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $ticket->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>

                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.event-tickets.edit', $ticket) }}"
                                           class="px-3.5 py-1.5 bg-[#063970] hover:bg-[#063970]/90 text-white text-xs font-medium rounded-md transition shadow-sm">
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.event-tickets.destroy', $ticket) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('Delete ticket #{{ $ticket->id }} ?')"
                                                    class="px-3.5 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded-md transition shadow-sm">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-16 text-gray-500">
                                    <p class="text-lg font-medium">
                                        @if(request('search'))
                                            No tickets found for "{{ request('search') }}"
                                        @else
                                            No tickets created yet
                                        @endif
                                    </p>
                                    <a href="{{ route('admin.event-tickets.create') }}"
                                       class="text-[#FF7A28] hover:underline mt-2 inline-block text-sm font-medium">
                                        → Create your first ticket
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Mobile Cards – matching compact style -->
                <div class="lg:hidden divide-y divide-gray-200">
                    @forelse($tickets as $ticket)
                        <div class="p-5 hover:bg-orange-50/30 transition">
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <div class="text-xs text-gray-500">Ticket ID</div>
                                    <div class="font-bold text-lg text-[#063970]">#{{ $ticket->id }}</div>
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-medium
                                       {{ $ticket->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $ticket->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>

                            <div class="mb-3">
                                <div class="text-xs text-gray-500">Event</div>
                                <div class="font-medium text-gray-900">
                                    {{ Str::limit($ticket->event?->title ?? '—', 40) }}
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="text-xs text-gray-500">Ticket Type</div>
                                <div class="font-medium text-gray-900">{{ $ticket->name }}</div>
                                @if($ticket->description)
                                    <div class="text-xs text-gray-500 mt-1">
                                        {{ Str::limit($ticket->description, 70) }}
                                    </div>
                                @endif
                            </div>

                            <div class="flex gap-2">
                                <a href="{{ route('admin.event-tickets.edit', $ticket) }}"
                                   class="flex-1 text-center py-2.5 bg-[#063970] hover:bg-[#063970]/90 text-white rounded-md text-sm font-medium transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.event-tickets.destroy', $ticket) }}" method="POST" class="flex-1">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Delete ticket #{{ $ticket->id }} ?')"
                                            class="w-full py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-md text-sm font-medium transition">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-10 text-center text-gray-500">
                            <p class="text-lg font-medium">
                                @if(request('search'))
                                    No matching tickets
                                @else
                                    No tickets yet
                                @endif
                            </p>
                            <a href="{{ route('admin.event-tickets.create') }}"
                               class="text-[#FF7A28] hover:underline mt-3 inline-block text-sm font-medium">
                                → Create your first ticket
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            <div class="px-5 py-4 bg-gray-50 border-t text-center sm:text-right text-sm text-gray-600">
                {{ $tickets->appends(request()->query())->links('pagination::tailwind') }}
            </div>
        </div>
    </div>

    <!-- SweetAlert consistency -->
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
