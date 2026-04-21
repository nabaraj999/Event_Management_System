<x-frontend.frontend-layout />

<!-- Page Header -->
<div class="bg-gradient-to-br from-darkBlue via-[#0a4f9e] to-darkBlue pt-28 pb-16 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-96 h-96 bg-primary/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-300/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 text-center text-white">
        <p class="text-primary font-bold text-xs mb-3 uppercase tracking-widest">Browse by Type</p>
        <h1 class="font-raleway text-4xl sm:text-5xl font-black mb-4">Event Categories</h1>
        <p class="text-white/60 text-lg max-w-xl mx-auto">Choose the perfect category and discover events that match your interests</p>
    </div>
</div>

<section class="py-16 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">

        @if(isset($eventCategories) && $eventCategories->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($eventCategories as $category)
                    <a href="{{ route('events.category', $category->slug) }}"
                       class="card-hover group bg-white rounded-3xl shadow-sm border-2 border-transparent hover:border-primary overflow-hidden text-center p-8 flex flex-col items-center">

                        <!-- Icon Container -->
                        <div class="w-20 h-20 bg-orange-50 group-hover:bg-primary rounded-2xl flex items-center justify-center mb-5 transition-all duration-300 shadow-sm flex-shrink-0">
                            @if($category->icon_type === 'fontawesome' && $category->icon_name)
                                <i class="{{ $category->icon_name }} text-primary group-hover:text-white text-3xl transition-colors duration-300"></i>
                            @elseif($category->icon_type === 'custom' && $category->custom_svg)
                                <div class="w-10 h-10 text-primary group-hover:text-white transition-colors duration-300">
                                    {!! $category->custom_svg !!}
                                </div>
                            @else
                                <div class="w-10 h-10 flex items-center justify-center">
                                    <span class="text-2xl font-black text-primary group-hover:text-white transition-colors duration-300">
                                        {{ strtoupper(substr($category->name ?? '??', 0, 2)) }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Category Name -->
                        <h3 class="font-raleway text-lg font-black text-darkBlue group-hover:text-primary transition-colors duration-200 mb-2">
                            {{ $category->name ?? 'No Name' }}
                        </h3>

                        @if($category->description)
                            <p class="text-sm text-gray-500 line-clamp-2 leading-relaxed">
                                {{ Str::limit($category->description, 80) }}
                            </p>
                        @endif

                        <!-- Arrow -->
                        <div class="mt-5 w-8 h-8 bg-gray-100 group-hover:bg-primary rounded-full flex items-center justify-center transition-all duration-300">
                            <i class="fas fa-arrow-right text-xs text-gray-400 group-hover:text-white transition-colors duration-300"></i>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="py-24 text-center bg-white rounded-3xl shadow-sm border border-gray-100">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-5">
                    <i class="fas fa-th-large text-gray-400 text-3xl"></i>
                </div>
                <h3 class="font-raleway text-xl font-black text-gray-600 mb-2">No Categories Yet</h3>
                <p class="text-gray-400 text-sm">Please add active categories from the admin panel.</p>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 mt-6 px-6 py-3 bg-primary text-white font-bold rounded-xl hover:bg-darkBlue transition-colors text-sm">
                    <i class="fas fa-home"></i> Back to Home
                </a>
            </div>
        @endif

    </div>
</section>

<x-frontend.footer-card />
