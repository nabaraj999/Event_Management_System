<footer class="bg-darkBlue text-white">

    <!-- Newsletter Band -->
    <div class="bg-gradient-to-r from-primary to-orange-400 py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center">
            <div class="inline-flex items-center gap-2 bg-white/20 text-white text-xs font-bold px-4 py-1.5 rounded-full mb-4">
                <i class="fas fa-envelope text-xs"></i> Newsletter
            </div>
            <h3 class="font-raleway text-2xl sm:text-3xl font-black mb-3">Stay Updated on New Events</h3>
            <p class="text-white/80 text-sm mb-6">Get notified about exciting events happening near you</p>
            <form class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto">
                <input type="email" placeholder="Enter your email address"
                       class="flex-1 px-5 py-3.5 rounded-xl text-gray-800 font-medium focus:outline-none focus:ring-2 focus:ring-white/50 text-sm">
                <button type="submit" class="px-6 py-3.5 bg-darkBlue text-white font-bold rounded-xl hover:bg-blue-800 transition-colors shadow-lg text-sm flex-shrink-0">
                    Subscribe
                </button>
            </form>
        </div>
    </div>

    <!-- Main Footer Body -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-16">
        <div class="grid gap-12 md:grid-cols-4">

            <!-- Brand Column -->
            <div class="md:col-span-1">
                <a href="{{ route('home') }}" class="flex items-center gap-3 mb-5">
                    @if ($company && $company->logo)
                        <img src="{{ asset('storage/' . $company->logo) }}" alt="{{ $company->name ?? 'EventHUB' }} Logo" class="w-10 h-10 bg-white rounded-xl p-1 object-contain">
                    @else
                        <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center font-black text-xl">
                            {{ strtoupper(substr($company->name ?? 'E', 0, 1)) }}
                        </div>
                    @endif
                    <span class="font-raleway font-black text-xl">Event<span class="text-primary">HUB</span></span>
                </a>
                <p class="text-sm text-white/55 leading-relaxed mb-6">
                    Nepal's complete digital event booking platform. Discover, book, and manage events effortlessly.
                </p>
                <!-- Social Icons -->
                <div class="flex gap-2.5">
                    <a href="#" aria-label="Facebook" class="w-9 h-9 bg-white/10 hover:bg-primary rounded-lg flex items-center justify-center transition-colors duration-200">
                        <i class="fab fa-facebook-f text-sm"></i>
                    </a>
                    <a href="#" aria-label="Instagram" class="w-9 h-9 bg-white/10 hover:bg-primary rounded-lg flex items-center justify-center transition-colors duration-200">
                        <i class="fab fa-instagram text-sm"></i>
                    </a>
                    <a href="#" aria-label="Twitter/X" class="w-9 h-9 bg-white/10 hover:bg-primary rounded-lg flex items-center justify-center transition-colors duration-200">
                        <i class="fab fa-twitter text-sm"></i>
                    </a>
                    <a href="#" aria-label="TikTok" class="w-9 h-9 bg-white/10 hover:bg-primary rounded-lg flex items-center justify-center transition-colors duration-200">
                        <i class="fab fa-tiktok text-sm"></i>
                    </a>
                </div>
            </div>

            <!-- Navigation -->
            <div>
                <h4 class="text-xs font-black uppercase tracking-widest text-white/35 mb-5">Navigation</h4>
                <ul class="space-y-3">
                    <li><a href="{{ route('home') }}" class="flex items-center gap-2.5 text-sm text-white/65 hover:text-primary transition-colors font-medium group"><i class="fas fa-chevron-right text-xs text-primary/40 group-hover:text-primary transition-colors"></i> Home</a></li>
                    <li><a href="{{ route('events.index') }}" class="flex items-center gap-2.5 text-sm text-white/65 hover:text-primary transition-colors font-medium group"><i class="fas fa-chevron-right text-xs text-primary/40 group-hover:text-primary transition-colors"></i> Events</a></li>
                    <li><a href="{{ route('event-categories.index') }}" class="flex items-center gap-2.5 text-sm text-white/65 hover:text-primary transition-colors font-medium group"><i class="fas fa-chevron-right text-xs text-primary/40 group-hover:text-primary transition-colors"></i> Categories</a></li>
                    <li><a href="{{ route('about') }}" class="flex items-center gap-2.5 text-sm text-white/65 hover:text-primary transition-colors font-medium group"><i class="fas fa-chevron-right text-xs text-primary/40 group-hover:text-primary transition-colors"></i> About Us</a></li>
                    <li><a href="{{ route('contact') }}" class="flex items-center gap-2.5 text-sm text-white/65 hover:text-primary transition-colors font-medium group"><i class="fas fa-chevron-right text-xs text-primary/40 group-hover:text-primary transition-colors"></i> Contact</a></li>
                </ul>
            </div>

            <!-- Support -->
            <div>
                <h4 class="text-xs font-black uppercase tracking-widest text-white/35 mb-5">Support</h4>
                <ul class="space-y-3">
                    <li><a href="{{ route('contact') }}" class="flex items-center gap-2.5 text-sm text-white/65 hover:text-primary transition-colors font-medium group"><i class="fas fa-chevron-right text-xs text-primary/40 group-hover:text-primary transition-colors"></i> Help Center</a></li>
                    <li><a href="#" class="flex items-center gap-2.5 text-sm text-white/65 hover:text-primary transition-colors font-medium group"><i class="fas fa-chevron-right text-xs text-primary/40 group-hover:text-primary transition-colors"></i> FAQs</a></li>
                    <li><a href="#" class="flex items-center gap-2.5 text-sm text-white/65 hover:text-primary transition-colors font-medium group"><i class="fas fa-chevron-right text-xs text-primary/40 group-hover:text-primary transition-colors"></i> Terms &amp; Conditions</a></li>
                    <li><a href="#" class="flex items-center gap-2.5 text-sm text-white/65 hover:text-primary transition-colors font-medium group"><i class="fas fa-chevron-right text-xs text-primary/40 group-hover:text-primary transition-colors"></i> Privacy Policy</a></li>
                    <li><a href="{{ route('organizer.apply') }}" class="flex items-center gap-2.5 text-sm text-white/65 hover:text-primary transition-colors font-medium group"><i class="fas fa-chevron-right text-xs text-primary/40 group-hover:text-primary transition-colors"></i> Become Organizer</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h4 class="text-xs font-black uppercase tracking-widest text-white/35 mb-5">Contact</h4>
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-white/8 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i class="fas fa-map-marker-alt text-primary text-sm"></i>
                        </div>
                        <span class="text-sm text-white/65 font-medium leading-relaxed">Kathmandu, Nepal</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-white/8 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-envelope text-primary text-sm"></i>
                        </div>
                        <span class="text-sm text-white/65 font-medium">support@eventhub.com</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-white/8 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-phone text-primary text-sm"></i>
                        </div>
                        <span class="text-sm text-white/65 font-medium">+977-9800000000</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="border-t border-white/8 py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p class="text-xs text-white/35 font-medium">© 2026 EventHUB — All Rights Reserved.</p>
            <p class="text-xs text-white/35 font-medium">Made with <i class="fas fa-heart text-primary text-xs mx-0.5"></i> in Nepal</p>
        </div>
    </div>

</footer>
