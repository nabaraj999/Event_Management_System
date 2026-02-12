<x-admin.admin-layout title="Organizer Applications">

    <div class="py-6 px-4 max-w-7xl mx-auto">

        <!-- Header -->
        <div class="bg-[#063970] text-white rounded-xl shadow-md p-6 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold">Organizer Applications</h1>
                    <p class="text-blue-100 text-sm mt-1 opacity-90">Review and manage new organizer requests</p>
                </div>

                <!-- If you later add search or filters, place them here like other pages -->
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
                <table class="w-full min-w-[900px] hidden md:table">
                    <thead class="bg-gray-50">
                        <tr class="text-xs font-semibold text-gray-600 uppercase tracking-wide">
                            <th class="px-5 py-3.5 text-left w-16">#</th>
                            <th class="px-5 py-3.5 text-left">Organization</th>
                            <th class="px-5 py-3.5 text-left">Contact Person</th>
                            <th class="px-5 py-3.5 text-left">Phone</th>
                            <th class="px-5 py-3.5 text-center">Status</th>
                            <th class="px-5 py-3.5 text-left">Applied On</th>
                            <th class="px-5 py-3.5 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($applications as $app)
                            <tr class="hover:bg-orange-50/30 transition-colors">
                                <td class="px-5 py-4 text-center text-gray-500 font-medium">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-5 py-4 font-medium text-gray-900">
                                    {{ $app->organization_name }}
                                </td>
                                <td class="px-5 py-4 text-gray-700">
                                    {{ $app->contact_person ?? '—' }}
                                </td>
                                <td class="px-5 py-4 text-gray-700">
                                    {{ $app->phone ?? '—' }}
                                </td>
                                <td class="px-5 py-4 text-center">
                                    @switch($app->status)
                                        @case('pending')
                                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">Pending</span>
                                            @break
                                        @case('approved')
                                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Approved</span>
                                            @break
                                        @case('rejected')
                                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">Rejected</span>
                                            @break
                                        @default
                                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">—</span>
                                    @endswitch
                                </td>
                                <td class="px-5 py-4 text-gray-600 text-sm">
                                    {{ optional($app->applied_at)->format('d M Y, h:i A') ?? '—' }}
                                </td>
                                <td class="px-5 py-4 text-center">
                                    <a href="{{ route('admin.organizer-applications.show', $app) }}"
                                       class="px-3.5 py-1.5 bg-[#063970] hover:bg-[#063970]/90 text-white text-xs font-medium rounded-md transition shadow-sm inline-block">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-14 text-gray-500">
                                    <p class="text-base font-medium">No organizer applications yet</p>
                                    <p class="text-sm mt-1.5">New requests will appear here</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Mobile Cards -->
                <div class="md:hidden divide-y divide-gray-200">
                    @forelse($applications as $app)
                        <div class="p-4 hover:bg-orange-50/30 transition">
                            <div class="flex items-start justify-between mb-2">
                                <div>
                                    <div class="font-medium text-gray-900">
                                        {{ $app->organization_name }}
                                    </div>
                                    <div class="text-xs text-gray-500 mt-0.5">
                                        {{ $app->contact_person ?? '—' }}
                                    </div>
                                </div>

                                @switch($app->status)
                                    @case('pending')
                                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">Pending</span>
                                        @break
                                    @case('approved')
                                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Approved</span>
                                        @break
                                    @case('rejected')
                                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">Rejected</span>
                                        @break
                                    @default
                                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">—</span>
                                @endswitch
                            </div>

                            <div class="text-sm space-y-1.5 mb-3">
                                <div class="flex justify-between">
                                    <span class="text-xs text-gray-500">Phone:</span>
                                    <span class="text-gray-900">{{ $app->phone ?? '—' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-xs text-gray-500">Applied:</span>
                                    <span class="text-gray-600">
                                        {{ optional($app->applied_at)->format('d M Y') ?? '—' }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <a href="{{ route('admin.organizer-applications.show', $app) }}"
                                   class="px-4 py-2 bg-[#063970] hover:bg-[#063970]/90 text-white rounded text-sm font-medium transition">
                                    View Details →
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-500">
                            <p class="text-base font-medium">No organizer applications yet</p>
                            <p class="text-sm mt-1.5">New requests will appear here</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            <div class="px-5 py-4 bg-gray-50 border-t text-center sm:text-right text-sm text-gray-600">
                {{ $applications->appends(request()->query())->links('pagination::tailwind') }}
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
