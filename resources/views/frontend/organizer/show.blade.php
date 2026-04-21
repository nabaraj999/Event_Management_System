<x-frontend.frontend-layout />

<!-- Organizer Hero Banner -->
<div class="relative h-72 sm:h-96 md:h-[420px] overflow-hidden mt-16">
    @if ($organizer->profile_image)
        <img src="{{ Storage::disk('public')->url($organizer->profile_image) }}"
             alt="{{ $organizer->organization_name }}"
             class="absolute inset-0 w-full h-full object-cover">
    @else
        <div class="absolute inset-0 bg-gradient-to-br from-darkBlue to-[#0a4f9e] flex items-center justify-center">
            <i class="fas fa-building text-[10rem] text-white/10"></i>
        </div>
    @endif

    <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/30 to-transparent"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-darkBlue/40 to-transparent"></div>

    <!-- Name overlay -->
    <div class="absolute bottom-0 left-0 right-0 p-6 sm:p-10 max-w-7xl mx-auto">
        <div class="flex flex-wrap items-end gap-4">
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <span class="bg-primary/90 text-white text-xs font-black px-3 py-1.5 rounded-full backdrop-blur-sm">
                        <i class="fas fa-star text-xs mr-1"></i> Verified Organizer
                    </span>
                </div>
                <h1 class="font-raleway text-3xl sm:text-4xl md:text-5xl font-black text-white leading-tight">
                    {{ $organizer->organization_name }}
                </h1>
                <p class="text-white/75 flex items-center gap-2 mt-2 text-sm sm:text-base font-medium">
                    <i class="fas fa-user text-primary text-xs"></i>
                    {{ $organizer->contact_person }}
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Content -->
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

            <!-- LEFT SIDEBAR -->
            <aside class="lg:col-span-1 space-y-6 lg:sticky lg:top-20 lg:self-start">

                <!-- About Card -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex items-center gap-3">
                        <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-info-circle text-primary text-sm"></i>
                        </div>
                        <h2 class="font-raleway font-black text-darkBlue">About Us</h2>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 text-sm leading-relaxed">
                            {{ $organizer->description ?? 'Dedicated to creating memorable experiences through world-class events and unforgettable moments.' }}
                        </p>
                    </div>
                </div>

                <!-- Contact Card -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex items-center gap-3">
                        <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-address-card text-primary text-sm"></i>
                        </div>
                        <h2 class="font-raleway font-black text-darkBlue">Contact &amp; Links</h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <!-- Address -->
                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 bg-orange-50 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fas fa-map-marker-alt text-primary text-sm"></i>
                            </div>
                            <span class="text-gray-600 text-sm leading-relaxed pt-1.5">{{ $organizer->formatted_address }}</span>
                        </div>

                        @if ($organizer->website && filter_var($organizer->website, FILTER_VALIDATE_URL))
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 bg-orange-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-globe text-primary text-sm"></i>
                                </div>
                                <a href="{{ $organizer->website }}" target="_blank" rel="noopener noreferrer"
                                   class="text-primary text-sm font-semibold hover:underline break-all">
                                    {{ Str::after($organizer->website, '://') }}
                                </a>
                            </div>
                        @endif

                        @if ($organizer->phone)
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 bg-orange-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-phone text-primary text-sm"></i>
                                </div>
                                <span class="text-gray-600 text-sm font-medium">{{ $organizer->phone }}</span>
                            </div>
                        @endif

                        @if ($organizer->email)
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 bg-orange-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-envelope text-primary text-sm"></i>
                                </div>
                                <a href="mailto:{{ $organizer->email }}" class="text-primary text-sm font-semibold hover:underline">
                                    {{ $organizer->email }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Back Button -->
                <a href="{{ route('events.index') }}"
                   class="flex items-center justify-center gap-2 w-full py-3.5 border-2 border-gray-200 text-gray-600 font-bold rounded-xl hover:border-primary hover:text-primary transition-all duration-200 text-sm">
                    <i class="fas fa-arrow-left text-xs"></i> Back to Events
                </a>
            </aside>

            <!-- RIGHT: Events Grid -->
            <main class="lg:col-span-2">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <p class="text-primary font-bold text-xs mb-1 uppercase tracking-widest">Portfolio</p>
                        <h2 class="font-raleway text-2xl sm:text-3xl font-black text-darkBlue">Their Events</h2>
                    </div>
                    <span class="inline-flex items-center gap-2 bg-white border border-gray-200 px-4 py-2 rounded-full text-sm font-bold text-darkBlue shadow-sm">
                        <i class="fas fa-calendar-alt text-primary text-xs"></i>
                        {{ $events->count() }} Event{{ $events->count() !== 1 ? 's' : '' }}
                    </span>
                </div>

                @if ($events->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        @foreach ($events as $event)
                            <article class="card-hover group bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100">
                                <!-- Image -->
                                <div class="relative h-48 overflow-hidden">
                                    @if ($event->banner_image)
                                        <img src="{{ Storage::disk('public')->url($event->banner_image) }}"
                                             alt="{{ $event->title }}"
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-primary/15 to-darkBlue/15 flex items-center justify-center">
                                            <i class="fas fa-calendar-alt text-4xl text-primary/30"></i>
                                        </div>
                                    @endif
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                                    @if($event->category)
                                        <div class="absolute top-3 left-3">
                                            <span class="bg-primary/90 text-white text-xs font-black px-3 py-1.5 rounded-full backdrop-blur-sm">
                                                {{ $event->category->name }}
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Body -->
                                <div class="p-5">
                                    <h3 class="font-raleway font-black text-darkBlue text-base mb-2 line-clamp-2 group-hover:text-primary transition-colors duration-200">
                                        {{ $event->title }}
                                    </h3>

                                    <div class="flex flex-wrap items-center gap-3 text-xs text-gray-500 mb-4">
                                        @if($event->location)
                                            <span class="flex items-center gap-1.5 font-medium">
                                                <i class="fas fa-map-marker-alt text-primary"></i>
                                                {{ Str::limit($event->location, 22) }}
                                            </span>
                                        @endif
                                        @if($event->start_date)
                                            <span class="flex items-center gap-1.5 font-medium">
                                                <i class="fas fa-calendar text-primary"></i>
                                                {{ $event->start_date->format('M d, Y') }}
                                            </span>
                                        @endif
                                    </div>

                                    <a href="{{ route('events.show', $event) }}"
                                       class="flex items-center justify-between w-full pt-3 border-t border-gray-100 text-xs font-black group/link">
                                        <span class="text-primary hover:text-darkBlue transition-colors">View Details</span>
                                        <span class="w-7 h-7 bg-orange-50 group-hover/link:bg-primary rounded-lg flex items-center justify-center transition-all duration-200">
                                            <i class="fas fa-arrow-right text-primary group-hover/link:text-white text-xs transition-colors duration-200"></i>
                                        </span>
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 py-20 text-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-5">
                            <i class="fas fa-calendar-times text-gray-400 text-2xl"></i>
                        </div>
                        <h3 class="font-raleway font-black text-gray-600 text-lg mb-2">No Events Yet</h3>
                        <p class="text-gray-400 text-sm">This organizer hasn't listed any upcoming events.</p>
                        <a href="{{ route('events.index') }}"
                           class="inline-flex items-center gap-2 mt-6 px-6 py-3 bg-primary text-white font-bold rounded-xl hover:bg-darkBlue transition-colors text-sm shadow-md">
                            <i class="fas fa-search"></i> Browse All Events
                        </a>
                    </div>
                @endif
            </main>

        </div>
    </div>
</div>

<x-frontend.footer-card />
