<x-admin.admin-layout>

<div class="py-8 px-4 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="bg-darkBlue text-white rounded-2xl shadow-xl p-8 mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold">Manage Users</h1>
                <p class="text-blue-200 mt-1">View and manage all registered users</p>
            </div>
        </div>
    </div>

    <!-- Search & Sort Bar -->
    <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
        <form method="GET" action="{{ route('admin.users.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search by ID -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Search by ID</label>
                <input type="number"
                       name="user_id"
                       value="{{ request('user_id') }}"
                       placeholder="e.g. 123"
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
            </div>

            <!-- Search by Name -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Search by Name</label>
                <input type="text"
                       name="name"
                       value="{{ request('name') }}"
                       placeholder="e.g. John Doe"
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
            </div>

            <!-- Sort By -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Sort By</label>
                <select name="sort" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
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
                        class="px-6 py-3 bg-primary text-white font-bold rounded-xl hover:bg-orange-600 transition shadow-lg">
                    Apply Filters
                </button>
                @if(request()->hasAny(['user_id', 'name', 'sort']))
                    <a href="{{ route('admin.users.index') }}"
                       class="px-6 py-3 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-100 transition">
                        Clear
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Active Filters Display -->
    @if(request()->hasAny(['user_id', 'name', 'sort']))
        <div class="mb-6 flex flex-wrap gap-2">
            @if(request('user_id'))
                <span class="inline-flex items-center px-4 py-2 bg-primary/10 text-primary rounded-full text-sm font-medium">
                    ID: {{ request('user_id') }}
                    <a href="{{ request()->except('user_id') }}" class="ml-2 text-primary hover:text-orange-700">×</a>
                </span>
            @endif
            @if(request('name'))
                <span class="inline-flex items-center px-4 py-2 bg-primary/10 text-primary rounded-full text-sm font-medium">
                    Name: {{ request('name') }}
                    <a href="{{ request()->except('name') }}" class="ml-2 text-primary hover:text-orange-700">×</a>
                </span>
            @endif
            @if(request('sort') && request('sort') != 'latest')
                <span class="inline-flex items-center px-4 py-2 bg-primary/10 text-primary rounded-full text-sm font-medium">
                    Sort: {{ ucwords(str_replace('_', ' ', request('sort'))) }}
                    <a href="{{ request()->except('sort') }}" class="ml-2 text-primary hover:text-orange-700">×</a>
                </span>
            @endif
        </div>
    @endif

    <!-- Users Table -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email Verified</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Interests</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Joined</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-5 text-sm text-gray-900">{{ $user->id }}</td>
                            <td class="px-6 py-5 text-sm font-medium text-gray-900">{{ $user->name }}</td>
                            <td class="px-6 py-5 text-sm text-gray-600">{{ $user->email }}</td>
                            <td class="px-6 py-5 text-sm">
                                @if($user->email_verified_at)
                                    <span class="px-3 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Verified</span>
                                @else
                                    <span class="px-3 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">Not Verified</span>
                                @endif
                            </td>
                            <td class="px-6 py-5 text-sm text-gray-600">
                                @if($user->interests->count() > 0)
                                    <span class="text-primary font-medium">{{ $user->interests->count() }}</span>
                                @else
                                    <span class="text-gray-400 italic">None</span>
                                @endif
                            </td>
                            <td class="px-6 py-5 text-sm text-gray-600">
                                {{ $user->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-5 text-sm">
                                <a href="{{ route('admin.users.show', $user) }}"
                                   class="text-primary hover:underline font-medium">
                                    View Details →
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                No users found matching your criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            {{ $users->appends(request()->query())->links() }}
        </div>
    </div>
</div>

</x-admin.admin-layout>
