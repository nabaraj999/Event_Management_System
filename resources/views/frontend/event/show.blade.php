<x-frontend.frontend-layout />

<div class="bg-gray-50 min-h-screen pt-16">

    <!-- Event Banner -->
    <div class="relative h-72 sm:h-96 md:h-[480px] overflow-hidden">
        <img src="{{ $event->banner_image ? asset('storage/' . $event->banner_image) : 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=1600' }}"
             alt="{{ $event->title }}" class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/30 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-darkBlue/30 to-transparent"></div>

        <!-- Category badge -->
        @if($event->category)
            <div class="absolute top-6 left-6">
                <span class="bg-primary/90 backdrop-blur-sm text-white text-xs font-black px-4 py-1.5 rounded-full shadow-md">
                    {{ $event->category->name }}
                </span>
            </div>
        @endif

        <!-- Title overlay -->
        <div class="absolute bottom-0 left-0 right-0 p-6 sm:p-10 text-white">
            <div class="max-w-7xl mx-auto">
                <h1 class="font-raleway text-3xl sm:text-4xl md:text-5xl font-black mb-4 leading-tight drop-shadow-lg">
                    {{ $event->title }}
                </h1>
                <div class="flex flex-wrap gap-4 sm:gap-6 text-sm sm:text-base font-semibold">
                    <span class="flex items-center gap-2 bg-white/15 backdrop-blur-sm px-4 py-2 rounded-full">
                        <i class="fas fa-calendar-alt text-primary"></i>
                        {{ $event->start_date->format('F d, Y') }}
                        @if ($event->end_date && $event->end_date->ne($event->start_date))
                            &ndash; {{ $event->end_date->format('F d, Y') }}
                        @endif
                    </span>
                    <span class="flex items-center gap-2 bg-white/15 backdrop-blur-sm px-4 py-2 rounded-full">
                        <i class="fas fa-map-marker-alt text-primary"></i>
                        {{ $event->location }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Area -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-10">
        <div class="grid lg:grid-cols-3 gap-10">

            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">

                <!-- About This Event -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-8 py-5 border-b border-gray-100 bg-gray-50/50 flex items-center gap-3">
                        <div class="w-9 h-9 bg-orange-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-info-circle text-primary text-sm"></i>
                        </div>
                        <h2 class="font-raleway text-xl font-black text-darkBlue">About This Event</h2>
                    </div>
                    <div class="p-8 text-gray-600 leading-relaxed whitespace-pre-line text-[15px]">
                        {!! nl2br(e($event->long_description ?? $event->short_description)) !!}
                    </div>
                </div>

                <!-- Category Tag -->
                @if ($event->category)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 px-6 py-5 flex items-center gap-4">
                        <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-tag text-primary text-sm"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Category</p>
                            <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-primary/10 text-primary rounded-full font-black text-sm">
                                {{ $event->category->name }}
                            </span>
                        </div>
                    </div>
                @endif

                <!-- Related Events -->
                @if ($relatedEvents->isNotEmpty())
                    <div class="pt-4">
                        <div class="flex justify-between items-center mb-8">
                            <h2 class="font-raleway text-2xl font-black text-darkBlue">
                                @auth Recommended For You @else Related Events @endauth
                            </h2>
                            <a href="{{ route('events.index') }}" class="text-primary font-bold text-sm hover:underline flex items-center gap-1">
                                View All <i class="fas fa-arrow-right text-xs"></i>
                            </a>
                        </div>

                        <div class="grid sm:grid-cols-2 gap-6">
                            @foreach ($relatedEvents->take(4) as $relatedEvent)
                                <a href="{{ route('events.show', $relatedEvent) }}" class="card-hover group block">
                                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100">
                                        <div class="relative overflow-hidden h-44">
                                            <img src="{{ $relatedEvent->banner_image ? asset('storage/' . $relatedEvent->banner_image) : 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=800' }}"
                                                 alt="{{ $relatedEvent->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" />
                                            @if ($relatedEvent->is_featured)
                                                <div class="absolute top-3 right-3">
                                                    <span class="bg-yellow-400 text-yellow-900 text-xs font-black px-3 py-1 rounded-full flex items-center gap-1 shadow-md">
                                                        <i class="fas fa-star text-xs"></i> Featured
                                                    </span>
                                                </div>
                                            @endif
                                            @if ($relatedEvent->category)
                                                <div class="absolute bottom-3 left-3">
                                                    <span class="bg-primary/90 text-white text-xs font-bold px-3 py-1 rounded-full backdrop-blur-sm">
                                                        {{ $relatedEvent->category->name }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="p-5">
                                            <h3 class="font-raleway font-black text-darkBlue text-base mb-2 line-clamp-2 group-hover:text-primary transition-colors">
                                                {{ $relatedEvent->title }}
                                            </h3>
                                            <div class="flex items-center gap-3 text-xs text-gray-500">
                                                <span class="flex items-center gap-1.5 font-medium"><i class="fas fa-map-marker-alt text-primary text-xs"></i> {{ Str::limit($relatedEvent->location, 18) }}</span>
                                                <span class="flex items-center gap-1.5 font-medium"><i class="fas fa-calendar text-primary text-xs"></i> {{ $relatedEvent->start_date->format('M d, Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Back Link -->
                <div class="pt-2">
                    <a href="{{ route('events.index') }}"
                       class="inline-flex items-center gap-2 text-gray-500 hover:text-primary font-semibold text-sm transition-colors group">
                        <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform duration-200"></i>
                        Back to All Events
                    </a>
                </div>
            </div>

            <!-- Tickets Sidebar -->
            <aside class="lg:col-span-1">
                <div class="sticky top-20">
                    @if ($event->tickets->isNotEmpty())
                        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex items-center gap-3">
                                <div class="w-9 h-9 bg-orange-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-ticket text-primary text-sm"></i>
                                </div>
                                <h3 class="font-raleway text-lg font-black text-darkBlue">Tickets</h3>
                            </div>

                            <div class="p-5 space-y-4">
                                @foreach ($event->tickets as $ticket)
                                    @php
                                        $remaining = $ticket->remaining_seats;
                                        $now = now();
                                        $isOnSale = $ticket->isOnSale($now);
                                        $canBook = $ticket->isAvailable($now);
                                    @endphp

                                    <div class="rounded-2xl border-2 {{ $canBook ? 'border-primary/25 bg-orange-50/30' : 'border-gray-200 bg-gray-50/50 opacity-70' }} p-5">
                                        <div class="flex justify-between items-start mb-3">
                                            <div class="flex-1 pr-3">
                                                <h4 class="font-raleway font-black text-darkBlue text-base">{{ $ticket->name }}</h4>
                                                @if ($ticket->description)
                                                    <p class="text-xs text-gray-500 mt-1 leading-relaxed">{{ $ticket->description }}</p>
                                                @endif
                                            </div>
                                            <div class="text-right flex-shrink-0">
                                                @if ($ticket->price == 0)
                                                    <span class="text-xl font-black text-green-600">Free</span>
                                                @else
                                                    <span class="text-xl font-black text-primary">Rs.&nbsp;{{ number_format($ticket->price, 0) }}</span>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Availability -->
                                        <div class="mb-4">
                                            @if (!$ticket->is_active)
                                                <div class="flex items-center gap-2 text-xs font-bold text-red-600 bg-red-50 px-3 py-2 rounded-lg">
                                                    <i class="fas fa-ban"></i> Ticket is currently unavailable
                                                </div>
                                            @elseif (!$isOnSale)
                                                <div class="flex items-center gap-2 text-xs font-bold text-red-600 bg-red-50 px-3 py-2 rounded-lg">
                                                    <i class="fas fa-clock"></i>
                                                    @if ($ticket->sale_start && $now->lt($ticket->sale_start))
                                                        Sale starts {{ $ticket->sale_start->format('M d, Y \a\t h:i A') }}
                                                    @else
                                                        Sale has ended
                                                    @endif
                                                </div>
                                            @elseif ($remaining == 0)
                                                <div class="flex items-center gap-2 text-xs font-bold text-red-600 bg-red-50 px-3 py-2 rounded-lg">
                                                    <i class="fas fa-ban"></i> Sold Out
                                                </div>
                                            @elseif ($remaining <= 10)
                                                <div class="flex items-center gap-2 text-xs font-bold text-orange-600 bg-orange-50 px-3 py-2 rounded-lg">
                                                    <i class="fas fa-fire"></i> Only {{ $remaining }} left — Hurry!
                                                </div>
                                            @else
                                                <div class="flex items-center gap-2 text-xs font-semibold text-green-700 bg-green-50 px-3 py-2 rounded-lg">
                                                    <i class="fas fa-check-circle"></i> {{ $remaining }} tickets available
                                                </div>
                                            @endif
                                        </div>

                                        @if ($canBook)
                                            <a href="{{ route('user.booking.create', $ticket) }}"
                                               class="btn-primary block w-full py-3 text-white font-black rounded-xl text-center text-sm shadow-md">
                                                <i class="fas fa-ticket-alt mr-2"></i>Book Now
                                            </a>
                                        @else
                                            <button disabled
                                                    class="w-full py-3 bg-gray-300 text-gray-500 font-black rounded-xl cursor-not-allowed text-sm">
                                                {{ $remaining == 0 ? 'Sold Out' : 'Not Available' }}
                                            </button>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 text-center">
                            <div class="w-14 h-14 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-ticket text-gray-400 text-xl"></i>
                            </div>
                            <h3 class="font-raleway font-black text-gray-700 mb-2">No Tickets Yet</h3>
                            <p class="text-sm text-gray-400">No tickets are available for this event at the moment.</p>
                        </div>
                    @endif
                </div>
            </aside>

        </div>
    </div>
</div>

<x-frontend.footer-card />
