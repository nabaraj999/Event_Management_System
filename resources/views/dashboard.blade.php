<x-frontend.frontend-layout />

<!-- ========== HERO ========== -->
<section class="relative min-h-screen flex items-center overflow-hidden">
    <!-- Background -->
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=1920"
             class="w-full h-full object-cover" alt="Events" />
        <div class="absolute inset-0 bg-gradient-to-r from-darkBlue/95 via-darkBlue/80 to-darkBlue/30"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-darkBlue/70 via-transparent to-transparent"></div>
    </div>

    <!-- Decorative Blobs -->
    <div class="absolute top-1/4 right-16 w-80 h-80 bg-primary/15 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-24 right-1/3 w-96 h-96 bg-blue-400/10 rounded-full blur-3xl pointer-events-none"></div>

    <!-- Content -->
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 w-full pt-32 pb-20">
        <div class="max-w-3xl">

            <!-- Badge -->
            <div class="inline-flex items-center gap-2.5 bg-white/10 backdrop-blur-md border border-white/20 text-white/90 text-sm font-bold px-5 py-2.5 rounded-full mb-8">
                <span class="relative flex h-2.5 w-2.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-green-400"></span>
                </span>
                Nepal's #1 Event Platform
            </div>

            <!-- Headline -->
            <h1 class="font-raleway text-5xl sm:text-6xl md:text-7xl font-black text-white leading-[1.1] mb-6">
                Discover &amp;<br>
                <span class="text-primary">Experience</span><br>
                Amazing Events
            </h1>

            <p class="text-lg sm:text-xl text-white/75 max-w-xl mb-10 leading-relaxed">
                From concerts to conferences — find, book, and attend the events that matter. Instant QR tickets, secure payments, no hassle.
            </p>

            <!-- CTAs -->
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('events.index') }}"
                   class="btn-primary group inline-flex items-center justify-center gap-3 px-8 py-4 text-white font-black text-lg rounded-2xl shadow-2xl shadow-primary/30">
                    <i class="fas fa-ticket-alt"></i>
                    Explore Events
                    <i class="fas fa-arrow-right text-sm transition-transform duration-300 group-hover:translate-x-1"></i>
                </a>
                <a href="{{ route('organizer.apply.form') }}"
                   class="inline-flex items-center justify-center gap-3 px-8 py-4 bg-white/15 backdrop-blur-md border-2 border-white/30 text-white font-bold text-lg rounded-2xl hover:bg-white hover:text-darkBlue transition-all duration-300">
                    <i class="fas fa-plus-circle"></i>
                    Create Event
                </a>
            </div>

            <!-- Stats Row -->
            <div class="flex flex-wrap gap-8 mt-16 pt-8 border-t border-white/15">
                <div>
                    <div class="text-3xl font-black text-white font-raleway">500+</div>
                    <div class="text-xs text-white/55 font-semibold uppercase tracking-wider mt-1">Events Listed</div>
                </div>
                <div>
                    <div class="text-3xl font-black text-white font-raleway">10K+</div>
                    <div class="text-xs text-white/55 font-semibold uppercase tracking-wider mt-1">Happy Users</div>
                </div>
                <div>
                    <div class="text-3xl font-black text-white font-raleway">50+</div>
                    <div class="text-xs text-white/55 font-semibold uppercase tracking-wider mt-1">Organizers</div>
                </div>
                <div>
                    <div class="text-3xl font-black text-white font-raleway">4.9★</div>
                    <div class="text-xs text-white/55 font-semibold uppercase tracking-wider mt-1">User Rating</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll hint -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-white/40 pointer-events-none">
        <span class="text-xs font-semibold uppercase tracking-widest">Scroll</span>
        <div class="w-px h-10 bg-gradient-to-b from-white/40 to-transparent"></div>
    </div>
</section>


