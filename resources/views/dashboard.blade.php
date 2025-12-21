<x-frontend.frontend-layout />
<!-- HERO -->
<!-- HERO -->
<section class="relative h-[75vh] sm:h-[90vh] flex items-center">
    <!-- Background Image + Gradient -->
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1521336575822-6da63fb45455?q=80&w=1920"
            class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-gradient-to-r from-black/85 via-black/70 to-transparent"></div>
    </div>

    <!-- Content -->
    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 text-white">
        <h1 class="text-4xl sm:text-5xl md:text-7xl font-black leading-tight mb-4">
            Nepal’s Ultimate
            <span class="text-primary">Event Platform</span>
        </h1>

        <p class="text-base sm:text-lg md:text-xl opacity-90 max-w-lg">
            Book tickets easily • Instant QR passes • Secure payments
        </p>

        <!-- Buttons -->
        <div class="flex flex-col sm:flex-row mt-8 sm:mt-10 gap-4 sm:gap-6 w-full sm:w-auto">
            <a href="#"
                class="px-8 py-3 sm:px-10 sm:py-4 bg-primary text-white rounded-full font-bold text-base sm:text-lg text-center hover:opacity-90 transition">
                <i class="fas fa-ticket mr-2"></i> Explore Events
            </a>

            <a href="#"
                class="px-8 py-3 sm:px-10 sm:py-4 bg-white/20 backdrop-blur-md border border-white rounded-full text-white font-bold text-base sm:text-lg text-center hover:bg-white hover:text-darkBlue transition">
                <i class="fas fa-plus mr-2"></i> Create Event
            </a>
        </div>
    </div>
</section>



<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-14 items-center">

        <div>
            <h2 class="text-4xl font-extrabold text-darkBlue mb-4">What is EventHUB?</h2>
            <p class="text-gray-600 leading-relaxed">
                EventHUB is Nepal’s modern event booking and management platform.
                From large concerts to small workshops, our digital system helps users discover,
                book, and attend events effortlessly with QR tickets, online payments, reminders,
                and more.
            </p>

            <ul class="mt-6 space-y-3 text-gray-700">
                <li><i class="fas fa-check-circle text-primary mr-2"></i> Fully Digital Ticketing</li>
                <li><i class="fas fa-check-circle text-primary mr-2"></i> Organizer Tools</li>
                <li><i class="fas fa-check-circle text-primary mr-2"></i> Smart Notification System</li>
            </ul>
        </div>

        <img src="https://images.unsplash.com/photo-1526948128573-703ee1aeb6fa?q=80&w=1200"
            class="rounded-2xl shadow-xl" />

    </div>
</section>


<!-- CATEGORIES (Scrollable Horizontal) -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-3xl font-extrabold text-darkBlue mb-6">Event Categories</h2>

        <div class="flex space-x-6 overflow-x-auto scrollbar-hide py-2 scroll-smooth">
            @forelse ($categories as $category)
                <div class="min-w-[150px] flex-shrink-0 px-6 py-4 rounded-xl bg-softGray shadow hover:shadow-lg transition cursor-pointer text-center">

                    <!-- Icon Handling -->
                    @if ($category->icon_type === 'fontawesome' && $category->icon_name)
                        <i class="fas {{ $category->icon_name }} text-primary text-3xl mb-2"></i>

                    @elseif ($category->icon_type === 'custom' && $category->custom_svg)
                        <div class="h-8 w-8 mx-auto mb-2 text-primary">
                            {!! $category->custom_svg !!}
                        </div>

                    @else
                        <!-- Fallback icon -->
                        <i class="fas fa-calendar-alt text-primary text-3xl mb-2"></i>
                    @endif

                    <p class="font-semibold text-gray-800">{{ $category->name }}</p>
                </div>
            @empty
                <p class="text-gray-500 col-span-full text-center py-8">No categories available at the moment.</p>
            @endforelse
        </div>
    </div>
</section>


    <!-- TRENDING EVENTS -->
    <!-- TRENDING EVENTS -->
<section class="py-20 bg-softGray">
    <div class="max-w-7xl mx-auto px-6">

        <div class="flex justify-between items-center mb-10">
            <h2 class="text-3xl font-extrabold text-darkBlue text-center">Trending Events</h2>
            <a href="#" class="text-primary font-semibold hover:underline">View All Events</a>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-10">

            @forelse($events as $event)
                <div class="bg-white shadow-lg rounded-xl overflow-hidden transform transition hover:-translate-y-2 hover:shadow-2xl duration-300">
                    <img src="{{ $event->banner_image ? asset('storage/' . $event->banner_image) : 'https://via.placeholder.com/1200x520' }}" class="w-full h-52 object-cover" />
                    <div class="p-6">
                        <h3 class="font-bold text-xl">{{ $event->title }}</h3>
                        <p class="text-gray-600 text-sm mt-1">{{ $event->location }} • {{ $event->start_date->format('M d') }}</p>
                        <!-- Note: Your schema doesn't have a 'price' field. If you add $table->decimal('price', 8, 2)->nullable(); to the migration, you can use: -->
                        {{-- <p class="font-bold text-primary text-lg mt-2">Rs. {{ number_format($event->price ?? 0, 0) }}</p> --}}

                        <div class="mt-4 flex gap-3">
                            <a href="#" class="px-4 py-2 border border-primary rounded-lg text-primary font-semibold hover:bg-primary hover:text-white transition">View Details</a>
                            <a href="#" class="px-4 py-2 bg-primary text-white rounded-lg font-semibold hover:bg-darkBlue transition">Book Now</a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-600">No trending events available right now.</p>
            @endforelse

        </div>
    </div>
