<x-admin.admin-layout title="Manage Organizers">

    <!-- Font Awesome (already in layout, but safe to keep if needed) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
          integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8">
        <div class="bg-white shadow-2xl rounded-2xl overflow-hidden">

            <!-- Header + Search -->
            <div class="bg-[#063970] text-white px-6 py-5 lg:px-8 lg:py-6">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <h1 class="text-2xl lg:text-3xl font-bold">Manage Organizers</h1>

                    </div>

                    <!-- Search + Filter -->
                    <form method="GET" action="{{ route('admin.organizers.index') }}" class="flex flex-col sm:flex-row gap-3">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search by name, organization, email..."
                               class="w-full sm:w-64 px-4 py-3 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-white">

                        <select name="status" class="w-full sm:w-48 px-4 py-3 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-white">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>

                        <div class="flex gap-3">
                            <button type="submit"
                                    class="w-full sm:w-auto px-6 py-3 bg-white text-[#FF7A28] font-bold rounded-lg hover:bg-gray-100 transition shadow">
                                <i class="fas fa-search mr-2"></i>
                            </button>

                            @if(request()->hasAny(['search', 'status']))
                                <a href="{{ route('admin.organizers.index') }}"
                                   class="w-full sm:w-auto text-center px-6 py-3 bg-gray-600 text-white font-bold rounded-lg hover:bg-gray-700 transition shadow">
                                    <i class="fas fa-times mr-2"></i> Clear
                                </a>
                            @endif
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
                            <th class="px-6 py-4">#</th>
                            <th class="px-6 py-4">Organization</th>
                            <th class="px-6 py-4">Contact Person</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4">Applied On</th>
                            <th class="px-6 py-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($organizers as $index => $org)
                            <tr class="bg-white border-b hover:bg-orange-50 transition">
                                <td class="px-6 py-5 font-medium">{{ $organizers->firstItem() + $index }}</td>
                                <td class="px-6 py-5 font-semibold text-[#063970]">{{ $org->organization_name }}</td>
                                <td class="px-6 py-5">{{ $org->contact_person }}</td>
                                <td class="px-6 py-5 text-gray-600">{{ $org->email }}</td>
                                <td class="px-6 py-5 text-center">
                                    <span class="px-4 py-2 rounded-full text-xs font-medium {{ $org->is_frozen ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $org->is_frozen ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-gray-600">
                                    {{ $org->applied_at?->format('d M Y') ?? '-' }}
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <a href="{{ route('admin.organizers.show', $org->id) }}"
                                       class="px-5 py-2 bg-[#063970] text-white rounded-lg hover:bg-[#052e5c] transition text-xs font-medium">
                                        <i class="fas fa-eye mr-1"></i> 
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-20 text-center text-gray-500 text-lg">
                                    @if(request('search') || request('status'))
                                        No organizers found for your search/filter.
                                    @else
                                        No organizer applications yet.
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Mobile Cards -->
                <div class="lg:hidden">
                    @forelse($organizers as $org)
                        <div class="m-4 p-5 bg-white border border-gray-200 rounded-xl shadow hover:shadow-lg transition">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <h3 class="font-bold text-[#063970] text-lg">{{ $org->organization_name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $org->contact_person }}</p>
                                    <p class="text-sm text-gray-500 mt-1">{{ $org->email }}</p>
                                </div>
                                <span class="px-4 py-2 rounded-full text-xs font-medium {{ $org->is_frozen ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $org->is_frozen ? 'Active' : 'Inactive' }}
                                </span>
                            </div>

                            <div class="text-sm text-gray-600 mb-4">
                                <p><strong>Applied:</strong> {{ $org->applied_at?->format('d M Y') ?? 'N/A' }}</p>
                            </div>

                            <div class="flex justify-center">
                                <a href="{{ route('admin.organizers.show', $org->id) }}"
                                   class="w-full text-center py-3 bg-[#063970] text-white rounded-lg hover:bg-[#052e5c] transition font-medium">
                                    <i class="fas fa-eye mr-2"></i> Review Application
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="m-6 p-10 text-center text-gray-500 bg-gray-50 rounded-xl">
                            <p class="text-xl mb-4">
                                @if(request('search') || request('status'))
                                    No matching organizers found
                                @else
                                    No organizer applications yet
                                @endif
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            <div class="bg-gray-50 px-6 py-4 flex flex-col sm:flex-row items-center justify-between border-t text-sm">
                <div class="text-gray-600 mb-3 sm:mb-0">
                    Showing {{ $organizers->firstItem() ?? 0 }} to {{ $organizers->lastItem() ?? 0 }} of {{ $organizers->total() }} entries
                </div>
                <div>
                    {{ $organizers->appends(request()->query())->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    </div>
</x-admin.admin-layout>