<!-- ========== WHAT IS EVENTHUB ========== -->
<section class="py-24 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="grid lg:grid-cols-2 gap-16 items-center">

            <!-- Image side -->
            <div class="relative">
                <div class="absolute -top-6 -left-6 w-20 h-20 bg-primary/10 rounded-3xl"></div>
                <div class="absolute -bottom-6 -right-6 w-28 h-28 bg-darkBlue/8 rounded-full"></div>
                <div class="relative rounded-3xl overflow-hidden shadow-2xl">
                    <img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30?q=80&w=1200"
                         class="w-full h-[460px] object-cover" alt="EventHUB" />
                    <div class="absolute inset-0 bg-gradient-to-t from-darkBlue/20 to-transparent"></div>
                </div>
                <!-- Floating badge -->
                <div class="absolute -right-5 top-10 bg-white rounded-2xl shadow-xl p-4 flex items-center gap-3 border border-gray-100">
                    <div class="w-11 h-11 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-check-circle text-green-500 text-lg"></i>
                    </div>
                    <div>
                        <div class="font-black text-darkBlue text-sm">100% Digital</div>
                        <div class="text-xs text-gray-500 font-medium">Paperless tickets</div>
                    </div>
                </div>
                <!-- Floating stat -->
                <div class="absolute -left-5 bottom-10 bg-darkBlue rounded-2xl shadow-xl p-4 text-white">
                    <div class="text-2xl font-black font-raleway">10K+</div>
                    <div class="text-xs text-white/70 font-medium">Tickets Sold</div>
                </div>
            </div>

            <!-- Content side -->
            <div>
                <div class="inline-flex items-center gap-2 bg-orange-50 text-primary text-sm font-bold px-4 py-2 rounded-full mb-6">
                    <i class="fas fa-bolt text-xs"></i> Why EventHUB?
                </div>
                <h2 class="font-raleway text-4xl sm:text-5xl font-black text-darkBlue mb-6 leading-tight">
                    Nepal's Premier<br><span class="text-primary">Event Platform</span>
                </h2>
                <p class="text-gray-600 text-lg leading-relaxed mb-8">
                    EventHUB is Nepal's modern event discovery and ticketing platform. From large concerts to intimate workshops — find your next experience with ease.
                </p>

                <div class="space-y-3">
                    @foreach([
                        ['icon' => 'fa-qrcode',    'title' => 'Instant QR Tickets',    'desc' => 'Book and receive your digital ticket immediately after payment'],
                        ['icon' => 'fa-shield-alt', 'title' => 'Secure Payments',       'desc' => 'eSewa, Khalti, Card & Bank transfers all supported'],
                        ['icon' => 'fa-bell',       'title' => 'Smart Reminders',       'desc' => 'Never miss an event with automated email & push alerts'],
                        ['icon' => 'fa-users',      'title' => 'Trusted by Organizers', 'desc' => 'Professional tools to create and manage events at scale'],
                    ] as $f)
                        <div class="flex items-center gap-4 p-4 rounded-2xl group hover:bg-orange-50 transition-colors duration-200 cursor-default">
                            <div class="w-12 h-12 bg-orange-100 group-hover:bg-primary rounded-xl flex items-center justify-center flex-shrink-0 transition-colors duration-200">
                                <i class="fas {{ $f['icon'] }} text-primary group-hover:text-white text-lg transition-colors duration-200"></i>
                            </div>
                            <div>
                                <div class="font-black text-darkBlue text-sm">{{ $f['title'] }}</div>
                                <div class="text-xs text-gray-500 mt-0.5">{{ $f['desc'] }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    <a href="{{ route('events.index') }}" class="btn-primary inline-flex items-center gap-2 px-7 py-3.5 text-white font-bold rounded-xl shadow-lg">
                        Browse All Events <i class="fas fa-arrow-right text-sm"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- ========== CATEGORIES ========== -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="flex items-end justify-between mb-10">
            <div>
                <p class="text-primary font-bold text-xs mb-2 uppercase tracking-widest">Browse by Type</p>
                <h2 class="font-raleway text-4xl font-black text-darkBlue">Event Categories</h2>
            </div>
            <a href="{{ route('event-categories.index') }}" class="hidden sm:flex items-center gap-2 text-primary font-bold text-sm hover:underline">
                View All <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>

        <div class="flex space-x-4 overflow-x-auto scrollbar-hide pb-3">
            @forelse ($categories as $category)
                <a href="{{ route('events.category', $category->slug) }}"
                   class="group min-w-[150px] flex-shrink-0 flex flex-col items-center gap-3 p-6 bg-white rounded-2xl shadow-sm border-2 border-transparent hover:border-primary hover:shadow-md transition-all duration-300 text-center">
                    <div class="w-14 h-14 bg-orange-50 group-hover:bg-primary rounded-2xl flex items-center justify-center transition-all duration-300 shadow-sm">
                        @if ($category->icon_type === 'fontawesome' && $category->icon_name)
                            <i class="fas {{ $category->icon_name }} text-primary group-hover:text-white text-2xl transition-colors duration-300"></i>
                        @elseif ($category->icon_type === 'custom' && $category->custom_svg)
                            <div class="h-7 w-7 text-primary group-hover:text-white transition-colors duration-300">
                                {!! $category->custom_svg !!}
                            </div>
                        @else
                            <i class="fas fa-calendar-alt text-primary group-hover:text-white text-2xl transition-colors duration-300"></i>
                        @endif
                    </div>
                    <p class="font-black text-gray-800 text-sm group-hover:text-primary transition-colors duration-200">{{ $category->name }}</p>
                </a>
            @empty
                <p class="text-gray-500 py-8 text-sm">No categories available.</p>
            @endforelse
        </div>
    </div>
</section>


<!-- ========== TRENDING EVENTS ========== -->
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="flex items-end justify-between mb-12">
            <div>
                <p class="text-primary font-bold text-xs mb-2 uppercase tracking-widest">Hot Right Now</p>
                <h2 class="font-raleway text-4xl font-black text-darkBlue">Trending Events</h2>
            </div>
            <a href="{{ route('events.index') }}" class="hidden sm:flex items-center gap-2 text-primary font-bold text-sm hover:underline">
                View All <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($events as $event)
                <article class="card-hover group bg-white rounded-3xl overflow-hidden shadow-md border border-gray-100">
                    <!-- Image -->
                    <div class="relative overflow-hidden h-56">
                        <img src="{{ $event->banner_image ? asset('storage/' . $event->banner_image) : 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=800' }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                             alt="{{ $event->title }}" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>

                        @if($event->category)
                            <div class="absolute top-4 left-4">
                                <span class="bg-primary/90 backdrop-blur-sm text-white text-xs font-bold px-3 py-1.5 rounded-full">{{ $event->category->name }}</span>
                            </div>
                        @endif
                        @if($event->is_featured ?? false)
                            <div class="absolute top-4 right-4">
                                <span class="bg-yellow-400 text-yellow-900 text-xs font-bold px-3 py-1.5 rounded-full flex items-center gap-1 shadow-md">
                                    <i class="fas fa-star text-xs"></i> Featured
                                </span>
                            </div>
                        @endif

                        <div class="absolute bottom-4 left-4 right-4 flex items-center gap-3 text-white text-xs font-semibold">
                            <span class="flex items-center gap-1 drop-shadow"><i class="fas fa-map-marker-alt text-primary"></i> {{ Str::limit($event->location, 22) }}</span>
                        </div>
                    </div>

                    <!-- Body -->
                    <div class="p-6">
                        <div class="flex items-center gap-2 text-xs text-gray-500 mb-3">
                            <i class="fas fa-calendar-alt text-primary"></i>
                            <span>{{ $event->start_date->format('F d, Y') }}</span>
                        </div>

                        <h3 class="font-raleway font-black text-xl text-darkBlue mb-4 line-clamp-2 group-hover:text-primary transition-colors duration-200">
                            {{ $event->title }}
                        </h3>

                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <a href="{{ route('events.show', $event) }}"
                               class="text-sm font-bold text-gray-500 hover:text-primary transition-colors flex items-center gap-1.5">
                                View Details <i class="fas fa-chevron-right text-xs"></i>
                            </a>
                            <a href="{{ route('events.show', $event) }}"
                               class="px-5 py-2.5 bg-primary text-white text-sm font-bold rounded-xl hover:bg-darkBlue transition-colors shadow-md hover:shadow-lg">
                                Book Now
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-3 text-center py-20">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-calendar-times text-gray-400 text-3xl"></i>
                    </div>
                    <p class="text-xl text-gray-500 font-bold">No trending events right now.</p>
                    <p class="text-gray-400 text-sm mt-2">Check back soon for upcoming events!</p>
                </div>
            @endforelse
        </div>

        <div class="text-center mt-10 sm:hidden">
            <a href="{{ route('events.index') }}" class="btn-primary inline-flex items-center gap-2 px-8 py-3 text-white font-bold rounded-xl">
                View All Events <i class="fas fa-arrow-right text-sm"></i>
            </a>
        </div>
    </div>
</section>


<x-frontend.feature-card />


<!-- ========== FEATURED ORGANIZERS ========== -->
@if($organizers->count() > 0)
<section class="py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-16">
            <p class="text-primary font-bold text-xs mb-3 uppercase tracking-widest">The People Behind Events</p>
            <h2 class="font-raleway text-4xl sm:text-5xl font-black text-darkBlue">Featured Organizers</h2>
            <p class="text-lg text-gray-500 max-w-xl mx-auto mt-4">Meet the passionate hosts creating unforgettable experiences</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($organizers as $organizer)
                <div class="card-hover group bg-white rounded-3xl shadow-md border border-gray-100 overflow-hidden">
                    <!-- Image -->
                    <div class="relative h-64 overflow-hidden">
                        @if($organizer->profile_image)
                            <img src="{{ Storage::disk('public')->url($organizer->profile_image) }}"
                                 alt="{{ $organizer->organization_name }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-darkBlue to-blue-600 flex items-center justify-center">
                                <i class="fas fa-building text-8xl text-white/20"></i>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/10 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                            <h3 class="font-raleway text-xl font-black">{{ $organizer->organization_name }}</h3>
                            <p class="text-sm text-white/75 flex items-center gap-1.5 mt-1">
                                <i class="fas fa-user text-xs"></i> {{ $organizer->contact_person }}
                            </p>
                        </div>
                    </div>

                    <!-- Body -->
                    <div class="p-6">
                        <p class="text-gray-500 text-sm leading-relaxed mb-5 line-clamp-2">
                            {{ $organizer->description ? Str::limit($organizer->description, 110) : 'Creating memorable events and unforgettable experiences for every occasion.' }}
                        </p>
                        <div class="flex items-center gap-2 text-sm text-gray-500 mb-5">
                            <i class="fas fa-map-marker-alt text-primary text-xs"></i>
                            <span class="font-medium">{{ $organizer->formatted_address }}</span>
                        </div>
                        <a href="{{ route('organizers.show', $organizer) }}"
                           class="flex items-center justify-center gap-2 w-full py-3 bg-darkBlue text-white font-bold rounded-xl hover:bg-primary transition-colors duration-300">
                            View Profile & Events
                            <i class="fas fa-arrow-right text-sm transition-transform duration-300 group-hover:translate-x-1"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-14">
            <a href="#" class="inline-flex items-center gap-3 px-10 py-4 bg-darkBlue text-white font-bold text-lg rounded-2xl hover:bg-primary transition-all duration-300 shadow-xl hover:shadow-2xl">
                Explore All Organizers <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>
@endif


<!-- ========== CTA BAND ========== -->
<section class="py-24 bg-gradient-to-br from-darkBlue via-[#0a4f9e] to-darkBlue relative overflow-hidden">
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-primary/15 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-300/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 text-center text-white">
        <div class="w-16 h-16 bg-primary/20 rounded-2xl flex items-center justify-center mx-auto mb-8 border border-primary/30">
            <i class="fas fa-rocket text-primary text-2xl"></i>
        </div>
        <h2 class="font-raleway text-4xl sm:text-5xl font-black mb-6 leading-tight">
            Ready to Host Your<br><span class="text-primary">Next Event?</span>
        </h2>
        <p class="text-xl text-white/60 max-w-2xl mx-auto mb-10">
            Join hundreds of organizers who trust EventHUB to manage, promote, and sell tickets for their events.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('organizer.apply.form') }}"
               class="btn-primary inline-flex items-center justify-center gap-3 px-10 py-4 text-white font-bold text-lg rounded-2xl shadow-2xl shadow-primary/30">
                <i class="fas fa-plus-circle"></i> Start Creating Events
            </a>
            <a href="{{ route('contact') }}"
               class="inline-flex items-center justify-center gap-3 px-10 py-4 bg-white/10 border-2 border-white/25 text-white font-bold text-lg rounded-2xl hover:bg-white/20 transition-all duration-300">
                <i class="fas fa-headset"></i> Contact Sales
            </a>
        </div>
    </div>