</section>

<x-frontend.feature-card />
<!-- Featured Organizers Section -->
@if($organizers->count() > 0)
    <section class="my-20">
        <div class="text-center mb-14">
            <h2 class="text-4xl lg:text-5xl font-extrabold text-darkBlue mb-4">Featured Organizers</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">Meet the passionate hosts bringing unforgettable events to life</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
            @foreach($organizers as $organizer)
                <div class="group relative bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-100">
                    <!-- Image Container -->
                    <div class="relative h-72 overflow-hidden">
                        @if($organizer->profile_image)
                            <img src="{{ Storage::disk('public')->url($organizer->profile_image) }}"
                                 alt="{{ $organizer->organization_name }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-primary/20 to-blue-100 flex items-center justify-center">
                                <i class="fas fa-building text-8xl text-primary/30"></i>
                            </div>
                        @endif

                        <!-- Overlay Gradient -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>

                        <!-- Name & Contact -->
                        <div class="absolute bottom-0 left-0 right-0 p-8 text-white transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                            <h3 class="text-2xl font-bold mb-1">{{ $organizer->organization_name }}</h3>
                            <p class="text-sm opacity-90 flex items-center gap-2">
                                <i class="fas fa-user"></i> {{ $organizer->contact_person }}
                            </p>
                        </div>

                        <!-- Glow Effect on Hover -->
                        <div class="absolute inset-0 rounded-3xl ring-4 ring-transparent group-hover:ring-primary/30 transition-all duration-500 pointer-events-none"></div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-8">
                        <p class="text-gray-700 leading-relaxed mb-6 line-clamp-3">
                            {{ $organizer->description ? Str::limit($organizer->description, 130) : 'Dedicated to creating memorable experiences through world-class events.' }}
                        </p>

                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <i class="fas fa-map-marker-alt text-primary"></i>
                                <span class="font-medium">{{ Str::limit($organizer->address, 35) }}</span>
                            </div>

                            @if($organizer->website)
                                <a href="{{ $organizer->website }}" target="_blank" class="text-primary hover:underline text-sm">
                                    <i class="fas fa-globe mr-1"></i> Website
                                </a>
                            @endif
                        </div>

                        <!-- View Button -->
                        <button onclick="openOrganizerModal({{ $organizer->toJson() }})"
                                class="w-full py-4 bg-gradient-to-r from-primary to-darkBlue text-white font-bold rounded-xl hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-3">
                            <span>View Profile & Events</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- See All Button -->
        <div class="text-center mt-14">
            <a href="#" class="inline-block px-10 py-5 bg-darkBlue text-white font-bold text-lg rounded-2xl hover:bg-primary transition shadow-xl hover:shadow-2xl">
                Explore All Organizers →
            </a>
        </div>
    </section>
@endif

<!-- Organizer Detail Modal -->
<div id="organizerModal" class="fixed inset-0 bg-black/70 hidden flex items-center justify-center z-50 p-4" onclick="closeOrganizerModal(event)">
    <div class="bg-white rounded-3xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto animate-fadeIn">
        <div class="relative h-80 bg-gradient-to-b from-primary/30 to-transparent rounded-t-3xl overflow-hidden">
            <img id="modalBanner" src="" alt="" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>

            <button onclick="closeOrganizerModal()" class="absolute top-6 right-6 text-white bg-black/50 hover:bg-black/70 rounded-full p-3 transition">
                <i class="fas fa-times text-2xl"></i>
            </button>

            <div class="absolute bottom-8 left-8 text-white">
                <h2 id="modalOrgName" class="text-4xl font-bold mb-2"></h2>
                <p id="modalContact" class="text-xl opacity-90 flex items-center gap-3">
                    <i class="fas fa-user"></i> <span></span>
                </p>
            </div>
        </div>

        <div class="p-10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div>
                    <h3 class="text-2xl font-bold text-darkBlue mb-4">About</h3>
                    <p id="modalDescription" class="text-gray-700 leading-relaxed text-lg"></p>

                    <div class="mt-8 space-y-4">
                        <div class="flex items-center gap-4 text-gray-700">
                            <i class="fas fa-map-marker-alt text-primary text-xl"></i>
                            <span id="modalAddress" class="text-lg"></span>
                        </div>
                        @if($organizer->website)
                            <div class="flex items-center gap-4">
                                <i class="fas fa-globe text-primary text-xl"></i>
                                <a id="modalWebsite" href="#" target="_blank" class="text-primary hover:underline text-lg"></a>
                            </div>
                        @endif
                    </div>
                </div>

                <div>
                    <h3 class="text-2xl font-bold text-darkBlue mb-6">Upcoming Events</h3>
                    <div id="modalEvents" class="space-y-4">
                        <!-- Events will be injected via JS -->
                        <p class="text-gray-500 italic">No upcoming events</p>
                    </div>
                </div>
            </div>

            <div class="mt-10 text-center">
                <button onclick="closeOrganizerModal()" class="px-10 py-4 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold rounded-xl transition">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".open-organizer-btn").forEach(button => {
        button.addEventListener("click", () => {
            const organizer = JSON.parse(button.dataset.organizer);
            openOrganizerModal(organizer);
        });
    });
});

