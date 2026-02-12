<x-admin.admin-layout title="Manage Organizers">

    <div class="py-6 px-4 max-w-7xl mx-auto">

        <!-- Header -->
        <div class="bg-[#063970] text-white rounded-xl shadow-md p-6 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold">Manage Organizers</h1>
                    <p class="text-blue-100 text-sm mt-1 opacity-90">Approved & active organizers</p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <form method="GET" action="{{ route('admin.organizers.index') }}" class="flex flex-wrap gap-2">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search name, org, email..."
                               class="flex-1 min-w-[220px] px-4 py-2.5 rounded-lg bg-white/15 border border-white/30 text-white placeholder-blue-200 focus:outline-none focus:border-[#FF7A28] focus:ring-2 focus:ring-[#FF7A28]/30 text-sm">

                        <select name="status"
                                class="px-4 py-2.5 rounded-lg bg-white/15 border border-white/30 text-white focus:outline-none focus:border-[#FF7A28] focus:ring-2 focus:ring-[#FF7A28]/30 text-sm min-w-[140px]">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>

                        <button type="submit"
                                class="px-5 py-2.5 bg-[#FF7A28] hover:bg-[#FF7A28]/90 text-white rounded-lg font-medium transition text-sm shadow-sm">
                            <i class="fas fa-search"></i>
                        </button>

                        @if(request()->hasAny(['search', 'status']))
                            <a href="{{ route('admin.organizers.index') }}"
                               class="px-5 py-2.5 bg-white/20 hover:bg-white/30 text-white rounded-lg font-medium transition text-sm shadow-sm">
                                <i class="fas fa-times"></i> Clear
                            </a>
                        @endif
                    </form>
                </div>
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
                            <th class="px-5 py-3.5 text-left w-16">#</th>
                            <th class="px-5 py-3.5 text-left">Organization</th>
                            <th class="px-5 py-3.5 text-left">Contact Person</th>
                            <th class="px-5 py-3.5 text-left">Email</th>
                            <th class="px-5 py-3.5 text-center">Status</th>
                            <th class="px-5 py-3.5 text-left">Applied On</th>
                            <th class="px-5 py-3.5 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($organizers as $org)
                            <tr class="hover:bg-orange-50/30 transition-colors">
                                <td class="px-5 py-4 text-center text-gray-500 font-medium">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-5 py-4 font-medium text-gray-900">
                                    {{ $org->organization_name }}
                                </td>
                                <td class="px-5 py-4 text-gray-700">
                                    {{ $org->contact_person ?? '—' }}
                                </td>
                                <td class="px-5 py-4 text-gray-600">
                                    {{ $org->email }}
                                </td>
                                <td class="px-5 py-4 text-center">
                                    <span class="px-3 py-1 rounded-full text-xs font-medium
                                           {{ $org->is_frozen ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $org->is_frozen ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-gray-600 text-sm">
                                    {{ $org->applied_at?->format('d M Y') ?? '—' }}
                                </td>
                                <td class="px-5 py-4 text-center">
                                    <a href="{{ route('admin.organizers.show', $org) }}"
                                       class="px-3.5 py-1.5 bg-[#063970] hover:bg-[#063970]/90 text-white text-xs font-medium rounded-md transition shadow-sm inline-block">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-14 text-gray-500">
                                    <p class="text-base font-medium">
                                        @if(request()->hasAny(['search', 'status']))
                                            No organizers match your filter
                                        @else
                                            No organizers yet
                                        @endif
                                    </p>
                                    <p class="text-sm mt-1.5">Approved applications will appear here</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Mobile Cards -->
                <div class="lg:hidden divide-y divide-gray-200">
                    @forelse($organizers as $org)
                        <div class="p-4 hover:bg-orange-50/30 transition">
                            <div class="flex items-start justify-between mb-2">
                                <div>
                                    <div class="font-medium text-gray-900">
                                        {{ $org->organization_name }}
                                    </div>
                                    <div class="text-xs text-gray-500 mt-0.5">
                                        {{ $org->contact_person ?? '—' }}
                                    </div>
                                </div>

                                <span class="px-3 py-1 rounded-full text-xs font-medium
                                       {{ $org->is_frozen ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $org->is_frozen ? 'Active' : 'Inactive' }}
                                </span>
                            </div>

                            <div class="text-xs space-y-1 mb-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Email:</span>
                                    <span class="text-gray-700">{{ $org->email }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Applied:</span>
                                    <span class="text-gray-600">
                                        {{ $org->applied_at?->format('d M Y') ?? '—' }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <a href="{{ route('admin.organizers.show', $org) }}"
                                   class="px-4 py-2 bg-[#063970] hover:bg-[#063970]/90 text-white rounded text-sm font-medium transition">
                                    <i class="fas fa-eye mr-1"></i> View
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-500">
                            <p class="text-base font-medium">
                                @if(request()->hasAny(['search', 'status']))
                                    No matching organizers
                                @else
                                    No organizers yet
                                @endif
                            </p>
                            <p class="text-sm mt-1.5">Approved applications will appear here</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            <div class="px-5 py-4 bg-gray-50 border-t text-center sm:text-right text-sm text-gray-600">
                {{ $organizers->appends(request()->query())->links('pagination::tailwind') }}
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
