<x-frontend.frontend-layout />

    <!-- Debug Message (Remove later if you want) -->
    <script src="https://kit.fontawesome.com/YOUR_KIT_CODE.js" crossorigin="anonymous"></script>

   <section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <!-- Section Title -->
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-darkBlue font-raleway">
                Explore Event Categories
            </h2>
            <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">
                Choose the perfect category for your special occasion.
            </p>
        </div>

        <!-- 4 Cards Grid (Fixed 4 columns on all devices) -->
        @if(isset($eventCategories) && $eventCategories->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
                @foreach($eventCategories->take(20) as $category) <!-- Optional: limit if too many -->
                    <a href="{{ route('events.category', $category->slug) }}"
                       class="group block bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-3 overflow-hidden">

                        <div class="p-8 text-center">
                            <!-- Icon: Font Awesome → Custom SVG → Fallback -->
                            <div class="mb-6 flex justify-center items-center h-32">
                                @if($category->icon_type === 'fontawesome' && $category->icon_name)
                                    <i class="{{ $category->icon_name }} text-7xl text-primary"></i>

                                @elseif($category->icon_type === 'custom' && $category->custom_svg)
                                    <div class="w-28 h-28">
                                        {!! $category->custom_svg !!}
                                    </div>

                                @else
                                    <div class="w-24 h-24 bg-primary/10 rounded-full flex items-center justify-center">
                                        <span class="text-4xl font-bold text-primary">
                                            {{ strtoupper(substr($category->name ?? '??', 0, 2)) }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <!-- Category Name -->
                            <h3 class="text-xl md:text-2xl font-semibold text-darkBlue font-raleway group-hover:text-primary transition-colors duration-300">
                                {{ $category->name ?? 'No Name' }}
                            </h3>

                            <!-- Description -->
                            @if($category->description)
                                <p class="mt-4 text-gray-600 text-sm line-clamp-3">
                                    {{ \Illuminate\Support\Str::limit($category->description, 100) }}
                                </p>
                            @endif

                            <!-- Hover Arrow -->
                            <div class="mt-6 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <svg class="w-7 h-7 mx-auto text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-20 bg-white rounded-2xl shadow">
                <p class="text-2xl text-gray-500 mb-4">No event categories available</p>
                <p class="text-gray-400">Please add active categories in the admin panel.</p>
            </div>
        @endif
    </div>
</section>

<x-frontend.footer-card />
