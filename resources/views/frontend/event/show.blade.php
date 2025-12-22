<x-frontend.frontend-layout />

<div class="py-12 bg-white min-h-screen font-raleway">
    <div class="max-w-7xl mx-auto px-6">
        <!-- Event Banner -->
        <div class="relative rounded-2xl overflow-hidden shadow-xl mb-10">
            <img src="{{ $event->banner_image ? asset('storage/' . $event->banner_image) : 'https://via.placeholder.com/1600x800' }}"
                alt="{{ $event->title }}" class="w-full h-96 md:h-[500px] object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
            <div class="absolute bottom-0 left-0 p-8 text-white">
                <h1 class="text-4xl md:text-5xl font-extrabold mb-3">
                    {{ $event->title }}
                </h1>
                <div class="flex flex-wrap gap-6 text-lg">
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ $event->start_date->format('F d, Y') }}
                        @if ($event->end_date && $event->end_date->ne($event->start_date))
                            - {{ $event->end_date->format('F d, Y') }}
                        @endif
                    </span>
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ $event->location }}
                    </span>
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-10">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-10">
                <!-- Description -->
                <section class="bg-softGray p-8 rounded-2xl shadow-md">
                    <h2 class="text-2xl font-bold text-darkBlue mb-4">About This Event</h2>
                    <div class="text-gray-700 leading-relaxed whitespace-pre-line">
                        {!! nl2br(e($event->long_description ?? $event->short_description)) !!}
                    </div>
                </section>

                <!-- Category -->
                @if ($event->category)
                    <div class="bg-softGray p-6 rounded-xl">
                        <span class="text-sm font-medium text-gray-600">Category:</span>
                        <span class="ml-2 px-4 py-2 bg-primary/20 text-primary rounded-lg font-semibold">
                            {{ $event->category->name }}
                        </span>
                    </div>
                @endif
            </div>

            <!-- Tickets Sidebar -->
            @if ($event->tickets->isNotEmpty())
                <aside class="lg:col-span-1">
                    <div class="bg-softGray p-8 rounded-2xl shadow-lg sticky top-24">
                        <h3 class="text-2xl font-bold text-darkBlue mb-6">Tickets</h3>

                        <div class="space-y-6">
                            @foreach ($event->tickets as $ticket)
                                @php
                                    $remaining = $ticket->total_seats - $ticket->sold_seats;
                                    $now = now();

                                    $isOnSale = true;
                                    if ($ticket->sale_start && $now->lt($ticket->sale_start)) {
                                        $isOnSale = false;
                                    }
                                    if ($ticket->sale_end && $now->gt($ticket->sale_end)) {
                                        $isOnSale = false;
                                    }

                                    $canBook = $remaining > 0 && $isOnSale;
                                @endphp

                                <div class="border-2 {{ $canBook ? 'border-primary/30' : 'border-gray-300' }} rounded-xl p-6 {{ !$canBook ? 'opacity-75' : '' }}">
                                    <div class="flex justify-between items-start mb-3">
                                        <div>
                                            <h4 class="text-xl font-bold text-darkBlue">{{ $ticket->name }}</h4>
                                            @if ($ticket->description)
                                                <p class="text-sm text-gray-600 mt-1">{{ $ticket->description }}</p>
                                            @endif
                                        </div>
                                        <div class="text-right">
                                            @if ($ticket->price == 0)
                                                <span class="text-2xl font-extrabold text-green-600">Free</span>
                                            @else
                                                <span class="text-2xl font-extrabold text-primary">
                                                    Rs. {{ number_format($ticket->price, 2) }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="text-sm font-medium mb-4 text-gray-700">
                                        <span class="text-lg font-bold">{{ $remaining }}</span>
                                        ticket{{ $remaining != 1 ? 's' : '' }} available

                                        @if (!$isOnSale)
                                            <span class="block mt-2 text-red-600 font-semibold">
                                                @if ($ticket->sale_start && $now->lt($ticket->sale_start))
                                                    Sale starts on {{ $ticket->sale_start->format('M d, Y \a\t h:i A') }}
                                                @else
                                                    Sale has ended
                                                @endif
                                            </span>
                                        @elseif ($remaining == 0)
                                            <span class="block mt-2 text-red-600 font-semibold">Sold Out</span>
                                        @elseif ($remaining <= 10)
                                            <span class="ml-2 text-orange-600 font-semibold">Hurry! Limited seats</span>
                                        @endif
                                    </div>

                                    @if ($canBook)
                                        <a href="{{ route('user.booking.create', $ticket) }}"
                                            class="block w-full py-3 bg-primary text-white font-bold rounded-lg text-center hover:bg-darkBlue transition">
                                            Book Now
                                        </a>
                                    @else
                                        <button disabled class="w-full py-3 bg-gray-500 text-white font-bold rounded-lg cursor-not-allowed">
                                            @if ($remaining == 0) Sold Out @else Not Available @endif
                                        </button>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </aside>
            @else
                <aside class="lg:col-span-1">
                    <div class="bg-softGray p-8 rounded-2xl shadow-lg text-center">
                        <p class="text-xl text-gray-600">No tickets available for this event.</p>
                    </div>
                </aside>
            @endif
        </div>

        <!-- Related / Recommended Events Section (Inline Cards - No Component) -->
        @if ($relatedEvents->isNotEmpty())
            <section class="mt-20">
                <div class="flex justify-between items-center mb-10">
                    <h2 class="text-3xl font-extrabold text-darkBlue">
                        @auth
                            Recommended For You
                        @else
                            Related Events
                        @endauth
                    </h2>
                    <a href="{{ route('events.index') }}" class="text-primary font-semibold hover:underline">
                        View All Events →
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($relatedEvents as $relatedEvent)
                        <a href="{{ route('events.show', $relatedEvent) }}" class="block group">
                            <div class="bg-white rounded-xl overflow-hidden shadow-lg transform transition hover:-translate-y-2 hover:shadow-2xl duration-300">
                                <!-- Image -->
                                <div class="relative">
                                    <img
                                        src="{{ $relatedEvent->banner_image ? asset('storage/' . $relatedEvent->banner_image) : 'https://via.placeholder.com/1200x520' }}"
                                        alt="{{ $relatedEvent->title }}"
                                        class="w-full h-52 object-cover"
                                    >

                                    <!-- Featured Badge -->
                                    @if($relatedEvent->is_featured)
                                        <div class="absolute top-4 left-4">
                                            <span class="bg-yellow-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow">
                                                Featured
                                            </span>
                                        </div>
                                    @endif

                                    <!-- Category Badge -->
                                    @if($relatedEvent->category)
                                        <div class="absolute bottom-4 left-4">
                                            <span class="bg-primary/90 text-white text-xs font-medium px-3 py-1 rounded-lg">
                                                {{ $relatedEvent->category->name }}
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Content -->
                                <div class="p-6">
                                    <h3 class="font-bold text-xl text-darkBlue mb-2 line-clamp-2 group-hover:text-primary transition">
                                        {{ $relatedEvent->title }}
                                    </h3>

                                    <p class="text-gray-600 text-sm mb-1">
                                        {{ $relatedEvent->location }} • {{ $relatedEvent->start_date->format('M d, Y') }}
                                    </p>

                                    @if($relatedEvent->end_date && $relatedEvent->end_date->gt($relatedEvent->start_date))
                                        <p class="text-gray-600 text-sm mb-3">
                                            Ends: {{ $relatedEvent->end_date->format('M d, Y') }}
                                        </p>
                                    @endif

                                    <p class="text-gray-700 text-sm mb-4 line-clamp-3">
                                        {{ $relatedEvent->short_description ?? 'No description available.' }}
                                    </p>

                                    <div class="mt-4 flex gap-3">
                                        <span class="px-4 py-2 border border-primary rounded-lg text-primary font-semibold hover:bg-primary hover:text-white transition">
                                            Details
                                        </span>
                                    </div>

                                    <div class="mt-5 text-right">
                                        @if(isset($relatedEvent->min_price) && $relatedEvent->min_price > 0)
                                            <span class="text-2xl font-extrabold text-primary">
                                                Rs. {{ number_format($relatedEvent->min_price) }}+
                                            </span>
                                        @else
                                            
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- Back to Events -->
        <div class="mt-16 text-center">
            <a href="{{ route('events.index') }}"
                class="inline-flex items-center gap-2 text-primary font-semibold hover:underline">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Events
            </a>
        </div>
    </div>
</div>

<x-frontend.footer-card />
