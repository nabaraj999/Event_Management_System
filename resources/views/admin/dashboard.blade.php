<x-admin.admin-layout >
<div class="space-y-8">

    <!-- Welcome Hero -->
    <div class="bg-gradient-to-r from-darkBlue via-primary to-orange-600 rounded-2xl p-8 text-white shadow-2xl relative overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-30"></div>
        <div class="relative z-10">
            <h1 class="text-4xl md:text-5xl font-bold mb-3">
                Welcome back, {{ Auth::guard('admin')->user()->name ?? 'Admin' }}!
            </h1>
            <p class="text-xl opacity-90">Here's what's happening in EventHub today</p>
            <p class="text-sm mt-4 opacity-80">{{ now()->format('l, d F Y') }}</p>
        </div>
        <div class="absolute -bottom-16 -right-16 w-56 h-56 bg-white opacity-10 rounded-full blur-3xl"></div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Events -->
        <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100 hover:shadow-2xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-semibold uppercase tracking-wider">Total Events</p>
                    <p class="text-4xl font-bold text-darkBlue mt-3">1,842</p>
                    <p class="text-green-600 text-sm font-medium mt-2 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        +18% from last month
                    </p>
                </div>
                <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center">
                    <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3M5 11h14M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Pending Events -->
        <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100 hover:shadow-2xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-semibold uppercase tracking-wider">Pending Events</p>
                    <p class="text-4xl font-bold text-orange-600 mt-3">37</p>
                    <p class="text-orange-600 text-sm font-medium mt-2">Requires review</p>
                </div>
                <div class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center">
                    <svg class="w-10 h-10 text-orange-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100 hover:shadow-2xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-semibold uppercase tracking-wider">Total Users</p>
                    <p class="text-4xl font-bold text-darkBlue mt-3">12,485</p>
                    <p class="text-green-600 text-sm font-medium mt-2 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        +9.2% this week
                    </p>
                </div>
                <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center">
                    <svg class="w-10 h-10 text-darkBlue" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Revenue -->
        <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100 hover:shadow-2xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-semibold uppercase tracking-wider">Total Revenue</p>
                    <p class="text-4xl font-bold text-green-600 mt-3">$68,920</p>
                    <p class="text-green-600 text-sm font-medium mt-2 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        +23% from last month
                    </p>
                </div>
                <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center">
                    <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Events + Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Events -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-darkBlue/5 to-primary/5">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-darkBlue">Recent Events</h2>
                    <a href="#" class="text-primary hover:underline text-sm font-medium">View all →</a>
                </div>
            </div>
            <div class="divide-y divide-gray-100">
                @php
                    $events = [
                        ['title' => 'Tech Innovation Summit 2025', 'organizer' => 'Google Inc.', 'status' => 'Approved'],
                        ['title' => 'Laravel Conference Asia', 'organizer' => 'Laravel Team', 'status' => 'Pending'],
                        ['title' => 'Music Festival 2025', 'organizer' => 'LiveNation', 'status' => 'Approved'],
                        ['title' => 'AI & Future Tech Expo', 'organizer' => 'Microsoft', 'status' => 'Approved'],
                        ['title' => 'Startup Pitch Night', 'organizer' => 'Y Combinator', 'status' => 'Pending'],
                    ];
                @endphp
                @foreach($events as $event)
                <div class="p-6 hover:bg-gray-50 transition">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center">
                                <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3M5 11h14M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900">{{ $event['title'] }}</h3>
                                <p class="text-sm text-gray-600">{{ $event['organizer'] }}</p>
                            </div>
                        </div>
                        <span class="px-4 py-2 text-xs font-bold rounded-full
                            {{ $event['status'] === 'Approved' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' }}">
                            {{ $event['status'] }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-gradient-to-br from-darkBlue to-primary rounded-2xl shadow-2xl p-8 text-white relative overflow-hidden">
            <div class="absolute inset-0 bg-black opacity-40"></div>
            <div class="relative z-10">
                <h2 class="text-2xl font-bold mb-8">Quick Actions</h2>
                <div class="space-y-6">
                    <a href="#" class="block bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-xl p-6 transition-all transform hover:scale-105">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-bold text-xl">Review Pending Events</p>
                                <p class="text-white/80 text-sm mt-2">37 events waiting for approval</p>
                            </div>
                            <svg class="w-8 h-8 opacity-70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </a>
                    <a href="#" class="block bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-xl p-6 transition-all transform hover:scale-105">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-bold text-xl">Generate Report</p>
                                <p class="text-white/80 text-sm mt-2">Monthly revenue & stats</p>
                            </div>
                            <svg class="w-8 h-8 opacity-70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </a>
                    <a href="#" class="block bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-xl p-6 transition-all transform hover:scale-105">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-bold text-xl">Manage Categories</p>
                                <p class="text-white/80 text-sm mt-2">Add or edit event types</p>
                            </div>
                            <svg class="w-8 h-8 opacity-70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

</x-admin.admin-layout >
