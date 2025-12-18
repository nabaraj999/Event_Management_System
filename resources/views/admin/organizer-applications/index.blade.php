<x-admin.admin-layout title="Organizer Applications">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white shadow-2xl rounded-2xl overflow-hidden">

            <!-- Header -->
            <div class="bg-darkBlue text-white px-6 sm:px-8 py-6">
                <h1 class="text-2xl sm:text-3xl font-bold">Organizer Applications</h1>
                <p class="mt-2 opacity-90 text-sm sm:text-base">
                    Review and manage new organizer requests
                </p>
            </div>

            @if(session('success'))
                <div class="mx-4 sm:mx-8 mt-6 bg-green-50 border-l-4 border-green-600 text-green-800 px-5 py-4 rounded-r-lg">
                    {{ session('success') }}
                </div>
            @endif

            <!-- ===================== -->
            <!-- MOBILE CARDS (sm only) -->
            <!-- ===================== -->
            <div class="md:hidden divide-y">
                @forelse($applications as $app)
                    <div class="p-5 space-y-3">
                        <div>
                            <p class="text-xs text-gray-500">Organization</p>
                            <p class="font-semibold text-darkBlue">
                                {{ $app->organization_name }}
                            </p>
                        </div>

                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-xs text-gray-500">Contact</p>
                                <p>{{ $app->contact_person }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Phone</p>
                                <p>{{ $app->phone }}</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs text-gray-500">Status</p>
                                @switch($app->status)
                                    @case('pending')
                                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                                        @break
                                    @case('approved')
                                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Approved</span>
                                        @break
                                    @case('rejected')
                                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">Rejected</span>
                                        @break
                                @endswitch
                            </div>

                            <a href="{{ route('admin.organizer-applications.show', $app) }}"
                               class="px-4 py-2 bg-darkBlue text-white rounded-lg text-sm font-medium">
                                View
                            </a>
                        </div>

                        <div class="text-xs text-gray-500">
                            @if($app->applied_at)
                                Applied on {{ $app->applied_at->format('d M Y, h:i A') }}
                            @else
                                Date not available
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 text-gray-500">
                        No organizer applications yet.
                    </div>
                @endforelse
            </div>

            <!-- ===================== -->
            <!-- DESKTOP TABLE (md+) -->
            <!-- ===================== -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs uppercase bg-gray-100 text-gray-600">
                        <tr>
                            <th class="px-6 py-4">#</th>
                            <th class="px-6 py-4">Organization</th>
                            <th class="px-6 py-4">Contact Person</th>
                            <th class="px-6 py-4">Phone</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4">Applied On</th>
                            <th class="px-6 py-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($applications as $index => $app)
                            <tr class="hover:bg-orange-50 transition">
                                <td class="px-6 py-5 font-medium">
                                    {{ $applications->firstItem() + $index }}
                                </td>
                                <td class="px-6 py-5 font-semibold text-darkBlue">
                                    {{ $app->organization_name }}
                                </td>
                                <td class="px-6 py-5">{{ $app->contact_person }}</td>
                                <td class="px-6 py-5">{{ $app->phone }}</td>
                                <td class="px-6 py-5 text-center">
                                    @switch($app->status)
                                        @case('pending')
                                            <span class="px-4 py-2 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                                            @break
                                        @case('approved')
                                            <span class="px-4 py-2 rounded-full text-xs font-medium bg-green-100 text-green-800">Approved</span>
                                            @break
                                        @case('rejected')
                                            <span class="px-4 py-2 rounded-full text-xs font-medium bg-red-100 text-red-800">Rejected</span>
                                            @break
                                    @endswitch
                                </td>
                                <td class="px-6 py-5 text-gray-600">
                                    {{ optional($app->applied_at)->format('d M Y, h:i A') ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <a href="{{ route('admin.organizer-applications.show', $app) }}"
                                       class="px-4 py-2 bg-darkBlue text-white rounded-lg hover:bg-[#052e5c] transition text-sm font-medium">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-12 text-gray-500 text-lg">
                                    No organizer applications yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="bg-gray-50 px-4 sm:px-6 py-4 border-t">
                {{ $applications->links('pagination::tailwind') }}
            </div>

        </div>
    </div>

</x-admin.admin-layout>
