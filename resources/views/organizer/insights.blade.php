<x-organizer.organizer-layout>
    <x-slot:title>Insights & Recommendations</x-slot:title>

    <div class="max-w-7xl mx-auto px-4 lg:px-8 py-10 space-y-10">

        <!-- Header -->
        <div class="text-center bg-white rounded-2xl p-6 shadow">
            <h1 class="text-3xl lg:text-4xl font-extrabold text-darkBlue mb-2 font-raleway">
                Insights & Recommendations
            </h1>
            <p class="text-gray-600">Performance-driven guidance to help you organize smarter, higher-converting events</p>
        </div>

        @if(!$has_events)
            <!-- New Organizer Welcome -->
            <div class="bg-gradient-to-br from-primary to-darkBlue text-white rounded-3xl p-8 shadow-xl">
                <h2 class="text-2xl font-bold mb-4">Welcome, {{ $organizer_name ?? 'Organizer' }}!</h2>
                <p class="opacity-90 mb-6">Start strong with proven high-conversion event types</p>

                <div class="grid md:grid-cols-2 gap-8 text-sm">
                    <div>
                        <h4 class="font-semibold mb-3">Popular & Profitable Event Types</h4>
                        <ul class="space-y-2 list-disc list-inside">
                            <li>Music Concerts & Festivals</li>
                            <li>Weddings & Receptions</li>
                            <li>Corporate Workshops & Seminars</li>
                            <li>Birthday Parties & Social Gatherings</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-3">Proven Success Tactics</h4>
                        <ol class="space-y-2 list-decimal list-inside">
                            <li>Use 3-tier pricing (Early Bird / Regular / VIP)</li>
                            <li>Limit VIP tickets to 20–30% of capacity</li>
                            <li>Offer hybrid (live + streaming) option</li>
                            <li>Run Early Bird discounts for first 7–10 days</li>
                            <li>Start promotion 4+ weeks in advance</li>
                        </ol>
                    </div>
                </div>

                <div class="mt-8 bg-white/20 backdrop-blur-sm p-5 rounded-2xl text-center font-semibold text-lg">
                    Realistic First Event Revenue Potential: Rs. 500,000 – 1,200,000+
                </div>

                <div class="mt-6 text-center">
                    <a href="{{ route('organizer.events.create') }}"
                       class="inline-block px-8 py-4 bg-white text-darkBlue font-bold rounded-xl hover:bg-gray-100 transition">
                        Create Your First Event →
                    </a>
                </div>
            </div>

        @else
            <!-- KPI Cards -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-5 lg:gap-6">

                <div class="bg-white rounded-2xl p-6 shadow text-center border border-gray-100">
                    <p class="text-sm text-gray-500 mb-1">Total Revenue</p>
                    <p class="text-2xl lg:text-3xl font-extrabold text-primary">
                        Rs. {{ number_format($total_revenue) }}
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow text-center border border-gray-100">
                    <p class="text-sm text-gray-500 mb-1">Total Bookings</p>
                    <p class="text-2xl lg:text-3xl font-extrabold text-darkBlue">
                        {{ number_format($total_bookings) }}
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow text-center border border-gray-100">
                    <p class="text-sm text-gray-500 mb-1">Tickets Sold</p>
                    <p class="text-2xl lg:text-3xl font-extrabold text-primary">
                        {{ number_format($total_tickets_sold) }}
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow text-center border border-gray-100">
                    <p class="text-sm text-gray-500 mb-1">Avg Ticket Price</p>
                    <p class="text-2xl lg:text-3xl font-extrabold text-darkBlue">
                        Rs. {{ number_format($avg_ticket_price, 0) }}
                    </p>
                </div>
            </div>

            <!-- Advanced Insights (only if algorithm enabled) -->
            @if($algorithm_enabled ?? false)
                <div class="grid lg:grid-cols-2 gap-8">

                    <!-- Top Categories -->
                    <div class="bg-white rounded-2xl p-6 shadow border border-gray-100">
                        <h3 class="font-bold text-lg mb-5 text-darkBlue">Top Performing Categories</h3>

                        @forelse($top_categories as $cat)
                            <div class="flex justify-between items-center py-3.5 border-b last:border-0">
                                <span class="font-medium">{{ $cat->category?->name ?? 'Uncategorized' }}</span>
                                <span class="font-semibold text-primary">
                                    Rs. {{ number_format($cat->revenue ?? 0) }}
                                </span>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-10">No paid bookings recorded yet</p>
                        @endforelse
                    </div>

                    <!-- Audience Interests -->
                    <div class="bg-white rounded-2xl p-6 shadow border border-gray-100">
                        <h3 class="font-bold text-lg mb-5 text-darkBlue">Top Audience Interests</h3>

                        <div class="flex flex-wrap gap-3">
                            @forelse($top_interests as $interest)
                                <span class="bg-primary/10 text-primary px-5 py-2.5 rounded-full text-sm font-medium">
                                    {{ ucfirst($interest) }}
                                </span>
                            @empty
                                <p class="text-gray-500 text-center w-full py-10">Insufficient booking data to analyze interests</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-gray-50 border border-gray-200 rounded-2xl p-8 text-center">
                    <h3 class="text-xl font-semibold text-darkBlue mb-3">Advanced Insights Disabled</h3>
                    <p class="text-gray-600 mb-4">
                        Detailed category performance and audience interest analysis are turned off in global settings.
                    </p>
                    <p class="text-sm text-gray-500">
                        You can still see basic revenue & booking stats above.
                    </p>
                </div>
            @endif

            <!-- Mentor / Growth Advice Section -->
            <div class="bg-darkBlue text-white rounded-3xl p-8 lg:p-10 shadow-xl">
                <h2 class="text-2xl lg:text-3xl font-bold mb-6">Your Recommended Growth Path</h2>

                @if($algorithm_enabled ?? false && $top_categories->isNotEmpty() && $top_categories->first()->revenue > 0)
                    <p class="opacity-90 mb-5 text-lg">
                        Your strongest category right now is
                        <strong class="text-primary">{{ $top_categories->first()->category?->name ?? 'your top performer' }}</strong>.
                        Double down here for fastest growth.
                    </p>

                    <ul class="space-y-3 text-base list-disc list-inside pl-5 opacity-90">
                        <li>Increase average ticket price by 10–20%</li>
                        <li>Introduce limited VIP / premium tickets (20–30% of total capacity)</li>
                        <li>Run short Early Bird windows (5–10 days max)</li>
                        <li>Focus 80% of your marketing budget on this category</li>
                        <li>Offer ticket bundles (ticket + merchandise / food voucher)</li>
                    </ul>

                @elseif($total_bookings > 0)
                    <p class="opacity-90 mb-5 text-lg">
                        Your bookings are spread across categories — your brand message might be too broad.
                    </p>

                    <ul class="space-y-3 text-base list-disc list-inside pl-5 opacity-90">
                        <li>Pick **one** category and commit to it for the next 2–3 months</li>
                        <li>Use consistent visuals, colors and messaging across all channels</li>
                        <li>Implement clear 3-tier pricing structure</li>
                        <li>Create urgency with limited VIP / early bird quantities</li>
                        <li>Start promotion 4–6 weeks before each event</li>
                    </ul>

                @else
                    <p class="opacity-90 mb-5 text-lg">
                        Most new organizers lose money by launching without clear strategy.
                    </p>

                    <ul class="space-y-3 text-base list-disc list-inside pl-5 opacity-90">
                        <li>Begin with high-demand types: Music, Wedding or Corporate events</li>
                        <li>Avoid underpricing — low prices reduce perceived value</li>
                        <li>Offer Early Bird for the first 30–50 tickets only</li>
                        <li>Open ticket sales 30–45 days before the event</li>
                        <li>Post daily teasers on social media starting 2–3 weeks early</li>
                    </ul>
                @endif
            </div>
        @endif
    </div>
</x-organizer.organizer-layout>
