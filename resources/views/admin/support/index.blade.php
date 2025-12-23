<x-admin.admin-layout>

    <div class="py-8 px-4 max-w-7xl mx-auto">

        <div class="bg-darkBlue text-white rounded-2xl shadow-xl p-8 mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                <div>
                    <h1 class="text-3xl font-bold">Support Tickets</h1>
                    <p class="text-blue-200 mt-2">Manage all organizer help requests</p>
                </div>
                <div class="flex gap-3">
                    <form method="GET" class="flex gap-2">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search tickets..."
                            class="px-5 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-blue-200 focus:outline-none focus:ring-2 focus:ring-orange-400 w-64">
                        <button type="submit" class="px-6 py-3 bg-primary hover:bg-orange-600 text-white rounded-xl font-medium transition shadow">Search</button>
                    </form>
                </div>
            </div>

            <!-- Filters -->
            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ route('admin.support.index') }}" class="{{ !request('status') && !request('priority') ? 'bg-white text-darkBlue' : 'bg-white/20' }} px-5 py-2 rounded-xl font-medium transition">All</a>
                <a href="{{ route('admin.support.index', ['status' => 'open']) }}" class="{{ request('status') == 'open' ? 'bg-white text-darkBlue' : 'bg-white/20' }} px-5 py-2 rounded-xl font-medium transition">Open</a>
                <a href="{{ route('admin.support.index', ['status' => 'replied']) }}" class="{{ request('status') == 'replied' ? 'bg-white text-darkBlue' : 'bg-white/20' }} px-5 py-2 rounded-xl font-medium transition">Replied</a>
                <a href="{{ route('admin.support.index', ['priority' => 'urgent']) }}" class="{{ request('priority') == 'urgent' ? 'bg-red-600 text-white' : 'bg-red-600/30' }} px-5 py-2 rounded-xl font-medium transition">Urgent Only</a>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Ticket</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600">Organizer</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600">Priority</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600">Last Activity</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($tickets as $ticket)
                            <tr class="hover:bg-orange-50 transition">
                                <td class="px-6 py-5">
                                    <a href="{{ route('admin.support.show', $ticket) }}" class="font-semibold text-darkBlue hover:text-primary">
                                        #{{ $ticket->ticket_id }}
                                    </a>
                                    <p class="text-sm text-gray-600 mt-1">{{ Str::limit($ticket->subject, 60) }}</p>
                                </td>
                                <td class="px-6 py-5 text-gray-700">
                                    {{ $ticket->organizer->name }}
                                    <br><small class="text-gray-500">{{ $ticket->organizer->email }}</small>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="px-4 py-1.5 rounded-full text-xs font-medium {{ $ticket->priority === 'urgent' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($ticket->priority) }}
                                    </span>
                                </td>
                                <td class="px-6 py-5">
                                    @include('admin.support.partials.status-badge', ['status' => $ticket->status])
                                </td>
                                <td class="px-6 py-5 text-gray-700">
                                    {{ $ticket->last_replied_at?->diffForHumans() ?? $ticket->created_at->diffForHumans() }}
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <a href="{{ route('admin.support.show', $ticket) }}"
                                       class="px-6 py-3 bg-primary text-white rounded-xl font-medium hover:bg-orange-600 transition shadow">
                                        Manage
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-20 text-gray-500">
                                    <p class="text-2xl font-medium">No tickets found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-5 bg-gray-50 border-t text-center">
                {{ $tickets->appends(request()->query())->links('pagination::tailwind') }}
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            @if(session('success'))
                Swal.fire('Success!', '{{ session('success') }}', 'success');
            @endif
        </script>
    @endpush

</x-admin.admin-layout>
