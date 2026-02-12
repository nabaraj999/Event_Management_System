<x-admin.admin-layout title="Event Settlements">

    <div class="py-6 px-4 max-w-7xl mx-auto">

        <!-- Header -->
        <div class="bg-[#063970] text-white rounded-xl shadow-md p-6 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold">Event Settlements</h1>
                    <p class="text-blue-100 text-sm mt-1 opacity-90">Select an event to view payment details and mark as settled</p>
                </div>
            </div>

            <!-- Commission Info -->
            <div class="mt-4">
                <span class="inline-block px-4 py-2 bg-white/20 rounded-lg text-sm font-medium">
                    16% EventHub Commission (All Inclusive)
                </span>
            </div>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-xl shadow border border-gray-200 overflow-hidden">

            <div class="p-6 lg:p-8">

                <form action="{{ route('admin.settlements.show') }}" method="GET">
                    <div class="mb-8">
                        <label for="event_id" class="block text-base font-semibold text-gray-800 mb-2">
                            Select Event <span class="text-red-600">*</span>
                        </label>
                        <select name="event_id" id="event_id" required
                                class="w-full px-5 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-[#FF7A28] focus:ring-2 focus:ring-[#FF7A28]/30 text-base transition">
                            <option value="">-- Choose an Event --</option>
                            @foreach($events as $event)
                                <option value="{{ $event->id }}" {{ request('event_id') == $event->id ? 'selected' : '' }}>
                                    {{ $event->title }}
                                    @if($event->organizerApplication)
                                        ({{ $event->organizerApplication->contact_person ?? 'Unknown' }})
                                    @endif
                                    @if($event->settlement?->settled_at)
                                        <span class="text-green-600 font-medium"> [Settled]</span>
                                    @endif
                                </option>
                            @endforeach
                        </select>

                        <p class="mt-2 text-sm text-gray-500">
                            {{ $events->count() }} total event{{ $events->count() == 1 ? '' : 's' }} available
                        </p>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                                class="px-8 py-3 bg-[#FF7A28] hover:bg-[#FF7A28]/90 text-white font-medium rounded-lg transition shadow-sm text-base">
                            View Settlement Details
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#FF7A28',
                    timer: 3200,
                    timerProgressBar: true
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#FF7A28'
                });
            @endif
        </script>
    @endpush

</x-admin.admin-layout>
