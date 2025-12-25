<x-admin.admin-layout>
    <div class="py-8 px-4 max-w-7xl mx-auto">
        <!-- Header -->
        <div class="bg-darkBlue text-white rounded-2xl shadow-xl p-8 mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                <div>
                    <h1 class="text-3xl font-bold">SEO Management</h1>
                    <p class="text-blue-200 mt-1">Control meta tags, Open Graph, and SEO settings for all pages</p>
                </div>
                <div class="flex gap-3">
                    <form method="GET" class="flex gap-2">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search by page key..."
                            class="px-5 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-blue-200 focus:outline-none focus:ring-2 focus:ring-orange-400 w-64">
                        <button type="submit"
                            class="px-6 py-3 bg-primary hover:bg-orange-600 text-white rounded-xl font-medium transition shadow">Search</button>
                    </form>
                    <a href="{{ route('admin.seo.create') }}"
                        class="px-8 py-3 bg-primary hover:bg-orange-600 text-white rounded-xl font-medium transition shadow-lg">
                        New
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
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700">Page Key</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600">Meta Title</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600">Description</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600">Keywords</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($seoPages as $seo)
                            <tr class="hover:bg-orange-50 transition">
                                <td class="px-6 py-5 text-center text-gray-600 font-medium">
                                    {{ $loop->iteration + ($seoPages->currentPage() - 1) * $seoPages->perPage() }}
                                </td>
                                <td class="px-6 py-5">
                                    <div class="font-bold text-darkBlue text-lg">
                                        {{ ucfirst(str_replace(['.', '_'], ' ', $seo->page_key)) }}
                                    </div>
                                    <div class="text-sm text-gray-500">Route: <code
                                            class="bg-gray-100 px-2 py-1 rounded">{{ $seo->page_key }}</code></div>
                                </td>
                                <td class="px-6 py-5 font-medium text-gray-900">
                                    {{ Str::limit($seo->meta_title, 10) }}
                                </td>
                                <td class="px-6 py-5 text-sm text-gray-600 max-w-xs">
                                    {{ $seo->meta_description ? Str::limit($seo->meta_description, 10) : '— No description —' }}
                                </td>
                                <td class="px-6 py-5 text-sm text-gray-600">
                                    {{ $seo->meta_keywords ? Str::limit($seo->meta_keywords, 10) : '— No keywords —' }}
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <span
                                        class="px-4 py-1.5 rounded-full text-xs font-medium {{ $seo->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $seo->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <a href="{{ route('admin.seo.edit', $seo) }}"
                                        class="px-5 py-2.5 rounded-lg bg-darkBlue text-white font-medium shadow-sm hover:bg-blue-700 transition">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-20 text-gray-500">
                                    <p class="text-2xl font-medium">No SEO pages found</p>
                                    <a href="{{ route('admin.seo.create') }}"
                                        class="mt-6 inline-block px-8 py-3 bg-primary hover:bg-orange-600 text-white rounded-xl font-medium shadow-lg">
                                        Add Your First SEO Page →
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-5 bg-gray-50 border-t text-center">
                {{ $seoPages->links() }}
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
    </div>
</x-admin.admin-layout>
