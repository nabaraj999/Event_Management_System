<x-admin.admin-layout>

<div class="py-8 px-4 max-w-5xl mx-auto">
    <!-- Header -->
    <div class="bg-darkBlue text-white rounded-2xl shadow-xl p-8 mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold">User Details: {{ $user->name }}</h1>
                <p class="text-blue-200 mt-1">ID: {{ $user->id }} | Joined: {{ $user->created_at->format('d M Y') }}</p>
            </div>
            <a href="{{ route('admin.users.index') }}"
               class="px-6 py-3 bg-white/20 hover:bg-white/30 rounded-xl transition">
                ← Back to Users
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- User Info Card -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <div class="text-center mb-6">
                    <div class="w-32 h-32 mx-auto bg-primary/20 rounded-full flex items-center justify-center text-5xl font-bold text-primary">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                    <h2 class="text-2xl font-bold mt-4">{{ $user->name }}</h2>
                    <p class="text-gray-600">{{ $user->email }}</p>
                </div>

                <div class="space-y-4 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Email Verified:</span>
                        <span class="{{ $user->email_verified_at ? 'text-green-600' : 'text-red-600' }} font-medium">
                            {{ $user->email_verified_at ? 'Yes' : 'No' }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Interests:</span>
                        <span class="font-medium">{{ $user->interests->count() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Account Created:</span>
                        <span class="font-medium">{{ $user->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Interests Table -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <h3 class="text-xl font-bold text-gray-800 mb-6">User Interests</h3>

                @if($user->interests->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Interest</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Category</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Completed/Skipped</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Added On</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($user->interests as $interest)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-4 text-sm font-medium capitalize">{{ $interest->interest }}</td>
                                        <td class="px-4 py-4 text-sm text-gray-600">
                                            {{ $interest->category?->name ?? '<em class="text-gray-400">None</em>' }}
                                        </td>
                                        <td class="px-4 py-4 text-sm">
                                            @if($interest->has_completed_or_skipped_interests)
                                                <span class="text-green-600 font-medium">Yes</span>
                                            @else
                                                <span class="text-orange-600 font-medium">No</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 text-sm text-gray-500">
                                            {{ $interest->created_at->format('d M Y') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">This user has not added any interests yet.</p>
                @endif
            </div>
        </div>
    </div>
</div>

</x-admin.admin-layout>