<x-frontend.frontend-layout />

<div class="py-12 bg-white min-h-screen">
    <div class="max-w-7xl mx-auto px-6">
        <h1 class="text-4xl font-extrabold text-darkBlue mb-8 text-center">Explore Events</h1>

        <!-- Display Search Results Message -->
        @if(request()->filled('query'))
            <div class="mb-8 text-center">
                <p class="text-lg text-gray-700">
                    Search results for: <span class="font-semibold text-primary">"{{ request()->input('query') }}"</span>
                    @if($events->total() == 0)
                        <span class="text-red-600 ml-2">– No events found</span>
                    @else
                        <span class="text-gray-600 ml-2">– {{ $events->total() }} event{{ $events->total() > 1 ? 's' : '' }} found</span>
                    @endif
                </p>
            </div>
        @endif

        <!-- Top Controls Section: Search + Sort in one line -->
        <div class="mb-12">
            <div class="flex flex-col md:flex-row gap-6 items-center justify-between bg-softGray px-8 sm:px-12 py-6 rounded-2xl shadow-md">
                <!-- Search Form -->
                <form method="GET" action="{{ route('events.index') }}" class="w-full md:w-3/5 lg:w-1/2">
                    <div class="flex">
                        <input
                            type="text"
                            name="query"
                            placeholder="Search events by title, location or description..."
                            value="{{ request()->input('query') }}"
                            class="w-full px-6 py-4 text-lg border border-gray-300 rounded-l-xl focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/30"
                        >
                        <button
                            type="submit"
                            class="px-8 py-4 bg-primary text-white rounded-r-xl font-bold hover:bg-darkBlue transition text-lg"
                        >
                            Search
                        </button>
                    </div>

                    <!-- Preserve filters -->
                    @foreach(request()->input('categories', []) as $cat)
                        <input type="hidden" name="categories[]" value="{{ $cat }}">
                    @endforeach
                    <input type="hidden" name="start_date_from" value="{{ request()->input('start_date_from') }}">
                    <input type="hidden" name="start_date_to" value="{{ request()->input('start_date_to') }}">
                    <input type="hidden" name="sort" value="{{ $sort }}">
                </form>

                <!-- Sort Dropdown -->
                <form method="GET" action="{{ route('events.index') }}" class="w-full md:w-auto">
                    @foreach(request()->input('categories', []) as $cat)
                        <input type="hidden" name="categories[]" value="{{ $cat }}">
                    @endforeach
                    <input type="hidden" name="start_date_from" value="{{ request()->input('start_date_from') }}">
                    <input type="hidden" name="start_date_to" value="{{ request()->input('start_date_to') }}">
                    <input type="hidden" name="query" value="{{ request()->input('query') }}">

                    <select
                        name="sort"
                        onchange="this.form.submit()"
                        class="px-8 py-4 border-2 border-primary rounded-xl text-gray-700 focus:border-darkBlue focus:ring-4 focus:ring-primary/30 font-medium text-lg w-full md:w-auto"
                    >
                        <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>Sort by Newest</option>
                        <option value="oldest" {{ $sort === 'oldest' ? 'selected' : '' }}>Sort by Oldest</option>
                    </select>
                </form>
            </div>
        </div>

        <div class="grid lg:grid-cols-4 gap-8">
            <!-- Left Sidebar: Filters (Sticky on large, appears BELOW cards on mobile) -->
            <aside class="lg:col-span-1 lg:sticky lg:top-20 lg:self-start order-2 lg:order-1">
                <form method="GET" action="{{ route('events.index') }}" class="bg-softGray p-6 rounded-xl shadow-md">
                    <h3 class="text-xl font-bold text-darkBlue mb-4">Filters</h3>

                    <!-- Categories -->
                    <div class="mb-6">
                        <h4 class="text-lg font-semibold text-gray-800 mb-2">Categories</h4>
                        <div class="space-y-2 max-h-48 overflow-y-auto">
                            @foreach($categories as $category)
                                <label class="flex items-center">
                                    <input
                                        type="checkbox"
                                        name="categories[]"
                                        value="{{ $category->id }}"
                                        {{ in_array($category->id, request()->input('categories', [])) ? 'checked' : '' }}
                                        class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded"
                                    >
                                    <span class="ml-2 text-sm text-gray-700">{{ $category->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Date Range -->
                    <div class="mb-6">
                        <h4 class="text-lg font-semibold text-gray-800 mb-2">Date Range</h4>
                        <div class="space-y-4">
                            <div>
                                <label for="start_date_from" class="block text-sm font-medium text-gray-700">From</label>
                                <input
                                    type="date"
                                    name="start_date_from"
                                    id="start_date_from"
                                    value="{{ request()->input('start_date_from') }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary py-2 px-3"
                                >
                            </div>
                            <div>
                                <label for="start_date_to" class="block text-sm font-medium text-gray-700">To</label>
                                <input
                                    type="date"
                                    name="start_date_to"
                                    id="start_date_to"
                                    value="{{ request()->input('start_date_to') }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary py-2 px-3"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Preserve search and sort -->
                    <input type="hidden" name="query" value="{{ request()->input('query') }}">
                    <input type="hidden" name="sort" value="{{ $sort }}">

                    <button type="submit" class="w-full px-4 py-3 bg-primary text-white rounded-lg font-semibold hover:bg-darkBlue transition">
                        Apply Filters
                    </button>
                </form>
            </aside>

            <!-- Main Content: Events Grid (Appears FIRST on mobile) -->
            <main class="lg:col-span-3 order-1 lg:order-2">
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($events as $event)
                        <div class="bg-white shadow-lg rounded-xl overflow-hidden transform transition hover:-translate-y-2 hover:shadow-2xl duration-300">
                            <img
                                src="{{ $event->banner_image ? asset('storage/' . $event->banner_image) : 'https://via.placeholder.com/1200x520' }}"
                                class="w-full h-52 object-cover"
                                alt="{{ $event->title }}"
                            >
                            <div class="p-6">
                                <h3 class="font-bold text-xl mb-2">{{ $event->title }}</h3>
                                <p class="text-gray-600 text-sm mt-1">{{ $event->location }} • {{ $event->start_date->format('M d, Y') }}</p>
                                @if($event->end_date)
                                    <p class="text-gray-600 text-sm mb-2">Ends: {{ $event->end_date->format('M d, Y') }}</p>
                                @endif
                                <p class="text-gray-700 text-sm mb-4 line-clamp-3">{{ $event->short_description }}</p>

                                <div class="mt-4 flex gap-3 flex-wrap">
                                    <a href="#" class="px-4 py-2 border border-primary rounded-lg text-primary font-semibold hover:bg-primary hover:text-white transition">
                                        Details
                                    </a>
                                    @if($event->has_registration)
                                        <a href="#" class="px-4 py-2 bg-primary text-white rounded-lg font-semibold hover:bg-darkBlue transition">
                                            Book Now
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12">
                            <p class="text-xl text-gray-600">No events found matching your criteria.</p>
                            <p class="text-gray-500 mt-4">Try adjusting your search or filters.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($events->hasPages())
                    <div class="mt-12 flex justify-center">
                        {{ $events->appends(request()->query())->links('pagination::tailwind') }}
                    </div>
                @endif
            </main>
        </div>
    </div>
</div>
