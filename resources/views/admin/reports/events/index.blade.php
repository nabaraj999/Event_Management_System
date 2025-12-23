<x-admin.admin-layout>

    <div class="py-8 px-4 max-w-5xl mx-auto">

        <!-- Header -->
        <div class="bg-darkBlue text-white rounded-2xl shadow-2xl p-10 mb-10">
            <h1 class="text-4xl font-bold mb-4">Generate Event Revenue Report</h1>
            <p class="text-xl text-blue-200">
                Select any event to instantly generate a detailed financial report
            </p>
            <div class="mt-6 flex items-center gap-4 text-sm">
                <span class="bg-orange-500/20 px-6 py-3 rounded-xl font-semibold">16% EventHub Commission (All Inclusive)</span>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="p-10">
                <form action="{{ route('admin.reports.events.generate') }}" method="POST">
                    @csrf

                    <!-- Event Dropdown -->
                    <div class="mb-12">
                        <label for="event_id" class="block text-xl font-semibold text-gray-800 mb-4">
                            Select Event <span class="text-red-500">*</span>
                        </label>
                        <select id="event_id" name="event_id" required
                                class="w-full px-6 py-5 text-lg border-2 border-gray-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-primary/30 focus:border-primary transition duration-300">
                            <option value="">-- Choose an Event --</option>
                            @foreach($events as $event)
                                <option value="{{ $event->id }}">
                                    {{ $event->title }}
                                    @if($event->organizerApplication)
                                        ({{ $event->organizerApplication->contact_person ?? 'Unknown Contact' }})
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-3 text-sm text-gray-500">
                            {{ $events->count() }} total event{{ $events->count() == 1 ? '' : 's' }} available
                        </p>
                    </div>

                    <!-- Generate Button -->
                    <div class="flex justify-end">
                        <button type="submit"
                                class="px-16 py-6 bg-primary hover:bg-orange-600 text-white font-bold text-2xl rounded-2xl shadow-2xl hover:shadow-orange-500/50 transition duration-300 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                                {{ $events->isEmpty() ? 'disabled' : '' }}>
                            Generate PDF Report
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endpush

</x-admin.admin-layout>
