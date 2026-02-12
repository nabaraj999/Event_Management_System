<x-organizer.organizer-layout title="My Event Settlements">

    <div class="py-6 px-4 max-w-7xl mx-auto">

        <!-- Header -->
        <div class="bg-[#063970] text-white rounded-xl shadow-md p-6 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold">My Event Settlements</h1>
                    <p class="text-blue-100 text-sm mt-1 opacity-90">
                        View revenue reports and settlement status for your events
                    </p>
                </div>
            </div>

            <!-- Commission Info -->
            <div class="mt-4">
                <span class="inline-block px-4 py-2 bg-white/20 rounded-lg text-sm font-medium">
                    16% EventHub Commission (All Inclusive)
                </span>
            </div>
        </div>

        <!-- Events Grid / Empty State -->
        @if($events->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($events as $event)
                    <div class="bg-white rounded-xl shadow border border-gray-200 overflow-hidden hover:shadow-md transition">
                        <div class="p-6">

                            <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                <a href="{{ route('org.settlements.show', $event) }}" class="hover:text-[#FF7A28] transition">
                                    {{ Str::limit($event->title, 60) }}
                                </a>
                            </h3>

                            <div class="text-xs text-gray-600 mb-4">
                                {{ $event->start_date->format('d M Y') }}
                                @if($event->end_date) – {{ $event->end_date->format('d M Y') }} @endif
                            </div>

                            @if($event->settlement?->settled_at)
                                <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center mb-4">
                                    <p class="text-green-700 font-medium text-base">SETTLED</p>
                                    <p class="text-xs text-gray-600 mt-1">
                                        {{ $event->settlement->settled_at->format('d M Y') }}
                                    </p>
                                    @if($event->settlement->settlementProofUrl)
                                        <a href="{{ $event->settlement->settlementProofUrl }}" target="_blank"
                                           class="inline-block mt-3 text-xs text-green-700 hover:text-green-900 underline">
                                            View Proof →
                                        </a>
                                    @endif
                                </div>
                            @else
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-center mb-4">
                                    <p class="text-yellow-700 font-medium text-base">PENDING SETTLEMENT</p>
                                    <p class="text-xs text-gray-600 mt-1">Admin will settle soon</p>
                                </div>
                            @endif

                            <a href="{{ route('org.settlements.show', $event) }}"
                               class="block text-center px-6 py-3 bg-[#FF7A28] hover:bg-[#FF7A28]/90 text-white font-medium rounded-lg transition text-sm">
                                View Details
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-xl shadow border border-gray-200 text-center py-16">
                <p class="text-base font-medium text-gray-600">No events found</p>
                <p class="text-sm text-gray-500 mt-2">Create events to start seeing settlements here</p>
                <a href="{{ route('org.events.create') }}"
                   class="mt-6 inline-block px-8 py-3 bg-[#FF7A28] hover:bg-[#FF7A28]/90 text-white rounded-lg font-medium transition text-sm">
                    Create Your First Event
                </a>
            </div>
        @endif
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            @if (session('swal_success') || session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('swal_success') ?? session('success') }}',
                    confirmButtonColor: '#FF7A28',
                    timer: 3200,
                    timerProgressBar: true
                });
            @endif
        </script>
    @endpush

</x-organizer.organizer-layout>
