{{-- resources/views/organizer/support/index.blade.php --}}

<x-organizer.organizer-layout>

    <div class="py-8 px-4 max-w-7xl mx-auto">

        <!-- Header -->
        <div class="bg-darkBlue text-white rounded-2xl shadow-xl p-8 mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                <div>
                    <h1 class="text-3xl font-bold">Support Tickets</h1>
                    <p class="text-blue-200 mt-1">View and manage your help requests</p>
                </div>
                <div class="flex gap-3">
                    <form method="GET" action="{{ route('org.support.index') }}" class="flex gap-2">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search tickets..."
                            class="px-5 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-blue-200 focus:outline-none focus:ring-2 focus:ring-orange-400 w-64">
                        <button type="submit"
                            class="px-6 py-3 bg-primary hover:bg-orange-600 text-white rounded-xl font-medium transition shadow">
                            Search
                        </button>
                    </form>
                    <a href="{{ route('org.support.create') }}"
                        class="px-8 py-3 bg-primary hover:bg-orange-600 text-white rounded-xl font-medium transition shadow-lg">
                        New Ticket
                    </a>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">#</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700">Ticket ID & Subject</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600">Priority</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600">Last Activity</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600">Messages</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($tickets as $ticket)
                            <tr class="hover:bg-orange-50 transition">
                                <td class="px-6 py-5 text-center text-gray-600 font-medium">
                                    {{ $loop->iteration + ($tickets->currentPage() - 1) * $tickets->perPage() }}
                                </td>

                                <td class="px-6 py-5">
                                    <div class="font-semibold text-gray-900">
                                        <a href="{{ route('org.support.show', $ticket) }}" class="hover:text-primary transition">
                                            #{{ $ticket->ticket_id }} – {{ Str::limit($ticket->subject, 50) }}
                                        </a>
                                    </div>
                                    <div class="text-sm text-gray-500 mt-1">
                                        Opened: {{ $ticket->created_at->format('d M Y') }}
                                    </div>
                                </td>

                                <td class="px-6 py-5">
                                    <span class="px-4 py-1.5 text-xs font-medium rounded-full
                                        @if($ticket->priority === 'urgent')
                                            bg-red-100 text-red-800
                                        @else
                                            bg-yellow-100 text-yellow-800
                                        @endif">
                                        {{ ucfirst($ticket->priority) }}
                                    </span>
                                </td>

                                <td class="px-6 py-5">
                                    @switch($ticket->status)
                                        @case('open')
                                            <span class="px-4 py-1.5 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">Open</span>
                                            @break
                                        @case('waiting_for_reply')
                                            <span class="px-4 py-1.5 bg-purple-100 text-purple-800 rounded-full text-xs font-medium">Waiting for Reply</span>
                                            @break
                                        @case('replied')
                                            <span class="px-4 py-1.5 bg-green-100 text-green-800 rounded-full text-xs font-medium">Replied</span>
                                            @break
                                        @case('closed')
                                            <span class="px-4 py-1.5 bg-gray-100 text-gray-700 rounded-full text-xs font-medium">Closed</span>
                                            @break
                                        @default
                                            <span class="px-4 py-1.5 bg-gray-100 text-gray-700 rounded-full text-xs font-medium">Unknown</span>
                                    @endswitch
                                </td>

                                <td class="px-6 py-5 text-gray-700">
                                    {{ $ticket->last_replied_at?->diffForHumans() ?? $ticket->created_at->diffForHumans() }}
                                    <br>
                                    <small class="text-gray-500">
                                        {{ $ticket->last_replied_at?->format('d M Y, h:i A') ?? $ticket->created_at->format('d M Y, h:i A') }}
                                    </small>
                                </td>

                                <td class="px-6 py-5 text-center text-gray-700">
                                    <span class="font-medium">{{ $ticket->replies->count() }}</span>
                                    <br>
                                    <small class="text-gray-500">{{ Str::plural('message', $ticket->replies->count()) }}</small>
                                </td>

                                <!-- ACTIONS -->
                                <td class="px-6 py-5">
                                    <div class="flex items-center justify-center gap-3">
                                        <!-- View Button -->
                                        <a href="{{ route('org.support.show', $ticket) }}"
                                            class="px-5 py-2.5 rounded-lg bg-[#063970] text-white font-medium
                                                   shadow-sm hover:bg-blue-700 hover:shadow-md
                                                   transition-all duration-200 text-center min-w-[80px]">
                                            View
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-20 text-gray-500">
                                    <svg class="mx-auto h-20 w-20 text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                    <p class="text-2xl font-medium">No support tickets yet</p>
                                    <p class="mt-3 text-gray-600">When you need help, we'll be here.</p>
                                    <a href="{{ route('org.support.create') }}"
                                        class="text-primary hover:underline mt-6 inline-block font-medium">
                                        Create your first ticket →
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-5 bg-gray-50 border-t text-center">
                {{ $tickets->appends(request()->query())->links('pagination::tailwind') }}
            </div>
        </div>
    </div>

    <!-- SweetAlert2 + Success Message -->
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#FF7A28',
                    timer: 4000,
                    timerProgressBar: true
                });
            @endif
        </script>
    @endpush

</x-organizer.organizer-layout>
