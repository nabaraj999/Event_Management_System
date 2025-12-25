<x-organizer.organizer-layout>

<div class="max-w-7xl mx-auto px-4 lg:px-8 py-10 space-y-10">

    <div class="text-center bg-white rounded-2xl p-6 shadow">
        <h1 class="text-3xl lg:text-4xl font-extrabold text-darkBlue mb-2">Insights & Recommendations</h1>
        <p class="text-gray-600">Performance driven guidance for smarter events</p>
    </div>

    @if(!$has_events)
    <!-- New Organizer -->
    <div class="bg-gradient-to-br from-primary to-darkBlue text-white rounded-3xl p-8 shadow-xl">
        <h2 class="text-2xl font-bold mb-4">Welcome {{ $organizer_name }}</h2>
        <p class="opacity-90 mb-6">Start with proven high-conversion event types</p>

        <div class="grid md:grid-cols-2 gap-6 text-sm">
            <ul class="space-y-3">
                <li>🎵 Music & Festivals</li>
                <li>💒 Weddings</li>
                <li>💼 Corporate Programs</li>
                <li>🎂 Parties & Social Events</li>
            </ul>
            <ol class="space-y-3">
                <li>3 Tier tickets (Early / Normal / VIP)</li>
                <li>Limit VIP quantity</li>
                <li>Hybrid live streaming</li>
                <li>Early bird discounts</li>
                <li>Pre-launch promotion (4 weeks)</li>
            </ol>
        </div>

        <div class="mt-6 bg-white/20 p-4 rounded-xl text-center font-semibold">
            Expected First Event Revenue: Rs. 500,000+
        </div>
    </div>
    @else

    <!-- KPI Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">

        <div class="bg-white rounded-2xl p-6 shadow text-center">
            <p class="text-sm text-gray-500 mb-1">Revenue</p>
            <p class="text-2xl font-extrabold text-primary">Rs. {{ number_format($total_revenue) }}</p>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow text-center">
            <p class="text-sm text-gray-500 mb-1">Bookings</p>
            <p class="text-2xl font-extrabold text-darkBlue">{{ $total_bookings }}</p>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow text-center">
            <p class="text-sm text-gray-500 mb-1">Tickets Sold</p>
            <p class="text-2xl font-extrabold text-primary">{{ $total_tickets_sold }}</p>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow text-center">
            <p class="text-sm text-gray-500 mb-1">Avg Ticket</p>
            <p class="text-2xl font-extrabold text-darkBlue">Rs. {{ number_format($avg_ticket_price,0) }}</p>
        </div>

    </div>

    <div class="grid lg:grid-cols-2 gap-8">

        <!-- Categories -->
        <div class="bg-white rounded-2xl p-6 shadow">
            <h3 class="font-bold text-lg mb-4">Top Categories</h3>

            @forelse($top_categories as $cat)
            <div class="flex justify-between items-center py-3 border-b last:border-0">
                <span>{{ $cat->category?->name ?? 'Uncategorized' }}</span>
                <span class="font-semibold text-primary">Rs. {{ number_format($cat->revenue ?? 0) }}</span>
            </div>
            @empty
            <p class="text-gray-500 text-sm text-center py-6">No revenue data yet</p>
            @endforelse
        </div>

        <!-- Interests -->
        <div class="bg-white rounded-2xl p-6 shadow">
            <h3 class="font-bold text-lg mb-4">Audience Interests</h3>

            <div class="flex flex-wrap gap-3">
                @forelse($top_interests as $interest)
                    <span class="bg-primary/10 text-primary px-4 py-2 rounded-full text-sm font-semibold">
                        {{ ucfirst($interest) }}
                    </span>
                @empty
                    <p class="text-gray-500 text-sm">No interest data yet</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Mentor Section -->
    <div class="bg-darkBlue text-white rounded-3xl p-8 shadow-xl">
    <h2 class="text-2xl font-bold mb-4">Your Growth Direction</h2>

    @if($top_categories->count() && $top_categories->first()->revenue > 0)

        <p class="opacity-90 mb-4">
            Your highest-converting category is
            <strong>{{ $top_categories->first()->category?->name }}</strong>.
            This category outperforms the rest — focus here.
        </p>

        <ul class="space-y-2 text-sm">
            <li>Increase ticket price by 10–15%.</li>
            <li>Add limited VIP tickets (20–30% of seats).</li>
            <li>Run Early Bird sales for 7 days only.</li>
            <li>Advertise only this category.</li>
            <li>Bundle tickets with merchandise.</li>
        </ul>

    @elseif($total_bookings > 0)

        <p class="opacity-90 mb-4">
            Your bookings are scattered — your brand positioning is unclear.
        </p>

        <ul class="space-y-2 text-sm">
            <li>Choose one category and focus for 60 days.</li>
            <li>Use consistent banners and branding.</li>
            <li>Create 3 pricing tiers (Early / Regular / VIP).</li>
            <li>Limit VIP quantity to increase urgency.</li>
            <li>Start promotion 28+ days before event.</li>
        </ul>

    @else

        <p class="opacity-90 mb-4">
            New organizers fail by launching random events without strategy.
        </p>

        <ul class="space-y-2 text-sm">
            <li>Start with Music or Wedding events.</li>
            <li>Do not underprice — cheap kills trust.</li>
            <li>Offer Early Bird for first 50 seats.</li>
            <li>Open bookings 30 days before event date.</li>
            <li>Post daily social media teasers for 14 days.</li>
        </ul>

    @endif
</div>

    @endif
</div>

</x-organizer.organizer-layout>
