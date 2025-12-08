{{-- resources/views/event_tickets/index.blade.php --}}
<x-admin.admin-layout title="Event Tickets">

    <!-- Font Awesome (already in layout, but safe to keep) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
          integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8">
        <div class="bg-white shadow-2xl rounded-2xl overflow-hidden">

            <!-- Header + Search -->
            <div class="bg-[#063970] text-white px-6 py-5 lg:px-8 lg:py-6">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <h1 class="text-2xl lg:text-3xl font-bold">Event Tickets</h1>
                        <p class="opacity-90 text-sm lg:text-base mt-1">Manage all ticket types for events</p>
                    </div>

                    <!-- Search + Add Button -->
                    <form method="GET" class="flex flex-col sm:flex-row gap-3">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search by ticket name, event, ID..."
                               class="w-full sm:w-64 px-4 py-3 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-white">
                        <div class="flex gap-3">
                            <button type="submit"
                                    class="w-full sm:w-auto px-6 py-3 bg-white text-[#FF7A28] font-bold rounded-lg hover:bg-gray-100 transition shadow">
                                Search
                            </button>
                            <a href="{{ route('admin.event-tickets.create') }}"
                               class="w-full sm:w-auto text-center px-6 py-3 bg-white text-[#FF7A28] font-bold rounded-lg hover:bg-gray-100 transition shadow">
                                + Add New
                            </a>
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
                            <th class="px-6 py-4">Ticket ID</th>
                            <th class="px-6 py-4">Event Name</th>
                            <th class="px-6 py-4">Ticket Type</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tickets as $index => $ticket)
                            <tr class="bg-white border-b hover:bg-orange-50 transition">
                                <td class="px-6 py-5 font-mono font-bold text-[#063970]">
                                    #{{ $ticket->id }}
                                </td>
                                <td class="px-6 py-5">
                                    <div class="font-semibold text-[#063970]">
                                       {{ $ticket->event?->title ?? '—' }}
                                    </div>
                                    <div class="text-xs text-gray-500">ID: {{ $ticket->event_id }}</div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="font-bold text-lg text-[#063970]">{{ $ticket->name }}</div>
                                    @if($ticket->description)
                                        <p class="text-xs text-gray-600 mt-1">{{ Str::limit($ticket->description, 70) }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <span class="px-4 py-2 rounded-full text-xs font-medium {{ $ticket->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $ticket->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('admin.event-tickets.edit', $ticket) }}"
                                           class="px-4 py-2 bg-[#063970] text-white rounded-lg hover:bg-[#052e5c] transition text-xs font-medium">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.event-tickets.destroy', $ticket) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('Delete ticket #{{ $ticket->id }}?')"
                                                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-xs font-medium">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-20 text-center text-gray-500 text-lg">
                                    @if(request('search'))
                                        No tickets found for "<strong>{{ request('search') }}</strong>"
                                    @else
                                        No tickets created yet
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Mobile Cards -->
                <div class="lg:hidden">
                    @forelse($tickets as $ticket)
                        <div class="m-4 p-5 bg-white border border-gray-200 rounded-xl shadow hover:shadow-lg transition">
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <div class="font-mono text-sm text-gray-500">Ticket ID</div>
                                    <div class="font-bold text-xl text-[#063970]">#{{ $ticket->id }}</div>
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $ticket->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $ticket->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>

                            <div class="mb-4">
                                <div class="text-sm text-gray-600">Event</div>
                                <div class="font-bold text-[#063970]">
                                    {{ $ticket->event->name ?? '—' }}
                                </div>
                                <div class="text-xs text-gray-500">ID: {{ $ticket->event_id }}</div>
                            </div>

                            <div class="mb-5">
                                <div class="text-sm text-gray-600">Ticket Type</div>
                                <div class="font-bold text-lg text-[#063970]">{{ $ticket->name }}</div>
                                @if($ticket->description)
                                    <p class="text-xs text-gray-600 mt-1">{{ Str::limit($ticket->description, 90) }}</p>
                                @endif
                            </div>

                            <div class="flex gap-3">
                                <a href="{{ route('admin.event-tickets.edit', $ticket) }}"
                                   class="flex-1 text-center py-3 bg-[#063970] text-white rounded-lg hover:bg-[#052e5c] transition font-medium">
                                    Edit
                                </a>
                                <form action="{{ route('admin.event-tickets.destroy', $ticket) }}" method="POST" class="flex-1">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Delete ticket #{{ $ticket->id }}?')"
                                            class="w-full py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="m-6 p-10 text-center text-gray-500 bg-gray-50 rounded-xl">
                            <p class="text-xl mb-4">
                                @if(request('search'))
                                    No tickets found
                                @else
                                    No tickets yet
                                @endif
                            </p>
                            <a href="{{ route('admin.event-tickets.create') }}" class="text-[#FF7A28] font-bold underline">
                                Create your first ticket
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            <div class="bg-gray-50 px-6 py-4 flex flex-col sm:flex-row items-center justify-between border-t text-sm">
                <div class="text-gray-600 mb-3 sm:mb-0">
                    Showing {{ $tickets->firstItem() }} to {{ $tickets->lastItem() }} of {{ $tickets->total() }} tickets
                </div>
                <div>
                    {{ $tickets->appends(request()->query())->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    </div>
</x-admin.admin-layout>
