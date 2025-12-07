{{-- resources/views/admin/categories/index.blade.php --}}
<x-admin.admin-layout title="Event Categories">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
      integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
      crossorigin="anonymous" referrerpolicy="no-referrer" />

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white shadow-2xl rounded-2xl overflow-hidden">

            <!-- Header + Search -->
            <div class="bg-[#FF7A28] text-white px-8 py-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-bold">Event Categories</h1>
                        <p class="opacity-90 mt-1">Manage all event categories</p>
                    </div>

                    <!-- Search Form -->
                    <form method="GET" action="{{ route('admin.categories.index') }}" class="flex gap-3">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search categories..."
                               class="px-4 py-3 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-white w-64">
                        <button type="submit" class="px-6 py-3 bg-white text-[#FF7A28] font-bold rounded-lg hover:bg-gray-100 transition shadow">
                            Search
                        </button>
                        <a href="{{ route('admin.categories.create') }}"
                           class="px-6 py-3 bg-white text-[#FF7A28] font-bold rounded-lg hover:bg-gray-100 transition shadow">
                            + Add New
                        </a>
                    </form>
                </div>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="mx-8 mt-6 bg-orange-50 border-l-4 border-[#FF7A28] text-orange-800 px-6 py-4 rounded-r-lg">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="text-xs uppercase bg-gray-100 text-gray-600">
                        <tr>
                            <th class="px-6 py-4">#</th>
                            <th class="px-6 py-4">Category Name</th>
                            <th class="px-6 py-4 text-center">Icon</th>
                            <th class="px-6 py-4">Description</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-center">Order</th>
                            <th class="px-6 py-4 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $index => $category)
                            <tr class="bg-white border-b hover:bg-orange-50 transition">
                                <td class="px-6 py-5 font-medium">{{ $categories->firstItem() + $index }}</td>
                                <td class="px-6 py-5 font-semibold text-[#063970]">{{ $category->name }}</td>
                                <td class="px-6 py-5 text-center">
                                    <div class="inline-flex items-center justify-center w-14 h-14 bg-orange-50 rounded-full shadow-inner">
                                        {!! $category->renderIcon('w-8 h-8 text-[#FF7A28]') !!}
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-gray-600 max-w-xs">
                                    {{ $category->description ? Str::limit($category->description, 80) : '-' }}
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <span class="px-4 py-2 rounded-full text-xs font-medium {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $category->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-center text-gray-600">{{ $category->sort_order }}</td>
                                <td class="px-6 py-5 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('admin.categories.edit', $category) }}"
                                           class="px-4 py-2 bg-[#063970] text-white rounded-lg hover:bg-[#052e5c] transition text-xs font-medium">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('Delete {{ addslashes($category->name) }}?')"
                                                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-xs font-medium">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-20 text-center text-gray-500">
                                    <p class="text-2xl mb-4">
                                        @if(request('search'))
                                            No results found for "<strong>{{ request('search') }}</strong>"
                                        @else
                                            No categories yet
                                        @endif
                                    </p>
                                    <a href="{{ route('admin.categories.create') }}" class="text-[#FF7A28] font-bold underline">
                                        Create your first category
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="bg-gray-50 px-8 py-4 flex flex-col sm:flex-row items-center justify-between border-t">
                <div class="text-sm text-gray-600 mb-4 sm:mb-0">
                    Showing {{ $categories->firstItem() }} to {{ $categories->lastItem() }} of {{ $categories->total() }} entries
                </div>
                <div>
                    {{ $categories->appends(request()->query())->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    </div>
</x-admin.admin-layout>
