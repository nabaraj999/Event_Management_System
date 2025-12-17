<x-frontend.frontend-layout>

    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <!-- Section Header -->
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-darkBlue font-raleway">
                    Explore Event Categories
                </h2>
                <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">
                    Discover our wide range of event types. Click on any category to view related events.
                </p>
            
            </div>

            <!-- Safe check for $eventCategories -->
            @if(!isset($eventCategories) || $eventCategories->isEmpty())
                <div class="text-center py-16">
                    <p class="text-xl text-gray-500">No event categories available at the moment.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @foreach($eventCategories as $category)
                        <a href="{{ route('events.category', $category->slug) }}"
                           class="group block bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-3 overflow-hidden">

                            <div class="p-8 text-center">
                                <!-- Icon Display with Safe Fallback -->
                                <div class="mb-6 flex justify-center items-center h-32">
                                    @if($category->icon_type === 'custom' && $category->custom_svg)
                                        <div class="w-24 h-24">
                                            {!! $category->custom_svg !!}
                                        </div>

                                    @elseif($category->icon_type === 'fontawesome' && $category->icon_name)
                                        <i class="{{ $category->icon_name }} text-6xl text-primary"></i>

                                    @elseif($category->icon_type === 'heroicon' || !$category->icon_type)
                                        @php
                                            $iconName = \Illuminate\Support\Str::kebab($category->icon_name ?? 'heart');
                                        @endphp
                                        @if(function_exists('svg'))
                                            <div class="w-24 h-24 text-primary">
                                                @svg('heroicon-o-' . $iconName, 'w-full h-full')
                                            </div>
                                        @else
                                            <!-- Fallback if blade-heroicons not installed -->
                                            <div class="w-24 h-24 bg-primary/10 rounded-full flex items-center justify-center">
                                                <span class="text-4xl font-bold text-primary">
                                                    {{ strtoupper(substr($category->name, 0, 2)) }}
                                                </span>
                                            </div>
                                        @endif

                                    @else
                                        <!-- Ultimate fallback: Initials -->
                                        <div class="w-24 h-24 bg-primary/10 rounded-full flex items-center justify-center">
                                            <span class="text-4xl font-bold text-primary">
                                                {{ strtoupper(substr($category->name, 0, 2)) }}
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Category Title -->
                                <h3 class="text-xl md:text-2xl font-semibold text-darkBlue font-raleway group-hover:text-primary transition-colors duration-300">
                                    {{ $category->name }}
                                </h3>

                                <!-- Optional Description -->
                                @if($category->description)
                                    <p class="mt-4 text-gray-600 text-sm line-clamp-3">
                                        {{ \Illuminate\Support\Str::limit($category->description, 100) }}
                                    </p>
                                @endif

                                <!-- Hover Arrow -->
                                <div class="mt-6 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <svg class="w-7 h-7 mx-auto text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

</x-frontend.frontend-layout>
