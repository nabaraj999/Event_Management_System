<x-frontend.frontend-layout />

    <!-- Page Header -->
    <section class="py-16 bg-gradient-to-b from-primary/10 to-gray-50">
        <div class="container mx-auto px-4 text-center">
            <!-- Category Icon -->
            <div class="mb-6 inline-flex items-center justify-center w-32 h-32 bg-white rounded-full shadow-lg">
                @if($category->icon_type === 'fontawesome' && $category->icon_name)
                    <i class="{{ $category->icon_name }} text-6xl text-primary"></i>
                @elseif($category->icon_type === 'custom' && $category->custom_svg)
                    {!! $category->custom_svg !!}
                @else
                    <span class="text-5xl font-bold text-primary">
                        {{ strtoupper(substr($category->name, 0, 2)) }}
                    </span>
                @endif
            </div>

            <h1 class="text-4xl md:text-5xl font-bold text-darkBlue font-raleway">
                {{ $category->name }} Events
            </h1>

            @if($category->description)
                <p class="mt-6 text-xl text-gray-700 max-w-3xl mx-auto">
                    {{ $category->description }}
                </p>
            @endif

            <p class="mt-4 text-lg text-gray-600">
                {{ $events->total() }} event{{ $events->total() !== 1 ? 's' : '' }} available
            </p>
        </div>
    </section>

    <!-- Events Grid -->
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            @if($events->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @foreach($events as $event)
                        <a href="{{ route('events.show', $event->slug) }}"
                           class="group block bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden">

                            <!-- Event Image (adjust if you have image field) -->
                            @if($event->featured_image ?? null)
                                <img src="{{ asset('storage/' . $event->featured_image) }}"
                                     alt="{{ $event->title }}"
                                     class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-500 text-lg">No Image</span>
                                </div>
                            @endif

                            <div class="p-6">
                                <h3 class="text-xl font-semibold text-darkBlue group-hover:text-primary transition-colors">
                                    {{ $event->title ?? 'Untitled Event' }}
                                </h3>

                                <p class="mt-3 text-gray-600 text-sm line-clamp-2">
                                    {{ Str::limit($event->short_description ?? $event->description, 100) }}
                                </p>

                                <div class="mt-4 flex items-center justify-between text-sm text-gray-500">
                                    <span>{{ $event->date?->format('M d, Y') ?? 'Date TBD' }}</span>
                                    <span class="text-primary font-medium">View Details →</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $events->links() }}
                </div>
            @else
                <div class="text-center py-20 bg-white rounded-2xl shadow">
                    <p class="text-2xl text-gray-500 mb-4">No events found</p>
                    <p class="text-gray-400">There are currently no events in this category.</p>
                    <a href="{{ route('home') }}" class="mt-6 inline-block px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary/90 transition">
                        Back to Home
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- Related Categories (Optional Sidebar-like) -->
    @if($relatedCategories->count() > 0)
        <section class="py-12 bg-white">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold text-darkBlue text-center mb-10 font-raleway">
                    Other Categories
                </h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-6">
                    @foreach($relatedCategories as $cat)
                        <a href="{{ route('events.category', $cat->slug) }}"
                           class="text-center p-4 bg-gray-50 rounded-xl hover:bg-primary/5 transition">
                            <div class="w-16 h-16 mx-auto mb-3 bg-primary/10 rounded-full flex items-center justify-center">
                                <span class="text-2xl font-bold text-primary">
                                    {{ strtoupper(substr($cat->name, 0, 2)) }}
                                </span>
                            </div>
                            <p class="text-sm font-medium text-darkBlue">{{ $cat->name }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

<x-frontend.footer-card />
