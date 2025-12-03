
<x-frontend.frontend-layout />
    <!-- HERO -->
    <section class="relative h-[90vh] flex items-center">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1521336575822-6da63fb45455?q=80&w=1920"
                class="w-full h-full object-cover" />
            <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/60 to-transparent"></div>
        </div>

        <div class="relative max-w-4xl mx-auto px-6 text-white">
            <h1 class="text-6xl font-black leading-tight">
                Discover Nepal’s Most Amazing <span class="text-primary">Events</span>
            </h1>
            <p class="text-xl mt-5 opacity-90">Concerts • Festivals • College Fests • Workshops</p>

            <div class="flex flex-col sm:flex-row mt-10 gap-6">
                <a href="#" class="px-10 py-4 bg-primary text-white rounded-full font-bold text-lg hover:opacity-90">
                    <i class="fas fa-ticket mr-2"></i> Explore Events
                </a>
                <a href="#"
                    class="px-10 py-4 bg-white/20 backdrop-blur-lg border border-white rounded-full text-white font-bold text-lg hover:bg-white hover:text-darkBlue">
                    <i class="fas fa-plus mr-2"></i> Create Event
                </a>
            </div>
        </div>
    </section>
    <x-frontend.category-card />
    <x-frontend.event-card />
    <x-frontend.footer-card />

    <script>
        document.getElementById("mobile-toggle").onclick = () => {
            document.getElementById("mobile-menu").classList.toggle("hidden");
        };
    </script>

</body>
</html>
