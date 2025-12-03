
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

    <x-frontend.category-card />
    <x-frontend.event-card />
    <x-frontend.feature-card />
    <x-frontend.footer-card />

    <script>
        document.getElementById("mobile-toggle").onclick = () => {
            document.getElementById("mobile-menu").classList.toggle("hidden");
        };
    </script>

</body>
</html>
