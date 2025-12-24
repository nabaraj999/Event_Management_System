<x-organizer.organizer-layout>

<div class="p-6 lg:p-10 max-w-7xl mx-auto space-y-12">

    <div class="text-center">
        <h1 class="text-5xl font-extrabold text-darkBlue mb-4">Smart Insights & Recommendations</h1>
        <p class="text-xl text-gray-600">Your personal event mentor — powered by real data and proven strategies</p>
    </div>

    @if(!$has_events)
        <!-- New Organizer: Full Step-by-Step Strategy -->
        <div class="bg-gradient-to-br from-primary to-darkBlue text-white rounded-3xl p-10 shadow-2xl relative overflow-hidden">
            <div class="absolute inset-0 bg-black/20"></div>
            <div class="relative z-10">
                <h2 class="text-4xl font-black mb-6">Welcome, {{ $organizer_name }}! Let's make your first event a success 🚀</h2>
                <p class="text-xl mb-8">You haven't created any events yet — this is your golden opportunity to start strong!</p>

                <div class="grid md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-2xl font-bold mb-6">Most Profitable Categories in 2025</h3>
                        <ul class="space-y-4 text-lg">
                            <li class="flex items-center gap-3"><span class="text-3xl">🎵</span> <strong>Music Concerts & Festivals</strong> — Highest revenue</li>
                            <li class="flex items-center gap-3"><span class="text-3xl">💒</span> <strong>Weddings & Celebrations</strong> — Premium pricing</li>
                            <li class="flex items-center gap-3"><span class="text-3xl">💼</span> <strong>Corporate Events & Seminars</strong> — B2B demand</li>
                            <li class="flex items-center gap-3"><span class="text-3xl">🎂</span> <strong>Birthday Parties</strong> — High volume</li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold mb-6">Winning Strategies Used by Top Organizers</h3>
                        <ol class="space-y-4 text-lg">
                            <li><strong>1.</strong> Create <strong>3 ticket tiers</strong>: Early Bird, Normal, VIP</li>
                            <li><strong>2.</strong> Offer <strong>limited VIP spots</strong> — creates urgency</li>
                            <li><strong>3.</strong> Make events <strong>hybrid</strong> (in-person + live stream)</li>
                            <li><strong>4.</strong> Add <strong>early bird discount</strong> (20-30% off first week)</li>
                            <li><strong>5.</strong> Use high-quality photos & videos — increases bookings by 40%</li>
                            <li><strong>6.</strong> Promote on social media 4 weeks before launch</li>
                        </ol>
                    </div>
                </div>

                <div class="mt-10 p-8 bg-white/20 rounded-2xl text-center">
                    <p class="text-2xl font-bold">Follow these steps → Your first event can earn Rs. 500,000+</p>
                </div>
            </div>
        </div>
    @else
        <!-- Experienced Organizer: Full Analytics + Smart Advice -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-3xl p-8 shadow-xl text-center hover:shadow-2xl transition">
                <p class="text-gray-600 text-lg mb-2">Total Revenue</p>
                <p class="text-5xl font-black text-primary">Rs. {{ number_format($total_revenue) }}</p>
            </div>
            <div class="bg-white rounded-3xl p-8 shadow-xl text-center hover:shadow-2xl transition">
                <p class="text-gray-600 text-lg mb-2">Total Bookings</p>
                <p class="text-5xl font-black text-darkBlue">{{ $total_bookings }}</p>
            </div>
            <div class="bg-white rounded-3xl p-8 shadow-xl text-center hover:shadow-2xl transition">
                <p class="text-gray-600 text-lg mb-2">Tickets Sold</p>
                <p class="text-5xl font-black text-primary">{{ $total_tickets_sold }}</p>
            </div>
            <div class="bg-white rounded-3xl p-8 shadow-xl text-center hover:shadow-2xl transition">
                <p class="text-gray-600 text-lg mb-2">Avg Ticket Price</p>
                <p class="text-5xl font-black text-darkBlue">Rs. {{ number_format($avg_ticket_price, 0) }}</p>
            </div>
        </div>

        <div class="grid lg:grid-cols-2 gap-10">
            <!-- Your Top Categories -->
            <div class="bg-white rounded-3xl p-10 shadow-xl">
                <h2 class="text-3xl font-bold text-darkBlue mb-8">Your Best Performing Categories</h2>
                @if($top_categories->count() > 0)
                    <div class="space-y-6">
                        @foreach($top_categories as $index => $cat)
                            <div class="flex items-center justify-between p-4 rounded-2xl {{ $index === 0 ? 'bg-primary/10' : 'bg-gray-50' }}">
                                <div class="flex items-center gap-4">
                                    <span class="text-3xl font-bold text-primary">{{ $loop->iteration }}</span>
                                    <div>
                                        <p class="text-xl font-bold">{{ $cat->category?->name ?? 'Uncategorized' }}</p>
                                        <p class="text-gray-600">{{ $cat->paid_bookings_count }} bookings</p>
                                    </div>
                                </div>
                                <p class="text-2xl font-black text-darkBlue">Rs. {{ number_format($cat->revenue ?? 0) }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-gray-500 py-10">Sales data will appear after your first paid bookings</p>
                @endif
            </div>

            <!-- Audience Interests -->
            <div class="bg-white rounded-3xl p-10 shadow-xl">
                <h2 class="text-3xl font-bold text-darkBlue mb-8">What Your Audience Really Loves</h2>
                @if($top_interests->count() > 0)
                    <div class="flex flex-wrap gap-4 justify-center">
                        @foreach($top_interests as $interest)
                            <div class="bg-primary/10 text-primary px-8 py-5 rounded-full text-xl font-bold shadow-md hover:scale-105 transition">
                                {{ ucfirst($interest) }}
                            </div>
                        @endforeach
                    </div>
                    <p class="text-center text-gray-600 mt-8 text-lg">
                        Create more events around these interests → higher attendance guaranteed!
                    </p>
                @else
                    <p class="text-center text-gray-500 py-10">Audience preferences will show after bookings</p>
                @endif
            </div>
        </div>

        <!-- Personal Mentor Advice -->
        <div class="bg-gradient-to-br from-primary to-darkBlue text-white rounded-3xl p-12 shadow-2xl relative overflow-hidden">
            <div class="absolute inset-0 bg-black/10"></div>
            <div class="relative z-10">
                <h2 class="text-4xl font-black mb-6">Hey {{ $organizer_name }}, here's your personal growth plan:</h2>
                <p class="text-2xl leading-relaxed">
                    @if($top_categories->count() > 0)
                        You're doing great with <strong>{{ $top_categories->first()->category?->name ?? 'your events' }}</strong> — that's your strongest category right now!<br><br>
                        Keep creating more in this area. Top organizers earn 3x more by offering:
                        <ul class="mt-6 space-y-3 text-xl">
                            <li>• Early Bird tickets (20-30% discount)</li>
                            <li>• Limited VIP packages with perks</li>
                            <li>• Bundle deals (ticket + merchandise)</li>
                        </ul>
                        <br>
                        Your audience loves: <strong>{{ $top_interests->implode(', ', ' and ') }}</strong> — match your next event to this for instant success!
                    @else
                        You're building momentum! Start with one strong event in a popular category like Music or Weddings.<br><br>
                        Successful organizers use these proven tactics:
                        <ul class="mt-6 space-y-3 text-xl">
                            <li>• High-quality banner images</li>
                            <li>• Clear pricing tiers</li>
                            <li>• Early promotion (4+ weeks)</li>
                            <li>• Social media teasers</li>
                        </ul>
                    @endif
                </p>
                <p class="text-3xl font-bold mt-10">You're on the right path — keep going! 💪</p>
            </div>
        </div>
    @endif

</div>

</x-organizer.organizer-layout>
