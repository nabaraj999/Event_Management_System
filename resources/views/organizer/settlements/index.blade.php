<x-organizer.organizer-layout>

    <div class="py-8 px-4 max-w-7xl mx-auto">

        <div class="bg-darkBlue text-white rounded-2xl shadow-2xl p-10 mb-10">
            <h1 class="text-4xl font-bold mb-4">My Event Settlements</h1>
            <p class="text-xl text-blue-200">
                View revenue reports and settlement status for your events
            </p>
            <div class="mt-6">
                <span class="bg-orange-500/20 px-6 py-3 rounded-xl font-semibold text-lg">
                    16% EventHub Commission (All Inclusive)
                </span>
            </div>
        </div>

        @if($events->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($events as $event)
                    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden hover:shadow-orange-500/20 transition">
                        <div class="p-8">
                            <h3 class="text-2xl font-bold text-darkBlue mb-4">
                                <a href="{{ route('org.settlements.show', $event) }}" class="hover:text-primary transition">
                                    {{ $event->title }}
                                </a>
                            </h3>
                            <p class="text-gray-600 mb-6">
                                {{ $event->start_date->format('d M Y') }}
                                @if($event->end_date) – {{ $event->end_date->format('d M Y') }} @endif
                            </p>

                            @if($event->settlement?->settled_at)
                                <div class="bg-green-100 border-2 border-green-600 rounded-xl p-4 text-center">
                                    <p class="text-green-800 font-bold text-lg">SETTLED</p>
                                    <p class="text-sm text-gray-700 mt-2">
                                        {{ $event->settlement->settled_at->format('d M Y') }}
                                    </p>
                                    <a href="{{ $event->settlement->settlementProofUrl }}" target="_blank"
                                       class="inline-block mt-4 px-6 py-3 bg-green-600 text-white rounded-xl font-medium hover:bg-green-700 transition">
                                        View Proof
                                    </a>
                                </div>
                            @else
                                <div class="bg-yellow-100 border-2 border-yellow-600 rounded-xl p-4 text-center">
                                    <p class="text-yellow-800 font-bold text-lg">PENDING SETTLEMENT</p>
                                    <p class="text-sm text-gray-700 mt-2">Admin will settle soon</p>
                                </div>
                            @endif

                            <a href="{{ route('org.settlements.show', $event) }}"
                               class="block mt-6 text-center px-8 py-4 bg-primary text-white font-bold rounded-xl hover:bg-orange-600 transition">
                                View Details
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-20 bg-white rounded-2xl shadow-2xl">
                <p class="text-2xl font-medium text-gray-600">No events found</p>
                <a href="{{ route('org.events.create') }}" class="mt-6 inline-block px-8 py-4 bg-primary text-white rounded-xl">
                    Create Your First Event
                </a>
            </div>
        @endif
    </div>

</x-organizer.organizer-layout>
