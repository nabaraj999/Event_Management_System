<x-admin.admin-layout title="Manage Users">

    <div class="py-6 px-4 max-w-7xl mx-auto">

        <!-- Header -->
        <div class="bg-[#063970] text-white rounded-xl shadow-md p-6 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold">Manage Users</h1>
                    <p class="text-blue-100 text-sm mt-1 opacity-90">View and manage all registered users</p>
                </div>
            </div>
        </div>

        <!-- Search & Filter Bar -->
        <div class="bg-white rounded-xl shadow border border-gray-200 p-5 mb-6">
            <form method="GET" action="{{ route('admin.users.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Search by ID -->
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1.5">User ID</label>
                    <input type="number" name="user_id" value="{{ request('user_id') }}"
                           placeholder="e.g. 123"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-[#FF7A28] focus:ring-2 focus:ring-[#FF7A28]/30 text-sm">
                </div>

                <!-- Search by Name -->
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1.5">Name</label>
                    <input type="text" name="name" value="{{ request('name') }}"
                           placeholder="e.g. John Doe"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-[#FF7A28] focus:ring-2 focus:ring-[#FF7A28]/30 text-sm">
                </div>

                <!-- Sort By -->
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1.5">Sort By</label>
                    <select name="sort" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-[#FF7A28] focus:ring-2 focus:ring-[#FF7A28]/30 text-sm">
                        <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>Newest First</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name (A → Z)</option>
                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name (Z → A)</option>
                        <option value="email_asc" {{ request('sort') == 'email_asc' ? 'selected' : '' }}>Email (A → Z)</option>
                        <option value="email_desc" {{ request('sort') == 'email_desc' ? 'selected' : '' }}>Email (Z → A)</option>
                        <option value="interests_desc" {{ request('sort') == 'interests_desc' ? 'selected' : '' }}>Most Interests</option>
                        <option value="interests_asc" {{ request('sort') == 'interests_asc' ? 'selected' : '' }}>Least Interests</option>
                    </select>
                </div>

                <!-- Buttons -->
                <div class="flex items-end gap-3">
                    <button type="submit"
                            class="px-6 py-2.5 bg-[#FF7A28] hover:bg-[#FF7A28]/90 text-white font-medium rounded-lg transition text-sm shadow-sm">
                        Apply
                    </button>

                    @if(request()->hasAny(['user_id', 'name', 'sort']))
                        <a href="{{ route('admin.users.index') }}"
                           class="px-6 py-2.5 border border-gray-300 text-gray-700 hover:bg-gray-100 rounded-lg transition text-sm">
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Active Filters -->
        @if(request()->hasAny(['user_id', 'name', 'sort']))
            <div class="mb-6 flex flex-wrap gap-2">
                @if(request('user_id'))
                    <span class="inline-flex items-center px-3 py-1.5 bg-[#FF7A28]/10 text-[#FF7A28] rounded-full text-xs font-medium">
                        ID: {{ request('user_id') }}
                        <a href="{{ request()->except('user_id') }}" class="ml-2 text-[#FF7A28] hover:text-[#FF7A28]/80">×</a>
                    </span>
                @endif
                @if(request('name'))
                    <span class="inline-flex items-center px-3 py-1.5 bg-[#FF7A28]/10 text-[#FF7A28] rounded-full text-xs font-medium">
                        Name: {{ request('name') }}
                        <a href="{{ request()->except('name') }}" class="ml-2 text-[#FF7A28] hover:text-[#FF7A28]/80">×</a>
                    </span>
                @endif
                @if(request('sort') && request('sort') != 'latest')
                    <span class="inline-flex items-center px-3 py-1.5 bg-[#FF7A28]/10 text-[#FF7A28] rounded-full text-xs font-medium">
                        Sort: {{ ucwords(str_replace('_', ' ', request('sort'))) }}
                        <a href="{{ request()->except('sort') }}" class="ml-2 text-[#FF7A28] hover:text-[#FF7A28]/80">×</a>
                    </span>
                @endif
            </div>
        @endif

        <!-- Users Table / Cards -->
        <div class="bg-white rounded-xl shadow border border-gray-200 overflow-hidden">

            <div class="overflow-x-auto">

                <!-- Desktop Table -->
                <table class="w-full min-w-[900px] hidden lg:table">
                    <thead class="bg-gray-50">
                        <tr class="text-xs font-semibold text-gray-600 uppercase tracking-wide">
                            <th class="px-5 py-3.5 text-left w-16">ID</th>
                            <th class="px-5 py-3.5 text-left">Name</th>
                            <th class="px-5 py-3.5 text-left">Email</th>
                            <th class="px-5 py-3.5 text-center">Verified</th>
                            <th class="px-5 py-3.5 text-center">Interests</th>
                            <th class="px-5 py-3.5 text-left">Joined</th>
                            <th class="px-5 py-3.5 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($users as $user)
                            <tr class="hover:bg-orange-50/30 transition-colors">
                                <td class="px-5 py-4 text-gray-900 font-medium">{{ $user->id }}</td>
                                <td class="px-5 py-4 font-medium text-gray-900">{{ $user->name }}</td>
                                <td class="px-5 py-4 text-gray-600">{{ $user->email }}</td>
                                <td class="px-5 py-4 text-center">
                                    @if($user->email_verified_at)
                                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Verified</span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">Not Verified</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-center text-gray-600">
                                    @if($user->interests->count() > 0)
                                        <span class="text-[#FF7A28] font-medium">{{ $user->interests->count() }}</span>
                                    @else
                                        <span class="text-gray-400 italic">None</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-gray-600 text-sm">
                                    {{ $user->created_at->format('d M Y') }}
                                </td>
                                <td class="px-5 py-4 text-center">
                                    <a href="{{ route('admin.users.show', $user) }}"
                                       class="px-3.5 py-1.5 bg-[#063970] hover:bg-[#063970]/90 text-white text-xs font-medium rounded-md transition shadow-sm inline-block">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-14 text-gray-500">
                                    <p class="text-base font-medium">
                                        @if(request()->hasAny(['user_id', 'name', 'sort']))
                                            No users match your filters
                                        @else
                                            No users registered yet
                                        @endif
                                    </p>
                                    <p class="text-sm mt-1.5">New registrations will appear here</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Mobile Cards -->
                <div class="lg:hidden divide-y divide-gray-200">
                    @forelse($users as $user)
                        <div class="p-4 hover:bg-orange-50/30 transition">
                            <div class="flex items-start justify-between mb-2">
                                <div>
                                    <div class="font-medium text-gray-900">{{ $user->name }}</div>
                                    <div class="text-xs text-gray-600 mt-0.5">{{ $user->email }}</div>
                                </div>

                                @if($user->email_verified_at)
                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Verified</span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">Not Verified</span>
                                @endif
                            </div>

                            <div class="text-xs space-y-1.5 mb-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">ID:</span>
                                    <span class="font-medium text-gray-900">{{ $user->id }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Interests:</span>
                                    <span class="text-gray-900">
                                        {{ $user->interests->count() > 0 ? $user->interests->count() : 'None' }}
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Joined:</span>
                                    <span class="text-gray-600">{{ $user->created_at->format('d M Y') }}</span>
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <a href="{{ route('admin.users.show', $user) }}"
                                   class="px-4 py-2 bg-[#063970] hover:bg-[#063970]/90 text-white rounded text-sm font-medium transition">
                                    View Details →
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-500">
                            <p class="text-base font-medium">
                                @if(request()->hasAny(['user_id', 'name', 'sort']))
                                    No matching users
                                @else
                                    No users registered yet
                                @endif
                            </p>
                            <p class="text-sm mt-1.5">New registrations will appear here</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            <div class="px-5 py-4 bg-gray-50 border-t text-center sm:text-right text-sm text-gray-600">
                {{ $users->appends(request()->query())->links('pagination::tailwind') }}
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
