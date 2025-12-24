<x-frontend.frontend-layout />

<style>
    .glass {
        background: linear-gradient(180deg, rgba(255, 255, 255, .88), rgba(255, 255, 255, .7));
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        border: 1px solid rgba(255, 255, 255, .6);
    }

    .soft-shadow {
        box-shadow: 0 25px 60px rgba(6, 57, 112, .12);
    }

    .hover-float:hover {
        transform: translateY(-6px);
    }
</style>

<section class="pt-16 pb-28 bg-gradient-to-b from-darkBlue/5 to-white">
    <div class="container mx-auto px-4 sm:px-6 max-w-7xl">

        <!-- HERO - Full Image Coverage -->
        <div class="relative rounded-[2rem] sm:rounded-[2.5rem] overflow-hidden soft-shadow h-[260px] sm:h-[340px] lg:h-[420px] mb-12 sm:mb-20">
            @if ($organizer->profile_image)
                <img src="{{ Storage::disk('public')->url($organizer->profile_image) }}"
                     alt="{{ $organizer->organization_name }}"
                     class="absolute inset-0 w-full h-full object-cover">
            @else
                <div class="absolute inset-0 w-full h-full bg-gradient-to-br from-primary/30 to-darkBlue/30 flex items-center justify-center">
                    <i class="fas fa-building text-7xl sm:text-9xl text-primary/50"></i>
                </div>
            @endif

            <!-- Dark gradient overlay for text readability -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>

            <!-- Glass panel with name and contact -->
            <div class="absolute bottom-0 left-0 right-0 p-5 sm:p-8 lg:p-12 glass">
                <h1 class="text-2xl sm:text-4xl lg:text-7xl font-black tracking-tight text-darkBlue">
                    {{ $organizer->organization_name }}
                </h1>
                <p class="text-sm sm:text-lg lg:text-2xl mt-1 sm:mt-2 flex items-center gap-2 sm:gap-3 text-darkBlue/90">
                    <i class="fas fa-user"></i>
                    <span>{{ $organizer->contact_person }}</span>
                </p>
            </div>
        </div>

        <!-- Main Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 sm:gap-12">

            <!-- LEFT: About & Contact -->
            <div class="space-y-8 sm:space-y-10">
                <!-- About Us -->
                <div class="glass rounded-2xl sm:rounded-3xl p-5 sm:p-8 soft-shadow">
                    <h2 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-darkBlue mb-4 sm:mb-6">
                        About Us
                    </h2>
                    <p class="text-gray-700 text-sm sm:text-base lg:text-lg leading-relaxed">
                        {{ $organizer->description ?? 'Dedicated to creating memorable experiences through world-class events.' }}
                    </p>
                </div>

                <!-- Contact & Links -->
                <div class="glass rounded-2xl sm:rounded-3xl p-5 sm:p-8 soft-shadow space-y-4 sm:space-y-6">
                    <h3 class="text-lg sm:text-xl lg:text-2xl font-extrabold text-darkBlue">
                        Contact & Links
                    </h3>

                    <div class="flex gap-3 sm:gap-4 text-sm sm:text-base text-gray-700">
                        <i class="fas fa-map-marker-alt text-primary text-xl w-6"></i>
                        <span>{{ $organizer->formatted_address }}</span>
                    </div>

                    @if ($organizer->website && filter_var($organizer->website, FILTER_VALIDATE_URL))
                        <div class="flex gap-3 sm:gap-4 text-sm sm:text-base text-gray-700">
                            <i class="fas fa-globe text-primary text-xl w-6"></i>
                            <a href="{{ $organizer->website }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="text-primary break-all hover:underline">
                                {{ Str::after($organizer->website, '://') }}
                            </a>
                        </div>
                    @endif

                    @if ($organizer->phone)
                        <div class="flex gap-3 sm:gap-4 text-sm sm:text-base text-gray-700">
                            <i class="fas fa-phone text-primary text-xl w-6"></i>
                            <span>{{ $organizer->phone }}</span>
                        </div>
                    @endif

                    @if ($organizer->email)
                        <div class="flex gap-3 sm:gap-4 text-sm sm:text-base text-gray-700">
                            <i class="fas fa-envelope text-primary text-xl w-6"></i>
                            <a href="mailto:{{ $organizer->email }}"
                               class="text-primary hover:underline">
                                {{ $organizer->email }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- RIGHT: Events -->
            <div class="lg:col-span-2">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6 sm:mb-8">
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-darkBlue">Events</h2>
                    <span class="text-sm sm:text-lg text-gray-600">{{ $events->count() }} Event{{ $events->count() !== 1 ? 's' : '' }}</span>
                </div>

                @if ($events->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 sm:gap-8">
                        @foreach ($events as $event)
                            <a href="{{ route('events.show', $event->slug ?? $event->id) }}"
                               class="group bg-white rounded-2xl sm:rounded-[2rem] soft-shadow hover-float transition-all overflow-hidden border border-gray-100">
                                <div class="relative h-44 sm:h-56 overflow-hidden">
                                    @if ($event->banner_image)
                                        <img src="{{ Storage::disk('public')->url($event->banner_image) }}"
                                             alt="{{ $event->title }}"
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-primary/20 to-darkBlue/20 flex items-center justify-center">
                                            <i class="fas fa-calendar-alt text-6xl text-primary/40"></i>
                                        </div>
                                    @endif
                                    <div class="absolute top-4 right-4 bg-primary text-white text-xs px-4 py-1 rounded-full font-bold">
                                        Event
                                    </div>
                                </div>

                                <div class="p-5 sm:p-6">
                                    <h3 class="text-lg sm:text-xl lg:text-2xl font-bold text-darkBlue mb-2">
                                        {{ $event->title }}
                                    </h3>
                                    <p class="text-gray-700 text-sm sm:text-base line-clamp-2 mb-4">
                                        {{ Str::limit($event->description ?? '', 100) }}
                                    </p>
                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center gap-2 text-xs sm:text-sm text-gray-600">
                                            <i class="fas fa-map-marker-alt text-primary"></i>
                                            <span>{{ Str::limit($event->location ?? '', 30) }}</span>
                                        </div>
                                        <span class="text-primary font-extrabold group-hover:translate-x-2 transition-transform">
                                            View →
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="bg-gray-50 rounded-3xl p-16 text-center soft-shadow">
                        <i class="fas fa-calendar-times text-7xl text-gray-300 mb-6"></i>
                        <p class="text-xl text-gray-600">No upcoming events at this time.</p>
                        <p class="text-gray-500 mt-2">Stay tuned for exciting announcements!</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Back Button -->
        <div class="text-center mt-16">
            <a href="{{ url()->previous() }}"
               class="inline-flex items-center justify-center px-8 sm:px-12 py-4 sm:py-5 bg-gradient-to-r from-darkBlue to-primary text-white font-extrabold text-lg rounded-xl sm:rounded-2xl shadow-xl hover:scale-105 transition-all duration-300">
                ← Back to Previous Page
            </a>
        </div>
    </div>
</section>
