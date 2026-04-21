<x-frontend.frontend-layout />

<!-- Page Header -->
<div class="bg-gradient-to-br from-darkBlue via-[#0a4f9e] to-darkBlue pt-28 pb-16 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-96 h-96 bg-primary/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-300/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 text-white">
        <p class="text-primary font-bold text-xs mb-2 uppercase tracking-widest">Browse All</p>
        <h1 class="font-raleway text-4xl sm:text-5xl font-black mb-3">Explore Events</h1>
        <p class="text-white/60 text-base">Discover amazing events happening around Nepal</p>
    </div>
</div>

<div class="py-10 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">

        <!-- Search Result Message -->
        @if (request()->filled('query'))
            <div class="mb-6 bg-blue-50 border border-blue-200 text-blue-800 px-5 py-3.5 rounded-2xl flex items-center gap-3 text-sm font-medium">
                <i class="fas fa-search text-blue-500"></i>
                Results for: <strong>"{{ request()->input('query') }}"</strong>
                @if ($events->total() == 0)
                    — <span class="text-red-600 font-bold">No events found</span>
                @else
                    — <span class="text-green-700 font-bold">{{ $events->total() }} event{{ $events->total() > 1 ? 's' : '' }} found</span>
                @endif
            </div>
        @endif

        <!-- Search + Sort Bar -->
        <div class="mb-8 bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-5">
            <div class="flex flex-col md:flex-row gap-4 items-stretch md:items-center">
                <!-- Search -->
                <form method="GET" action="{{ route('events.index') }}" class="flex-1">
                    <div class="relative">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                        <input type="text" name="query"
                               placeholder="Search events by title, location..."
                               value="{{ request()->input('query') }}"
                               class="w-full pl-11 pr-32 py-3.5 border border-gray-200 rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-medium">
                        @foreach (request()->input('categories', []) as $cat)
                            <input type="hidden" name="categories[]" value="{{ $cat }}">
                        @endforeach
                        @foreach (request()->input('organizers', []) as $org)
                            <input type="hidden" name="organizers[]" value="{{ $org }}">
                        @endforeach
                        <input type="hidden" name="start_date_from" value="{{ request()->input('start_date_from') }}">
                        <input type="hidden" name="start_date_to" value="{{ request()->input('start_date_to') }}">
                        <input type="hidden" name="sort" value="{{ $sort }}">
                        <button type="submit"
                                class="absolute right-2 top-1/2 -translate-y-1/2 px-5 py-2 bg-primary text-white font-bold rounded-lg hover:bg-darkBlue transition-colors text-sm">
                            Search
                        </button>
                    </div>
                </form>

                <!-- Sort -->
                <form method="GET" action="{{ route('events.index') }}" class="w-full md:w-auto">
                    @foreach (request()->input('categories', []) as $cat)
                        <input type="hidden" name="categories[]" value="{{ $cat }}">
                    @endforeach
                    @foreach (request()->input('organizers', []) as $org)
                        <input type="hidden" name="organizers[]" value="{{ $org }}">
                    @endforeach
                    <input type="hidden" name="start_date_from" value="{{ request()->input('start_date_from') }}">
                    <input type="hidden" name="start_date_to" value="{{ request()->input('start_date_to') }}">
                    <input type="hidden" name="query" value="{{ request()->input('query') }}">
                    <div class="relative">
                        <i class="fas fa-sort absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                        <select name="sort" onchange="this.form.submit()"
                                class="pl-10 pr-10 py-3.5 border border-gray-200 rounded-xl text-sm font-medium bg-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 w-full md:w-auto appearance-none">
                            <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>Soonest First</option>
                            <option value="oldest" {{ $sort === 'oldest' ? 'selected' : '' }}>Latest First</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>

        <div class="grid lg:grid-cols-4 gap-8">

            <!-- Sidebar Filters -->
            <aside class="lg:col-span-1 order-2 lg:order-1 lg:sticky lg:top-20 lg:self-start">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <!-- Filter Header -->
                    <div class="flex justify-between items-center px-5 py-4 border-b border-gray-100 bg-gray-50/80">
                        <h3 class="font-black text-darkBlue flex items-center gap-2 text-sm">
                            <div class="w-7 h-7 bg-primary/10 rounded-lg flex items-center justify-center">
                                <i class="fas fa-sliders-h text-primary text-xs"></i>
                            </div>
                            Filters
                        </h3>
                        @if (request()->except(['page', 'sort']) != [])
                            <a href="{{ route('events.index') }}" class="text-xs text-red-500 hover:text-red-700 font-bold flex items-center gap-1 transition-colors">
                                <i class="fas fa-times text-xs"></i> Clear All
                            </a>
                        @endif
                    </div>

                    <form method="GET" action="{{ route('events.index') }}" class="p-5 space-y-6">

                        <!-- Categories -->
                        <div>
                            <h4 class="text-xs font-black uppercase tracking-widest text-gray-400 mb-3">Categories</h4>
                            <div class="space-y-1.5 max-h-48 overflow-y-auto pr-1">
                                @foreach ($categories as $category)
                                    <label class="flex items-center gap-3 cursor-pointer group py-1.5 px-2 rounded-lg hover:bg-orange-50 transition-colors">
                                        <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                               {{ in_array($category->id, request()->input('categories', [])) ? 'checked' : '' }}
                                               class="w-4 h-4 text-primary focus:ring-primary rounded border-gray-300 flex-shrink-0">
                                        <span class="text-sm text-gray-700 group-hover:text-primary transition-colors font-medium">{{ $category->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="h-px bg-gray-100"></div>

                        <!-- Organizers -->
                        <div>
                            <h4 class="text-xs font-black uppercase tracking-widest text-gray-400 mb-3">Organizers</h4>
                            <div class="space-y-1.5 max-h-48 overflow-y-auto pr-1">
                                @foreach ($organizers as $organizer)
                                    <label class="flex items-center gap-3 cursor-pointer group py-1.5 px-2 rounded-lg hover:bg-orange-50 transition-colors">
                                        <input type="checkbox" name="organizers[]" value="{{ $organizer->id }}"
                                               {{ in_array($organizer->id, request()->input('organizers', [])) ? 'checked' : '' }}
                                               class="w-4 h-4 text-primary focus:ring-primary rounded border-gray-300 flex-shrink-0">
                                        <span class="text-sm text-gray-700 group-hover:text-primary transition-colors font-medium">{{ $organizer->organization_name }}</span>
                                    </label>
                                @endforeach
                                @if ($organizers->isEmpty())
                                    <p class="text-sm text-gray-400 italic px-2">No organizers available</p>
                                @endif
                            </div>
                        </div>

                        <div class="h-px bg-gray-100"></div>

                        <!-- Date Range -->
                        <div>
                            <h4 class="text-xs font-black uppercase tracking-widest text-gray-400 mb-3">Date Range</h4>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 mb-1.5">From Date</label>
                                    <input type="date" name="start_date_from" value="{{ request()->input('start_date_from') }}"
                                           class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 mb-1.5">To Date</label>
                                    <input type="date" name="start_date_to" value="{{ request()->input('start_date_to') }}"
                                           class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="query" value="{{ request()->input('query') }}">
                        <input type="hidden" name="sort" value="{{ $sort }}">

                        <button type="submit"
                                class="w-full py-3 bg-primary text-white font-black rounded-xl hover:bg-darkBlue transition-colors text-sm shadow-md">
                            <i class="fas fa-check mr-2"></i>Apply Filters
                        </button>
                    </form>
                </div>
            </aside>

            <!-- Events Grid -->
            <main class="lg:col-span-3 order-1 lg:order-2">
                <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-6">
                    @forelse($events as $event)
                        <article class="card-hover group bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100">
                            <!-- Image -->
                            <div class="relative overflow-hidden h-48">
                                <img src="{{ $event->banner_image ? asset('storage/' . $event->banner_image) : 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=800' }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                                     alt="{{ $event->title }}" />
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                                @if ($event->category)
                                    <div class="absolute bottom-3 left-3">
                                        <span class="bg-primary/90 text-white text-xs font-bold px-3 py-1.5 rounded-full backdrop-blur-sm">{{ $event->category->name }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Body -->
                            <div class="p-5">
                                <h3 class="font-raleway font-black text-darkBlue text-base mb-2 line-clamp-2 group-hover:text-primary transition-colors duration-200">
                                    {{ $event->title }}
                                </h3>

                                <div class="flex flex-wrap items-center gap-3 text-xs text-gray-500 mb-3">
                                    <span class="flex items-center gap-1.5 font-medium">
                                        <i class="fas fa-map-marker-alt text-primary"></i>
                                        {{ Str::limit($event->location, 20) }}
                                    </span>
                                    <span class="flex items-center gap-1.5 font-medium">
                                        <i class="fas fa-calendar text-primary"></i>
                                        {{ $event->start_date->format('M d, Y') }}
                                    </span>
                                </div>

                                @if($event->short_description)
                                    <p class="text-gray-400 text-xs mb-4 line-clamp-2 leading-relaxed">{{ $event->short_description }}</p>
                                @endif

                                <div class="flex gap-2 pt-3 border-t border-gray-100">
                                    <a href="{{ route('events.show', $event) }}"
                                       class="flex-1 text-center py-2.5 border-2 border-primary text-primary text-xs font-black rounded-xl hover:bg-primary hover:text-white transition-colors">
                                        Details
                                    </a>
                                    @if ($event->has_registration)
                                        <a href="{{ route('events.show', $event) }}"
                                           class="flex-1 text-center py-2.5 bg-primary text-white text-xs font-black rounded-xl hover:bg-darkBlue transition-colors shadow-md">
                                            Book Now
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="col-span-full py-24 text-center">
                            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-5">
                                <i class="fas fa-search text-gray-400 text-3xl"></i>
                            </div>
                            <h3 class="font-raleway text-xl font-black text-gray-600 mb-2">No events found</h3>
                            <p class="text-gray-400 text-sm">Try adjusting your search terms or removing filters.</p>
                            <a href="{{ route('events.index') }}" class="inline-flex items-center gap-2 mt-6 px-6 py-3 bg-primary text-white font-bold rounded-xl hover:bg-darkBlue transition-colors text-sm">
                                <i class="fas fa-times-circle"></i> Clear All Filters
                            </a>
                        </div>
                    @endforelse
                </div>

                @if ($events->hasPages())
                    <div class="mt-10 flex justify-center">
                        {{ $events->appends(request()->query())->links('pagination::tailwind') }}
                    </div>
                @endif
            </main>
        </div>
    </div>
</div>

<x-frontend.footer-card />
