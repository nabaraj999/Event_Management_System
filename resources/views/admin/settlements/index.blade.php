<x-admin.admin-layout>

    <div class="py-8 px-4 max-w-5xl mx-auto">

        <div class="bg-darkBlue text-white rounded-2xl shadow-2xl p-10 mb-10">
            <h1 class="text-4xl font-bold mb-4">Event Settlements</h1>
            <p class="text-xl text-blue-200">Select any event to view payment details and mark as settled</p>
            <div class="mt-6">
                <span class="bg-orange-500/20 px-6 py-3 rounded-xl font-semibold text-lg">
                    16% EventHub Commission (All Inclusive)
                </span>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="p-10">
                <form action="{{ route('admin.settlements.show') }}" method="GET">
                    <div class="mb-12">
                        <label for="event_id" class="block text-xl font-semibold text-gray-800 mb-4">
                            Select Event <span class="text-red-500">*</span>
                        </label>
                        <select name="event_id" id="event_id" required
                                class="w-full px-6 py-5 text-lg border-2 border-gray-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-primary/30 focus:border-primary transition">
                            <option value="">-- Choose an Event --</option>
                            @foreach($events as $event)
                                <option value="{{ $event->id }}" {{ request('event_id') == $event->id ? 'selected' : '' }}>
                                    {{ $event->title }}
                                    @if($event->organizerApplication)
                                        ({{ $event->organizerApplication->contact_person ?? 'Unknown' }})
                                    @endif
                                    @if($event->settlement?->settled_at)
                                        <span class="text-green-600 font-bold"> [Settled]</span>
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-3 text-sm text-gray-500">
                            {{ $events->count() }} total event{{ $events->count() == 1 ? '' : 's' }} available
                        </p>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                                class="px-16 py-6 bg-primary hover:bg-orange-600 text-white font-bold text-2xl rounded-2xl shadow-2xl hover:shadow-orange-500/50 transition duration-300">
                            View Settlement Details
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-admin.admin-layout>