function openOrganizerModal(organizer) {
    document.getElementById('modalOrgName').textContent = organizer.organization_name;
    document.getElementById('modalContact').innerHTML =
        `<i class="fas fa-user mr-2"></i>${organizer.contact_person || ''}`;

    document.getElementById('modalDescription').textContent =
        organizer.description || 'No description available.';

    document.getElementById('modalAddress').textContent =
        organizer.address || 'Location not specified';

    const banner = document.getElementById('modalBanner');
    banner.src = organizer.profile_image
        ? `/storage/${organizer.profile_image}`
        : `https://via.placeholder.com/1200x600/063970/ffffff?text=${encodeURIComponent(organizer.organization_name)}`;

    const websiteLink = document.getElementById('modalWebsite');
    if (organizer.website) {
        websiteLink.href = organizer.website;
        websiteLink.textContent = organizer.website.replace(/^https?:\/\//, '');
        websiteLink.parentElement.style.display = 'flex';
    } else {
        websiteLink.parentElement.style.display = 'none';
    }

    document.getElementById('modalEvents').innerHTML = `
        <div class="bg-gray-50 rounded-xl p-6 text-center">
            <i class="fas fa-calendar-alt text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-600">Event list coming soon</p>
        </div>
    `;

    document.getElementById('organizerModal').classList.remove('hidden');
}

function closeOrganizerModal(event) {
    if (event && event.target !== event.currentTarget) return;
    document.getElementById('organizerModal').classList.add('hidden');
}

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeOrganizerModal();
});
</script>


<style>
.animate-fadeIn {
    animation: fadeIn 0.4s ease-out;
}
@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}
</style>
<x-frontend.footer-card />


<!-- Add this modal to your dashboard.blade.php, probably at the end of the body -->
@if($showInterestModal)
    <div id="interestModal" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full p-8 relative">
            <button type="button" onclick="closeModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <h2 class="text-3xl font-bold text-center text-darkBlue mb-4">Share Your Interests</h2>
            <p class="text-center text-gray-600 mb-8">Help us show you better events! (You can skip this)</p>

            <form id="interestForm" action="{{ route('user.interests.store') }}" method="POST">
                @csrf

                <!-- Categories -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-800 mb-3">Select Categories (optional)</label>
                    <div class="grid grid-cols-2 gap-4 max-h-48 overflow-y-auto p-2 border border-gray-200 rounded-lg bg-gray-50">
                        @foreach($categories as $category)
                            <div class="flex items-center">
                                <input type="checkbox" name="category_ids[]" value="{{ $category->id }}" id="category_{{ $category->id }}" class="h-4 w-4 text-primary focus:ring-primary rounded">
                                <label for="category_{{ $category->id }}" class="ml-2 text-sm text-gray-700 cursor-pointer">{{ $category->name }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Custom Interests -->
                <div class="mb-6">
                    <label for="custom_interests" class="block text-sm font-semibold text-gray-800 mb-2">Add Your Own (comma-separated)</label>
                    <input type="text" name="custom_interests" id="custom_interests" placeholder="e.g., yoga, painting, tech talks" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-primary focus:ring-primary">
                </div>

                <div class="flex gap-4">
                    <!-- Skip Button: Submits empty form → marks as skipped -->
                    <button type="00submit" onclick="this.form.submit()" class="flex-1 px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-100 transition">
                        Skip for Now
                    </button>
                    <button type="submit" class="flex-1 px-6 py-3 bg-primary text-white rounded-lg font-semibold hover:bg-darkBlue transition">
                        Save & Continue
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Auto-show modal
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('interestModal').style.display = 'flex';
        });

        function closeModal() {
            document.getElementById('interestModal').style.display = 'none';
        }
    </script>
@endif

<script>
    document.getElementById("mobile-toggle").onclick = () => {
        document.getElementById("mobile-menu").classList.toggle("hidden");
    };
</script>

</body>


</html>
