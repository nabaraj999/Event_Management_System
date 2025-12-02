<x-frontend.frontend-layout />
<!-- Hero Section -->
<section class="relative h-screen flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=1920&q=80" alt="Event Crowd"
            class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-black/90 via-black/70 to-transparent"></div>
    </div>

    <div class="container mx-auto px-6 relative z-10 text-white">
        <div class="max-w-4xl">
            <h1 class="text-5xl md:text-7xl font-black leading-tight mb-6">
                Discover Amazing <span class="gradient-text">Events in Nepal</span>
            </h1>
            <p class="text-xl md:text-2xl mb-10 opacity-90 font-light">
                Book tickets instantly • Digital QR Passes • Pay with eSewa, Khalti & Cards
            </p>
            <div class="flex flex-col sm:flex-row gap-6">
                <a href="#"
                    class="px-10 py-5 bg-gradient-hero text-white text-lg font-bold rounded-full shadow-2xl hover:shadow-orange/50 transform hover:scale-105 transition-all duration-300 flex items-center justify-center">
                    <i class="fas fa-search mr-3"></i> Explore Events
                </a>
                @auth
                    <a href="#"
                        class="px-10 py-5 bg-white/20 backdrop-blur-md border-2 border-white text-white text-lg font-bold rounded-full hover:bg-white hover:text-deep-blue transition-all">
                        <i class="fas fa-plus mr-3"></i> Create Event
                    </a>
                @else
                    <a href="#"
                        class="px-10 py-5 bg-white/20 backdrop-blur-md border-2 border-white text-white text-lg font-bold rounded-full hover:bg-white hover:text-deep-blue transition-all">
                        <i class="fas fa-plus mr-3"></i> Create Your Event
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce">
        <i class="fas fa-chevron-down text-4xl text-white opacity-70"></i>
    </div>
</section>


<x-frontend.event-card />
<x-frontend.category-card />
<x-frontend.feature-card />
<x-frontend.footer-card />

<script>
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenu.classList.toggle('hidden');
    });
</script>
