<x-admin.admin-layout title="SEO Management">

    <div class="py-6 px-4 max-w-7xl mx-auto">

        <!-- Header -->
        <div class="bg-[#063970] text-white rounded-xl shadow-md p-6 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold">SEO Management</h1>
                    <p class="text-blue-100 text-sm mt-1 opacity-90">
                        Control meta tags, Open Graph, and SEO settings for all pages
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <form method="GET" action="{{ route('admin.seo.index') }}" class="flex gap-2 min-w-[240px]">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search by page key..."
                               class="flex-1 px-4 py-2.5 rounded-lg bg-white/15 border border-white/30 text-white placeholder-blue-200 focus:outline-none focus:border-[#FF7A28] focus:ring-2 focus:ring-[#FF7A28]/30 text-sm">
                        <button type="submit"
                                class="px-5 py-2.5 bg-[#FF7A28] hover:bg-[#FF7A28]/90 text-white rounded-lg font-medium transition text-sm shadow-sm">
                            Search
                        </button>
                    </form>

                    <a href="{{ route('admin.seo.create') }}"
                       class="px-6 py-2.5 bg-[#FF7A28] hover:bg-[#FF7A28]/90 text-white rounded-lg font-medium shadow-sm transition text-sm whitespace-nowrap">
                        + New SEO 
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-xl shadow border border-gray-200 overflow-hidden">

            <div class="overflow-x-auto">

                <!-- Desktop Table -->
                <table class="w-full min-w-[900px] hidden lg:table">
                    <thead class="bg-gray-50">
                        <tr class="text-xs font-semibold text-gray-600 uppercase tracking-wide">
                            <th class="px-5 py-3.5 text-left w-16">#</th>
                            <th class="px-5 py-3.5 text-left">Page Key</th>
                            <th class="px-5 py-3.5 text-left">Meta Title</th>
                            <th class="px-5 py-3.5 text-left">Description</th>
                            <th class="px-5 py-3.5 text-left">Keywords</th>
                            <th class="px-5 py-3.5 text-center">Status</th>
                            <th class="px-5 py-3.5 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($seoPages as $seo)
                            <tr class="hover:bg-orange-50/30 transition-colors">
                                <td class="px-5 py-4 text-center text-gray-500 font-medium">
                                    {{ $loop->iteration + ($seoPages->currentPage() - 1) * $seoPages->perPage() }}
                                </td>
                                <td class="px-5 py-4">
                                    <div class="font-medium text-gray-900">
                                        {{ ucfirst(str_replace(['.', '_'], ' ', $seo->page_key)) }}
                                    </div>
                                    <div class="text-xs text-gray-500 mt-0.5">
                                        Route: <code class="bg-gray-100 px-1.5 py-0.5 rounded text-xs">{{ $seo->page_key }}</code>
                                    </div>
                                </td>
                                <td class="px-5 py-4 text-gray-600">
                                    {{ Str::limit($seo->meta_title ?? '—', 60) }}
                                </td>
                                <td class="px-5 py-4 text-gray-600">
                                    {{ $seo->meta_description ? Str::limit($seo->meta_description, 60) : '— No description —' }}
                                </td>
                                <td class="px-5 py-4 text-gray-600">
                                    {{ $seo->meta_keywords ? Str::limit($seo->meta_keywords, 60) : '— No keywords —' }}
                                </td>
                                <td class="px-5 py-4 text-center">
                                    <span class="px-3 py-1 rounded-full text-xs font-medium
                                           {{ $seo->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $seo->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-center">
                                    <a href="{{ route('admin.seo.edit', $seo) }}"
                                       class="px-3.5 py-1.5 bg-[#063970] hover:bg-[#063970]/90 text-white text-xs font-medium rounded-md transition shadow-sm inline-block">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-14 text-gray-500">
                                    <p class="text-base font-medium">No SEO pages found</p>
                                    <a href="{{ route('admin.seo.create') }}"
                                       class="text-[#FF7A28] hover:underline mt-2 inline-block text-sm font-medium">
                                        → Add your first SEO page
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Mobile Cards -->
                <div class="lg:hidden divide-y divide-gray-200">
                    @forelse($seoPages as $seo)
                        <div class="p-4 hover:bg-orange-50/30 transition">
                            <div class="flex items-start justify-between mb-2">
                                <div>
                                    <div class="font-medium text-gray-900">
                                        {{ ucfirst(str_replace(['.', '_'], ' ', $seo->page_key)) }}
                                    </div>
                                    <div class="text-xs text-gray-500 mt-0.5">
                                        {{ $seo->page_key }}
                                    </div>
                                </div>

                                <span class="px-3 py-1 rounded-full text-xs font-medium
                                       {{ $seo->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $seo->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>

                            <div class="text-sm space-y-2 mb-3">
                                <div>
                                    <span class="text-xs text-gray-500">Title:</span>
                                    <span class="block text-gray-900">{{ Str::limit($seo->meta_title ?? '—', 60) }}</span>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500">Description:</span>
                                    <span class="block text-gray-600">
                                        {{ $seo->meta_description ? Str::limit($seo->meta_description, 60) : '—' }}
                                    </span>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500">Keywords:</span>
                                    <span class="block text-gray-600">
                                        {{ $seo->meta_keywords ? Str::limit($seo->meta_keywords, 60) : '—' }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <a href="{{ route('admin.seo.edit', $seo) }}"
                                   class="px-4 py-2 bg-[#063970] hover:bg-[#063970]/90 text-white rounded text-sm font-medium transition">
                                    Edit
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-500">
                            <p class="text-base font-medium">No SEO pages configured yet</p>
                            <a href="{{ route('admin.seo.create') }}"
                               class="text-[#FF7A28] hover:underline mt-2 inline-block text-sm font-medium">
                                → Add your first SEO page
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            <div class="px-5 py-4 bg-gray-50 border-t text-center sm:text-right text-sm text-gray-600">
                {{ $seoPages->appends(request()->query())->links('pagination::tailwind') }}
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            @if (session('swal_success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('swal_success') }}',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true,
                    background: '#FF7A28',
                    color: 'white'
                });
            @endif
        </script>
    @endpush

</x-admin.admin-layout>
