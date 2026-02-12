<x-admin.admin-layout title="Support Tickets">

    <div class="py-6 px-4 max-w-7xl mx-auto">

        <!-- Header -->
        <div class="bg-[#063970] text-white rounded-xl shadow-md p-6 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold">Support Tickets</h1>
                    <p class="text-blue-100 text-sm mt-1 opacity-90">Manage all organizer help requests</p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <form method="GET" action="{{ route('admin.support.index') }}" class="flex gap-2 min-w-[240px]">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search ticket ID, subject..."
                               class="flex-1 px-4 py-2.5 rounded-lg bg-white/15 border border-white/30 text-white placeholder-blue-200 focus:outline-none focus:border-[#FF7A28] focus:ring-2 focus:ring-[#FF7A28]/30 text-sm">
                        <button type="submit"
                                class="px-5 py-2.5 bg-[#FF7A28] hover:bg-[#FF7A28]/90 text-white rounded-lg font-medium transition text-sm shadow-sm">
                            Search
                        </button>
                    </form>
                </div>
            </div>

            <!-- Filters -->
            <div class="mt-5 flex flex-wrap gap-2">
                <a href="{{ route('admin.support.index') }}"
                   class="{{ !request('status') && !request('priority') ? 'bg-white text-[#063970] shadow-sm' : 'bg-white/20' }} px-4 py-2 rounded-lg font-medium text-sm transition">
                    All
                </a>
                <a href="{{ route('admin.support.index', ['status' => 'open']) }}"
                   class="{{ request('status') == 'open' ? 'bg-white text-[#063970] shadow-sm' : 'bg-white/20' }} px-4 py-2 rounded-lg font-medium text-sm transition">
                    Open
                </a>
                <a href="{{ route('admin.support.index', ['status' => 'replied']) }}"
                   class="{{ request('status') == 'replied' ? 'bg-white text-[#063970] shadow-sm' : 'bg-white/20' }} px-4 py-2 rounded-lg font-medium text-sm transition">
                    Replied
                </a>
                <a href="{{ route('admin.support.index', ['priority' => 'urgent']) }}"
                   class="{{ request('priority') == 'urgent' ? 'bg-red-600 text-white shadow-sm' : 'bg-red-600/30 text-white' }} px-4 py-2 rounded-lg font-medium text-sm transition">
                    Urgent Only
                </a>
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

                <!-- Desktop Table -->
                <table class="w-full min-w-[900px] hidden lg:table">
                    <thead class="bg-gray-50">
                        <tr class="text-xs font-semibold text-gray-600 uppercase tracking-wide">
                            <th class="px-5 py-3.5 text-left">Ticket</th>
                            <th class="px-5 py-3.5 text-left">Organizer</th>
                            <th class="px-5 py-3.5 text-center">Priority</th>
                            <th class="px-5 py-3.5 text-center">Status</th>
                            <th class="px-5 py-3.5 text-left">Last Activity</th>
                            <th class="px-5 py-3.5 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($tickets as $ticket)
                            <tr class="hover:bg-orange-50/30 transition-colors">
                                <td class="px-5 py-4">
                                    <a href="{{ route('admin.support.show', $ticket) }}"
                                       class="font-medium text-gray-900 hover:text-[#FF7A28]">
                                        #{{ $ticket->ticket_id }}
                                    </a>
                                    <div class="text-xs text-gray-600 mt-1">
                                        {{ Str::limit($ticket->subject, 60) }}
                                    </div>
                                </td>
                                <td class="px-5 py-4 text-gray-700">
                                    {{ $ticket->organizer->name ?? '—' }}
                                    <div class="text-xs text-gray-500">
                                        {{ $ticket->organizer->email ?? '—' }}
                                    </div>
                                </td>
                                <td class="px-5 py-4 text-center">
                                    <span class="px-3 py-1 rounded-full text-xs font-medium
                                           {{ $ticket->priority === 'urgent' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700' }}">
                                        {{ ucfirst($ticket->priority) }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-center">
                                    @include('admin.support.partials.status-badge', ['status' => $ticket->status])
                                </td>
                                <td class="px-5 py-4 text-gray-600 text-sm">
                                    {{ $ticket->last_replied_at?->diffForHumans() ?? $ticket->created_at->diffForHumans() }}
                                </td>
                                <td class="px-5 py-4 text-center">
                                    <a href="{{ route('admin.support.show', $ticket) }}"
                                       class="px-3.5 py-1.5 bg-[#063970] hover:bg-[#063970]/90 text-white text-xs font-medium rounded-md transition shadow-sm inline-block">
                                        Manage
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-14 text-gray-500">
                                    <p class="text-base font-medium">No support tickets found</p>
                                    <p class="text-sm mt-1.5">New requests will appear here</p>
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
                                    <a href="{{ route('admin.support.show', $ticket) }}"
                                       class="font-medium text-gray-900 hover:text-[#FF7A28]">
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
                                    <span class="text-gray-500">Organizer:</span>
                                    <span class="text-gray-900">{{ $ticket->organizer->name ?? '—' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Status:</span>
                                    <div>
                                        @include('admin.support.partials.status-badge', ['status' => $ticket->status])
                                    </div>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Last Activity:</span>
                                    <span class="text-gray-600">
                                        {{ $ticket->last_replied_at?->diffForHumans() ?? $ticket->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <a href="{{ route('admin.support.show', $ticket) }}"
                                   class="px-4 py-2 bg-[#063970] hover:bg-[#063970]/90 text-white rounded text-sm font-medium transition">
                                    Manage →
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-500">
                            <p class="text-base font-medium">No support tickets found</p>
                            <p class="text-sm mt-1.5">New requests will appear here</p>
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
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#FF7A28',
                    timer: 3200,
                    timerProgressBar: true
                });
            @endif
        </script>
    @endpush

</x-admin.admin-layout>
