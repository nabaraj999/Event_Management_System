<x-frontend.frontend-layout />

<!-- Category Hero -->
<div class="bg-gradient-to-br from-darkBlue via-[#0a4f9e] to-darkBlue pt-28 pb-16 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-96 h-96 bg-primary/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 text-center text-white">

        <!-- Category Icon -->
        <div class="w-20 h-20 bg-white/10 border border-white/20 rounded-2xl flex items-center justify-center mx-auto mb-6 backdrop-blur-sm">
            @if($category->icon_type === 'fontawesome' && $category->icon_name)
                <i class="{{ $category->icon_name }} text-primary text-3xl"></i>
            @elseif($category->icon_type === 'custom' && $category->custom_svg)
                <div class="w-10 h-10 text-white">{!! $category->custom_svg !!}</div>
            @else
                <span class="text-2xl font-black text-primary">{{ strtoupper(substr($category->name, 0, 2)) }}</span>
            @endif
        </div>

        <p class="text-primary font-bold text-xs mb-3 uppercase tracking-widest">Category</p>
        <h1 class="font-raleway text-4xl sm:text-5xl font-black mb-4">{{ $category->name }} Events</h1>

        @if($category->description)
            <p class="text-white/65 text-lg max-w-2xl mx-auto mb-4">{{ $category->description }}</p>
        @endif

        <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 px-5 py-2 rounded-full text-sm font-bold backdrop-blur-sm">
            <i class="fas fa-calendar-alt text-primary text-xs"></i>
            {{ $events->total() }} event{{ $events->total() !== 1 ? 's' : '' }} available
        </div>
    </div>
</div>

<!-- Events Grid -->
<section class="py-16 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">

        @if($events->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($events as $event)
                    <article class="card-hover group bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100">
                        <!-- Image -->
                        <div class="relative overflow-hidden h-48">
                            @if($event->banner_image)
                                <img src="{{ asset('storage/' . $event->banner_image) }}"
                                     alt="{{ $event->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-primary/15 to-darkBlue/15 flex items-center justify-center">
                                    <i class="fas fa-calendar-alt text-4xl text-primary/40"></i>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </div>

                        <!-- Body -->
                        <div class="p-5">
                            <h3 class="font-raleway font-black text-darkBlue text-base mb-2 line-clamp-2 group-hover:text-primary transition-colors duration-200">
                                {{ $event->title ?? 'Untitled Event' }}
                            </h3>

                            <div class="flex items-center gap-3 text-xs text-gray-500 mb-3">
                                <span class="flex items-center gap-1.5 font-medium">
                                    <i class="fas fa-map-marker-alt text-primary"></i>
                                    {{ Str::limit($event->location ?? '', 20) }}
                                </span>
                                <span class="flex items-center gap-1.5 font-medium">
                                    <i class="fas fa-calendar text-primary"></i>
                                    {{ $event->start_date?->format('M d, Y') ?? 'TBD' }}
                                </span>
                            </div>

                            @if($event->short_description ?? $event->description)
                                <p class="text-xs text-gray-400 line-clamp-2 mb-4 leading-relaxed">
                                    {{ Str::limit($event->short_description ?? $event->description, 80) }}
                                </p>
                            @endif

                            <a href="{{ route('events.show', $event) }}"
                               class="flex items-center justify-between w-full pt-3 border-t border-gray-100 text-xs font-black text-primary hover:text-darkBlue transition-colors group/link">
                                View Details
                                <i class="fas fa-arrow-right text-xs group-hover/link:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($events->hasPages())
                <div class="mt-12 flex justify-center">
                    {{ $events->links('pagination::tailwind') }}
                </div>
            @endif
        @else
            <div class="py-24 text-center bg-white rounded-3xl shadow-sm border border-gray-100">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-5">
                    <i class="fas fa-calendar-times text-gray-400 text-3xl"></i>
                </div>
                <h3 class="font-raleway text-xl font-black text-gray-600 mb-2">No Events Found</h3>
                <p class="text-gray-400 text-sm">There are currently no events in this category.</p>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 mt-6 px-6 py-3 bg-primary text-white font-bold rounded-xl hover:bg-darkBlue transition-colors text-sm">
                    <i class="fas fa-home"></i> Back to Home
                </a>
            </div>
        @endif

    </div>
</section>

<!-- Related Categories -->
@if($relatedCategories->count() > 0)
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-10">
                <p class="text-primary font-bold text-xs mb-2 uppercase tracking-widest">Explore More</p>
                <h2 class="font-raleway text-3xl font-black text-darkBlue">Other Categories</h2>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach($relatedCategories as $cat)
                    <a href="{{ route('events.category', $cat->slug) }}"
                       class="group flex flex-col items-center text-center p-5 bg-gray-50 rounded-2xl hover:bg-orange-50 border-2 border-transparent hover:border-primary transition-all duration-200">
                        <div class="w-12 h-12 bg-white group-hover:bg-primary rounded-xl flex items-center justify-center mb-3 shadow-sm transition-all duration-200">
                            @if($cat->icon_type === 'fontawesome' && $cat->icon_name)
                                <i class="{{ $cat->icon_name }} text-primary group-hover:text-white text-lg transition-colors"></i>
                            @else
                                <span class="text-base font-black text-primary group-hover:text-white transition-colors">{{ strtoupper(substr($cat->name, 0, 2)) }}</span>
                            @endif
                        </div>
                        <p class="text-xs font-black text-darkBlue group-hover:text-primary transition-colors">{{ $cat->name }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endif

<x-frontend.footer-card />
