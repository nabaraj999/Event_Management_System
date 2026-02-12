<x-organizer.organizer-layout title="Support Tickets">

    <div class="py-6 px-4 max-w-7xl mx-auto">

        <!-- Header -->
        <div class="bg-[#063970] text-white rounded-xl shadow-md p-6 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold">Support Tickets</h1>
                    <p class="text-blue-100 text-sm mt-1 opacity-90">View and manage your help requests</p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <form method="GET" action="{{ route('org.support.index') }}" class="flex gap-2 min-w-[240px]">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search tickets..."
                               class="flex-1 px-4 py-2.5 rounded-lg bg-white/15 border border-white/30 text-white placeholder-blue-200 focus:outline-none focus:border-[#FF7A28] focus:ring-2 focus:ring-[#FF7A28]/30 text-sm">
                        <button type="submit"
                                class="px-5 py-2.5 bg-[#FF7A28] hover:bg-[#FF7A28]/90 text-white rounded-lg font-medium transition text-sm shadow-sm">
                            Search
                        </button>
                    </form>

                    <a href="{{ route('org.support.create') }}"
                       class="px-6 py-2.5 bg-[#FF7A28] hover:bg-[#FF7A28]/90 text-white rounded-lg font-medium shadow-sm transition text-sm whitespace-nowrap">
                        + New Ticket
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
                            <th class="px-5 py-3.5 text-left">Ticket ID & Subject</th>
                            <th class="px-5 py-3.5 text-center">Priority</th>
                            <th class="px-5 py-3.5 text-center">Status</th>
                            <th class="px-5 py-3.5 text-left">Last Activity</th>
                            <th class="px-5 py-3.5 text-center">Messages</th>
                            <th class="px-5 py-3.5 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($tickets as $ticket)
                            <tr class="hover:bg-orange-50/30 transition-colors">
                                <td class="px-5 py-4 text-center text-gray-500 font-medium">
                                    {{ $loop->iteration + ($tickets->currentPage() - 1) * $tickets->perPage() }}
                                </td>

                                <td class="px-5 py-4">
                                    <a href="{{ route('org.support.show', $ticket) }}"
                                       class="font-medium text-gray-900 hover:text-[#FF7A28] transition">
                                        #{{ $ticket->ticket_id }} – {{ Str::limit($ticket->subject, 50) }}
                                    </a>
                                    <div class="text-xs text-gray-500 mt-0.5">
                                        Opened: {{ $ticket->created_at->format('d M Y') }}
                                    </div>
                                </td>

                                <td class="px-5 py-4 text-center">
                                    <span class="px-3 py-1 rounded-full text-xs font-medium
                                           {{ $ticket->priority === 'urgent' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700' }}">
                                        {{ ucfirst($ticket->priority) }}
                                    </span>
                                </td>

                                <td class="px-5 py-4 text-center">
                                    @switch($ticket->status)
                                        @case('open')
                                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">Open</span>
                                            @break
                                        @case('waiting_for_reply')
                                            <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-medium">Waiting</span>
                                            @break
                                        @case('replied')
                                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">Replied</span>
                                            @break
                                        @case('closed')
                                            <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-medium">Closed</span>
                                            @break
                                        @default
                                            <span class="px-3 py-1 bg-gray-200 text-gray-600 rounded-full text-xs font-medium">—</span>
                                    @endswitch
                                </td>

                                <td class="px-5 py-4 text-gray-600 text-sm">
                                    {{ $ticket->last_replied_at?->diffForHumans() ?? $ticket->created_at->diffForHumans() }}
                                </td>

                                <td class="px-5 py-4 text-center text-gray-700">
                                    <span class="font-medium">{{ $ticket->replies->count() }}</span>
                                    <div class="text-xs text-gray-500">
                                        {{ Str::plural('message', $ticket->replies->count()) }}
                                    </div>
                                </td>

                                <td class="px-5 py-4 text-center">
                                    <a href="{{ route('org.support.show', $ticket) }}"
                                       class="px-3.5 py-1.5 bg-[#063970] hover:bg-[#063970]/90 text-white text-xs font-medium rounded-md transition shadow-sm inline-block">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-14 text-gray-500">
                                    <p class="text-base font-medium">No support tickets yet</p>
                                    <p class="text-sm mt-1.5">When you need help, we'll be here</p>
                                    <a href="{{ route('org.support.create') }}"
                                       class="text-[#FF7A28] hover:underline mt-2 inline-block text-sm font-medium">
                                        → Create your first ticket
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Mobile Cards -->
                <div class="lg:hidden divide-y divide-gray-200">
                    @forelse($tickets as $ticket)
                        <div class="p-4 hover:bg-orange-50/30 transition">
                            <div class="flex items-start justify-between mb-2">
                                <div>
                                    <a href="{{ route('org.support.show', $ticket) }}"
                                       class="font-medium text-gray-900 hover:text-[#FF7A28] transition">
                                        #{{ $ticket->ticket_id }}
                                    </a>
                                    <div class="text-xs text-gray-600 mt-0.5">
                                        {{ Str::limit($ticket->subject, 50) }}
                                    </div>
                                </div>

                                <span class="px-3 py-1 rounded-full text-xs font-medium
                                       {{ $ticket->priority === 'urgent' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ ucfirst($ticket->priority) }}
                                </span>
                            </div>

                            <div class="text-xs space-y-1.5 mb-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Status:</span>
                                    <div>
                                        @switch($ticket->status)
                                            @case('open')
                                                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">Open</span>
                                                @break
                                            @case('waiting_for_reply')
                                                <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-medium">Waiting</span>
                                                @break
                                            @case('replied')
                                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">Replied</span>
                                                @break
                                            @case('closed')
                                                <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-medium">Closed</span>
                                                @break
                                            @default
                                                <span class="px-3 py-1 bg-gray-200 text-gray-600 rounded-full text-xs font-medium">—</span>
                                        @endswitch
                                    </div>
                                </div>

                                <div class="flex justify-between">
                                    <span class="text-gray-500">Last Activity:</span>
                                    <span class="text-gray-600">
                                        {{ $ticket->last_replied_at?->diffForHumans() ?? $ticket->created_at->diffForHumans() }}
                                    </span>
                                </div>

                                <div class="flex justify-between">
                                    <span class="text-gray-500">Messages:</span>
                                    <span class="font-medium text-gray-900">{{ $ticket->replies->count() }}</span>
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <a href="{{ route('org.support.show', $ticket) }}"
                                   class="px-4 py-2 bg-[#063970] hover:bg-[#063970]/90 text-white rounded text-sm font-medium transition">
                                    View →
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-500">
                            <p class="text-base font-medium">No support tickets yet</p>
                            <p class="text-sm mt-1.5">When you need help, we'll be here</p>
                            <a href="{{ route('org.support.create') }}"
                               class="text-[#FF7A28] hover:underline mt-2 inline-block text-sm font-medium">
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

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            @if (session('swal_success') || session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('swal_success') ?? session('success') }}',
                    confirmButtonColor: '#FF7A28',
                    timer: 3200,
                    timerProgressBar: true
                });
            @endif
        </script>
    @endpush

</x-organizer.organizer-layout>
