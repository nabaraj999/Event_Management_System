<x-admin.admin-layout title="Event Categories">

    <div class="py-6 px-4 max-w-7xl mx-auto">

        <!-- Header -->
        <div class="bg-[#063970] text-white rounded-xl shadow-md p-6 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold">Event Categories</h1>
                    <p class="text-blue-100 text-sm mt-1 opacity-90">Manage all event categories</p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <!-- Search -->
                    <form method="GET" action="{{ route('admin.categories.index') }}" class="flex gap-2 min-w-[240px]">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search category name..."
                               class="flex-1 px-4 py-2.5 rounded-lg bg-white/15 border border-white/30 text-white placeholder-blue-200 focus:outline-none focus:border-[#FF7A28] focus:ring-2 focus:ring-[#FF7A28]/30 text-sm">
                        <button type="submit"
                                class="px-5 py-2.5 bg-[#FF7A28] hover:bg-[#FF7A28]/90 text-white rounded-lg font-medium transition text-sm shadow-sm">
                            Search
                        </button>
                    </form>

                    <!-- Create Button -->
                    <a href="{{ route('admin.categories.create') }}"
                       class="px-6 py-2.5 bg-[#FF7A28] hover:bg-[#FF7A28]/90 text-white rounded-lg font-medium shadow-sm transition text-sm whitespace-nowrap">
                        + New Category
                    </a>
                </div>
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
                <table class="w-full min-w-[900px] hidden lg:table">
                    <thead class="bg-gray-50">
                        <tr class="text-xs font-semibold text-gray-600 uppercase tracking-wide">
                            <th class="px-5 py-3.5 text-left w-16">#</th>
                            <th class="px-5 py-3.5 text-left">Category Name</th>
                            <th class="px-5 py-3.5 text-center">Icon</th>
                            <th class="px-5 py-3.5 text-left">Description</th>
                            <th class="px-5 py-3.5 text-center">Status</th>
                            <th class="px-5 py-3.5 text-center">Order</th>
                            <th class="px-5 py-3.5 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($categories as $category)
                            <tr class="hover:bg-orange-50/30 transition-colors">
                                <td class="px-5 py-4 text-center text-gray-500 font-medium">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-5 py-4 font-medium text-gray-900">
                                    {{ $category->name }}
                                </td>

                                <td class="px-5 py-4 text-center">
                                    <div class="inline-flex items-center justify-center w-10 h-10 bg-orange-50 rounded-full shadow-inner mx-auto">
                                        {!! $category->renderIcon('w-6 h-6 text-[#FF7A28]') !!}
                                    </div>
                                </td>

                                <td class="px-5 py-4 text-gray-600">
                                    {{ $category->description ? Str::limit($category->description, 70) : '—' }}
                                </td>

                                <td class="px-5 py-4 text-center">
                                    <span class="px-3 py-1 rounded-full text-xs font-medium
                                           {{ $category->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $category->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>

                                <td class="px-5 py-4 text-center text-gray-700">
                                    {{ $category->sort_order ?? '—' }}
                                </td>

                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.categories.edit', $category) }}"
                                           class="px-3.5 py-1.5 bg-[#063970] hover:bg-[#063970]/90 text-white text-xs font-medium rounded-md transition shadow-sm">
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('Delete «{{ addslashes($category->name) }}» ?')"
                                                    class="px-3.5 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded-md transition shadow-sm">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-16 text-gray-500">
                                    <p class="text-lg font-medium">
                                        @if(request('search'))
                                            No categories found for "{{ request('search') }}"
                                        @else
                                            No categories created yet
                                        @endif
                                    </p>
                                    <a href="{{ route('admin.categories.create') }}"
                                       class="text-[#FF7A28] hover:underline mt-2 inline-block text-sm font-medium">
                                        → Create your first category
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Mobile Cards -->
                <div class="lg:hidden divide-y divide-gray-200">
                    @forelse($categories as $category)
                        <div class="p-5 hover:bg-orange-50/30 transition">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="p-2.5 bg-orange-50 rounded-full">
                                        {!! $category->renderIcon('w-8 h-8 text-[#FF7A28]') !!}
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-gray-900">{{ $category->name }}</h3>
                                        <div class="text-xs text-gray-500 mt-0.5">
                                            Order: {{ $category->sort_order ?? '—' }}
                                        </div>
                                    </div>
                                </div>

                                <span class="px-3 py-1 rounded-full text-xs font-medium
                                       {{ $category->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>

                            @if($category->description)
                                <p class="text-xs text-gray-600 mb-4">
                                    {{ Str::limit($category->description, 90) }}
                                </p>
                            @endif

                            <div class="flex gap-2">
                                <a href="{{ route('admin.categories.edit', $category) }}"
                                   class="flex-1 text-center py-2.5 bg-[#063970] hover:bg-[#063970]/90 text-white rounded-md text-sm font-medium transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="flex-1">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Delete «{{ addslashes($category->name) }}» ?')"
                                            class="w-full py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-md text-sm font-medium transition">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-10 text-center text-gray-500">
                            <p class="text-lg font-medium">
                                @if(request('search'))
                                    No matching categories
                                @else
                                    No categories yet
                                @endif
                            </p>
                            <a href="{{ route('admin.categories.create') }}"
                               class="text-[#FF7A28] hover:underline mt-3 inline-block text-sm font-medium">
                                → Create your first category
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            <div class="px-5 py-4 bg-gray-50 border-t text-center sm:text-right text-sm text-gray-600">
                {{ $categories->appends(request()->query())->links('pagination::tailwind') }}
            </div>
        </div>
    </div>

    <!-- Scripts -->
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
