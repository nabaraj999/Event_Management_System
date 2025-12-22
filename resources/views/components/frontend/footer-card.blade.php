<footer class="bg-darkBlue text-white py-16">
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-4 gap-10">

            <!-- Logo -->
            <div>
               <a href="{{ route('home') }}" class="inline-block p-2">
    @if ($company && $company->logo)
        <img src="{{ asset('storage/' . $company->logo) }}" alt="{{ $company->name ?? 'EventHUB' }} Logo"
            class="w-8 h-8 bg-white rounded-lg">
    @else
        <!-- Fallback Placeholder Logo -->
        <div class="w-8 h-8 text-lg flex items-center justify-center">
            {{ strtoupper(substr($company->name ?? 'EventHUB', 0, 1)) }}
        </div>
    @endif
</a>
                <p class="opacity-80 text-sm leading-relaxed">
                    Nepal’s complete digital event booking platform.
                    Discover, book, and manage events effortlessly.
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="font-bold text-lg mb-3">Quick Links</h4>
                <ul class="space-y-2 text-sm opacity-90">
                    <li><a href="#" class="hover:text-primary">Home</a></li>
                    <li><a href="#" class="hover:text-primary">Events</a></li>
                    <li><a href="#" class="hover:text-primary">Categories</a></li>
                    <li><a href="#" class="hover:text-primary">About Us</a></li>
                </ul>
            </div>

            <!-- Support -->
            <div>
                <h4 class="font-bold text-lg mb-3">Support</h4>
                <ul class="space-y-2 text-sm opacity-90">
                    <li><a href="#" class="hover:text-primary">Help Center</a></li>
                    <li><a href="#" class="hover:text-primary">FAQs</a></li>
                    <li><a href="#" class="hover:text-primary">Terms & Conditions</a></li>
                    <li><a href="#" class="hover:text-primary">Privacy Policy</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h4 class="font-bold text-lg mb-3">Contact</h4>
                <p class="text-sm opacity-90">Kathmandu, Nepal</p>
                <p class="text-sm opacity-90 mt-1">support@eventhub.com</p>
                <p class="text-sm opacity-90 mt-1">+977-9800000000</p>

                <div class="flex space-x-4 mt-4 text-xl">
                    <a href="#" class="hover:text-primary"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="hover:text-primary"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="hover:text-primary"><i class="fab fa-twitter"></i></a>
                </div>
            </div>

        </div>

        <p class="text-center text-sm mt-10 opacity-70">© 2025 EventHUB — All Rights Reserved.</p>
    </footer>
