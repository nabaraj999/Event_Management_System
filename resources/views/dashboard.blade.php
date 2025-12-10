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
            @foreach ($categories as $category)
                <div
                    class="min-w-[150px] px-6 py-4 rounded-xl bg-softGray shadow hover:shadow-lg transition cursor-pointer text-center">
                    @if ($category->icon_type === 'fontawesome')
                        <i class="fas {{ $category->icon_name }} text-primary text-3xl mb-2"></i>
                    @elseif($category->icon_type === 'heroicon')
                        <!-- Assuming Heroicons usage; adjust based on your setup (e.g., via Blade component or inline SVG) -->
                        <x-heroicon-o-{{ $category->icon_name }} class="h-8 w-8 text-primary mb-2" />
                    @elseif($category->icon_type === 'custom' && $category->custom_svg)
                        {!! $category->custom_svg !!}
                    @else
                        <!-- Fallback icon if needed -->
                        <i class="fas fa-question-circle text-primary text-3xl mb-2"></i>
                    @endif
                    <p class="font-semibold">{{ $category->name }}</p>
                </div>
            @endforeach
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
<x-frontend.footer-card />

<script>
    document.getElementById("mobile-toggle").onclick = () => {
        document.getElementById("mobile-menu").classList.toggle("hidden");
    };
</script>

</body>

</html>