</section>


<x-frontend.footer-card />


<!-- ========== INTEREST MODAL ========== -->
@if($showInterestModal)
<div id="interestModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-3xl shadow-2xl max-w-lg w-full relative overflow-hidden">
        <!-- Top accent bar -->
        <div class="h-1.5 bg-gradient-to-r from-primary to-orange-400"></div>

        <div class="p-8">
            <button type="button" onclick="closeModal()" class="absolute top-6 right-6 w-8 h-8 bg-gray-100 hover:bg-gray-200 rounded-full flex items-center justify-center transition-colors">
                <i class="fas fa-xmark text-gray-500 text-sm"></i>
            </button>

            <div class="w-14 h-14 bg-orange-100 rounded-2xl flex items-center justify-center mb-5">
                <i class="fas fa-heart text-primary text-xl"></i>
            </div>
            <h2 class="font-raleway text-2xl font-black text-darkBlue mb-2">Personalize Your Feed</h2>
            <p class="text-gray-500 text-sm mb-6">Tell us your interests and we'll show you better events. You can skip this anytime.</p>

            <form id="interestForm" action="{{ route('user.interests.store') }}" method="POST">
                @csrf

                <div class="mb-5">
                    <label class="block text-sm font-black text-gray-700 mb-3">Select Categories (optional)</label>
                    <div class="grid grid-cols-2 gap-2 max-h-48 overflow-y-auto pr-1">
                        @foreach($categories as $category)
                            <label class="flex items-center gap-2.5 cursor-pointer p-2.5 rounded-xl hover:bg-orange-50 transition-colors group">
                                <input type="checkbox" name="category_ids[]" value="{{ $category->id }}" id="category_{{ $category->id }}"
                                       class="w-4 h-4 text-primary focus:ring-primary rounded border-gray-300">
                                <span class="text-sm text-gray-700 group-hover:text-primary transition-colors font-medium">{{ $category->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="mb-6">
                    <label for="custom_interests" class="block text-sm font-black text-gray-700 mb-2">Add Custom Interests</label>
                    <input type="text" name="custom_interests" id="custom_interests"
                           placeholder="e.g., yoga, painting, tech talks"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm">
                </div>

                <div class="flex gap-3">
                    <button type="submit" onclick="this.form.submit()"
                            class="flex-1 px-5 py-3 border-2 border-gray-200 rounded-xl text-gray-600 font-bold hover:bg-gray-50 transition-colors text-sm">
                        Skip for Now
                    </button>
                    <button type="submit"
                            class="flex-1 px-5 py-3 bg-primary text-white rounded-xl font-bold hover:bg-darkBlue transition-colors text-sm shadow-md">
                        Save &amp; Continue
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('interestModal').style.display = 'flex';
    });
    function closeModal() {
        document.getElementById('interestModal').style.display = 'none';
    }
</script>
@endif

</body>
</html>
