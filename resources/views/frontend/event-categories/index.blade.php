<x-frontend.frontend-layout />

<!-- Debug Message (Remove later if you want) -->
<script src="https://kit.fontawesome.com/YOUR_KIT_CODE.js" crossorigin="anonymous"></script>

<section class="py-12 bg-gray-50">
    <div class="container px-4 mx-auto">
        <!-- Section Title -->
        <div class="mb-12 text-center">
            <h2 class="text-3xl font-bold md:text-4xl text-darkBlue font-raleway">
                Explore Event Categories
            </h2>
            <p class="max-w-2xl mx-auto mt-4 text-lg text-gray-600">
                Choose the perfect category for your special occasion.
            </p>
        </div>

        <!-- 4 Cards Grid (Fixed 4 columns on all devices) -->
        @if(isset($eventCategories) && $eventCategories->count() > 0)
        <div class="grid grid-cols-1 gap-8 mx-auto sm:grid-cols-2 lg:grid-cols-3 max-w-7xl">
            @foreach($eventCategories->take(20) as $category)
            <!-- Optional: limit if too many -->
            <a href="#"
                class="block overflow-hidden transition-all duration-300 transform bg-white shadow-md group rounded-2xl hover:shadow-2xl hover:-translate-y-3">

                <div class="p-8 text-center">
                    <!-- Icon: Font Awesome → Custom SVG → Fallback -->
                    <div class="flex items-center justify-center h-32 mb-6">
                        @if($category->icon_type === 'fontawesome' && $category->icon_name)
                        <i class="{{ $category->icon_name }} text-7xl text-primary"></i>

                        @elseif($category->icon_type === 'custom' && $category->custom_svg)
                        <div class="w-28 h-28">
                            {!! $category->custom_svg !!}
                        </div>

                        @else
                        <div class="flex items-center justify-center w-24 h-24 rounded-full bg-primary/10">
                            <span class="text-4xl font-bold text-primary">
                                {{ strtoupper(substr($category->name ?? '??', 0, 2)) }}
                            </span>
                        </div>
                        @endif
                    </div>

                    <!-- Category Name -->
                    <h3
                        class="text-xl font-semibold transition-colors duration-300 md:text-2xl text-darkBlue font-raleway group-hover:text-primary">
                        {{ $category->name ?? 'No Name' }}
                    </h3>

                    <!-- Description -->
                    @if($category->description)
                    <p class="mt-4 text-sm text-gray-600 line-clamp-3">
                        {{ \Illuminate\Support\Str::limit($category->description, 100) }}
                    </p>
                    @endif

                    <!-- Hover Arrow -->
                    <div class="mt-6 transition-opacity duration-300 opacity-0 group-hover:opacity-100">
                        <svg class="mx-auto w-7 h-7 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        @else
        <div class="py-20 text-center bg-white shadow rounded-2xl">
            <p class="mb-4 text-2xl text-gray-500">No event categories available</p>
            <p class="text-gray-400">Please add active categories in the admin panel.</p>
        </div>
        @endif
    </div>
</section>

<x-frontend.footer-card />