<x-organizer.organizer-layout>

    <div class="py-8 px-4 max-w-6xl mx-auto">

        <div class="bg-darkBlue text-white rounded-2xl shadow-2xl p-10 mb-10">
            <a href="{{ route('org.settlements.index') }}"
               class="text-blue-200 hover:text-white transition flex items-center font-medium mb-4">
                ← Back to My Events
            </a>
            <h1 class="text-4xl font-bold mb-3">{{ $event->title }}</h1>
            <p class="text-xl text-blue-200">
                Revenue Report & Settlement Status
            </p>
        </div>

        <!-- Settlement Status -->
        @if($event->settlement?->settled_at)
            <div class="bg-green-50 border-4 border-green-600 rounded-2xl p-12 text-center mb-10">
                <h2 class="text-4xl font-bold text-green-800 mb-4">SETTLED</h2>
                <p class="text-2xl mb-6">
                    Net Amount Paid: <strong>Rs. {{ number_format($netIncome) }}</strong>
                </p>
                <p class="text-lg mb-8">
                    Settled on {{ $event->settlement->settled_at->format('d F Y') }}
                </p>
                <a href="{{ $event->settlement->settlementProofUrl }}" target="_blank"
                   class="inline-block px-12 py-6 bg-green-600 text-white font-bold text-xl rounded-2xl">
                    Download Payment Proof
                </a>
            </div>
        @else
            <div class="bg-yellow-50 border-4 border-yellow-600 rounded-2xl p-10 text-center mb-10">
                <h2 class="text-3xl font-bold text-yellow-800 mb-4">PENDING SETTLEMENT</h2>
                <p class="text-xl">Admin will process your payment soon</p>
                <p class="text-lg mt-4">Expected Net Income: <strong>Rs. {{ number_format($netIncome) }}</strong></p>
            </div>
        @endif

        <!-- Revenue Summary -->
        <div class="bg-white rounded-2xl shadow-2xl p-10">
            <h2 class="text-3xl font-bold text-darkBlue mb-8">Revenue Summary</h2>

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
                            <td colspan="4" class="text-center py-10 text-gray-500">No sales yet</td>
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
                    <span>Net Income:</span>
                    <strong>Rs. {{ number_format($netIncome) }}</strong>
                </p>
            </div>
        </div>
    </div>

</x-organizer.organizer-layout>
