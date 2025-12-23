{{-- resources/views/admin/settlements/show.blade.php --}}

<x-admin.admin-layout>

    <div class="py-8 px-4 max-w-6xl mx-auto">

        <!-- Header -->
        <div class="bg-darkBlue text-white rounded-2xl shadow-2xl p-10 mb-10">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                <div>
                    <a href="{{ route('admin.settlements.index') }}"
                       class="text-blue-200 hover:text-white transition flex items-center font-medium mb-4">
                        ← Back to Settlements
                    </a>
                    <h1 class="text-4xl font-bold mb-3">
                        Settlement for: {{ $event->title }}
                    </h1>
                    <p class="text-xl text-blue-200">
                        Organizer: <strong>{{ $organizer->contact_person ?? 'Unknown Contact' }}</strong>
                        @if($organizer->organization_name)
                            ({{ $organizer->organization_name }})
                        @endif
                    </p>
                </div>
                <div class="text-right">
                    <p class="text-lg">Event Date:</p>
                    <p class="text-2xl font-bold">
                        {{ $event->start_date->format('d M Y') }}
                        @if($event->end_date)
                            – {{ $event->end_date->format('d M Y') }}
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-8 p-6 bg-green-100 border-2 border-green-600 text-green-800 rounded-2xl shadow-lg text-center">
                <p class="text-xl font-bold">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Already Settled -->
        @if($settlement?->settled_at)
            <div class="bg-green-50 border-4 border-green-600 rounded-2xl p-12 text-center mb-10">
                <svg class="mx-auto h-24 w-24 text-green-600 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h2 class="text-4xl font-bold text-green-800 mb-4">SETTLED</h2>
                <p class="text-2xl mb-6">
                    Settlement Invoice ID: <strong>{{ $settlement->settlement_invoice_id }}</strong>
                </p>
                <p class="text-lg text-gray-700 mb-8">
                    Settled on {{ $settlement->settled_at->format('d F Y \a\t h:i A') }}
                    @if($settlement->notes)
                        <br><em>"{{ $settlement->notes }}"</em>
                    @endif
                </p>
                <a href="{{ $settlement->settlementProofUrl }}" target="_blank"
                   class="inline-block px-12 py-6 bg-green-600 hover:bg-green-700 text-white font-bold text-xl rounded-2xl shadow-2xl transition">
                    Download Settlement Proof (PDF)
                </a>
            </div>
        @else
            <!-- Pending Settlement -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

                <!-- Payment Summary -->
                <div class="bg-white rounded-2xl shadow-2xl p-10">
                    <h2 class="text-3xl font-bold text-darkBlue mb-8">Payment Summary</h2>

                    <table class="w-full mb-8">
                        <thead>
                            <tr class="border-b-2 border-gray-200">
                                <th class="text-left py-4">Ticket Type</th>
                                <th class="text-right py-4">Price</th>
                                <th class="text-right py-4">Sold</th>
                                <th class="text-right py-4">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ticketSales as $sale)
                                <tr class="border-b border-gray-100">
                                    <td class="py-4 font-medium">{{ $sale['name'] }}</td>
                                    <td class="text-right">Rs. {{ number_format($sale['price']) }}</td>
                                    <td class="text-right">{{ $sale['sold'] }}</td>
                                    <td class="text-right font-semibold">Rs. {{ number_format($sale['subtotal']) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-10 text-gray-500">
                                        No ticket sales recorded
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="border-t-4 border-primary pt-6 text-xl">
                        <p class="flex justify-between mb-4">
                            <span>Gross Revenue:</span>
                            <strong>Rs. {{ number_format($totalGross) }}</strong>
                        </p>
                        <p class="flex justify-between mb-6">
                            <span>EventHub Commission (16%):</span>
                            <strong class="text-red-600">- Rs. {{ number_format($commission) }}</strong>
                        </p>
                        <p class="flex justify-between text-3xl font-bold text-green-600">
                            <span>Net Payable to Organizer:</span>
                            <strong>Rs. {{ number_format($netPayable) }}</strong>
                        </p>
                    </div>
                </div>

                <!-- Mark as Settled Form -->
                <div class="bg-white rounded-2xl shadow-2xl p-10">
                    <h2 class="text-3xl font-bold text-darkBlue mb-8">Mark as Settled</h2>

                    <form action="{{ route('admin.settlements.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="event_id" value="{{ $event->id }}">

                        <div class="mb-8">
                            <label class="block text-lg font-medium text-gray-700 mb-3">
                                Settlement Invoice / Reference ID <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="settlement_invoice_id" required placeholder="e.g., BANK-2025-001"
                                   class="w-full px-6 py-5 border-2 border-gray-200 rounded-2xl focus:ring-4 focus:ring-primary/30 focus:border-primary transition text-lg">
                        </div>

                        <div class="mb-8">
                            <label class="block text-lg font-medium text-gray-700 mb-3">
                                Upload Settlement Proof (PDF) <span class="text-red-500">*</span>
                            </label>
                            <input type="file" name="settlement_proof" accept=".pdf" required
                                   class="w-full px-6 py-5 border-2 border-gray-200 rounded-2xl file:mr-6 file:py-4 file:px-8 file:rounded-xl file:bg-primary file:text-white file:hover:bg-orange-600 cursor-pointer">
                            <p class="mt-3 text-sm text-gray-500">Bank transfer receipt, screenshot, etc.</p>
                        </div>

                        <div class="mb-10">
                            <label class="block text-lg font-medium text-gray-700 mb-3">
                                Notes (Optional)
                            </label>
                            <textarea name="notes" rows="5" placeholder="Any additional information..."
                                      class="w-full px-6 py-5 border-2 border-gray-200 rounded-2xl focus:ring-4 focus:ring-primary/30 focus:border-primary transition"></textarea>
                        </div>

                        <div class="text-center">
                            <button type="submit"
                                    class="px-20 py-7 bg-green-600 hover:bg-green-700 text-white font-bold text-2xl rounded-2xl shadow-2xl hover:shadow-green-500/50 transition duration-300 transform hover:scale-105">
                                Complete Settlement
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endpush

</x-admin.admin-layout>
