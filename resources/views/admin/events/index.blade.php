{{-- resources/views/admin/events/index.blade.php --}}
<x-admin.admin-layout>

    <div class="py-8 px-4 max-w-7xl mx-auto">

        <!-- Header -->
        <div class="bg-darkBlue text-white rounded-2xl shadow-xl p-8 mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                <div>
                    <h1 class="text-3xl font-bold">All Events</h1>
                    <p class="text-blue-200 mt-1">Manage your events</p>
                </div>
                <div class="flex gap-3">
                    <form method="GET" action="{{ route('admin.events.index') }}" class="flex gap-2">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search events..."
                            class="px-5 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-blue-200 focus:outline-none focus:ring-2 focus:ring-orange-400 w-64">
                        <button type="submit"
                            class="px-6 py-3 bg-primary hover:bg-orange-600 text-white rounded-xl font-medium transition shadow">Search</button>
                    </form>
                    <a href="{{ route('admin.events.create') }}"
                        class="px-8 py-3 bg-primary hover:bg-orange-600 text-white rounded-xl font-medium transition shadow-lg">
                        Add New Event
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
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700">Title</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600">Category</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600">Date</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($events as $event)
                            <tr class="hover:bg-orange-50 transition">
                                <td class="px-6 py-5 text-center text-gray-600 font-medium">{{ $loop->iteration }}</td>

                                <td class="px-6 py-5">
                                    <div class="font-semibold text-gray-900">{{ Str::limit($event->title, 50) }}</div>
                                    <div class="text-sm text-gray-500 mt-1">{{ $event->location }}</div>
                                </td>

                                <td class="px-6 py-5">
                                    <span
                                        class="px-4 py-1.5 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                                        {{ $event->category?->name ?? '—' }}
                                    </span>
                                </td>

                                <td class="px-6 py-5 text-gray-700">
                                    {{ $event->start_date->format('d M Y') }}
                                    @if ($event->end_date)
                                        <br><small class="text-gray-500">→
                                            {{ $event->end_date->format('d M Y') }}</small>
                                    @endif
                                </td>

                                <td class="px-6 py-5 text-center">
                                    @switch($event->status)
                                        @case('published')
                                            <span
                                                class="px-4 py-1.5 bg-green-100 text-green-800 rounded-full text-xs font-medium">Published</span>
                                        @break

                                        @case('draft')
                                            <span
                                                class="px-4 py-1.5 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">Draft</span>
                                        @break

                                        @case('cancelled')
                                            <span
                                                class="px-4 py-1.5 bg-red-100 text-red-800 rounded-full text-xs font-medium">Cancelled</span>
                                        @break

                                        @case('completed')
                                            <span
                                                class="px-4 py-1.5 bg-gray-100 text-gray-700 rounded-full text-xs font-medium">Completed</span>
                                        @break

                                        @default
                                            <span
                                                class="px-4 py-1.5 bg-gray-100 text-gray-700 rounded-full text-xs font-medium">Unknown</span>
                                    @endswitch
                                </td>

                                <!-- ACTIONS - 100% CLICKABLE -->
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-3">

                                        <!-- Edit Button -->
                                        <a href="{{ route('admin.events.edit', $event) }}"
                                            class="px-4 py-2.5 rounded-lg bg-[#063970] text-white font-medium
                  shadow-sm hover:bg-blue-700 hover:shadow-md
                  transition-all duration-200 text-center min-w-[70px]">
                                            Edit
                                        </a>

                                        <!-- Delete Button -->
                                        <form action="{{ route('admin.events.destroy', $event) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Delete {{ addslashes($event->title) }}?')"
                                                class="px-4 py-2.5 rounded-lg bg-red-600 text-white font-medium
                           shadow-sm hover:bg-red-700 hover:shadow-md
                           transition-all duration-200 text-center min-w-[70px]">
                                                Delete
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-20 text-gray-500">
                                        <p class="text-2xl font-medium">No events found</p>
                                        <a href="{{ route('admin.events.create') }}"
                                            class="text-primary hover:underline mt-4 inline-block">
                                            Create your first event →
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-5 bg-gray-50 border-t text-center">
                    {{ $events->appends(request()->query())->links('pagination::tailwind') }}
                </div>
            </div>
        </div>

        <!-- SweetAlert2 + Scripts -->
        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                function deleteEvent(id, title) {
                    Swal.fire({
                        title: 'Delete Event?',
                        text: `"${title}" will be permanently deleted!`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('delete-form-' + id).submit();
                        }
                    });
                }

                @if (session('swal_success'))
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: '{{ session('swal_success') }}',
                        confirmButtonColor: '#FF7A28',
                        timer: 4000,
                        timerProgressBar: true
                    });
                @endif
            </script>
        @endpush

    </x-admin.admin-layout>

