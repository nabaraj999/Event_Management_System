<footer class="py-16 text-white bg-darkBlue">
    <div class="grid gap-10 px-6 mx-auto max-w-7xl md:grid-cols-4">

        <!-- Logo -->
        <div>
            <a href="{{ route('home') }}" class="inline-block p-2">
                @if ($company && $company->logo)
                <img src="{{ asset('storage/' . $company->logo) }}" alt="{{ $company->name ?? 'EventHUB' }} Logo"
                    class="w-8 h-8 bg-white rounded-lg">
                @else
                <!-- Fallback Placeholder Logo -->
                <div class="flex items-center justify-center w-8 h-8 text-lg">
                    {{ strtoupper(substr($company->name ?? 'EventHUB', 0, 1)) }}
                </div>
                @endif
            </a>
            <p class="text-sm leading-relaxed opacity-80">
                Nepal’s complete digital event booking platform.
                Discover, book, and manage events effortlessly.
            </p>
        </div>

        <!-- Quick Links -->
        <div>
            <h4 class="mb-3 text-lg font-bold">Quick Links</h4>
            <ul class="space-y-2 text-sm opacity-90">
                <li><a href="{{ route('home') }}" class="hover:text-primary">Home</a></li>
                <li><a href="{{ route('events.index') }}" class="hover:text-primary">Events</a></li>
                <li><a href="{{ route('event-categories.index') }}" class="hover:text-primary">Categories</a></li>
                <li><a href="{{ route('about') }}" class="hover:text-primary">About Us</a></li>
            </ul>
        </div>

        <!-- Support -->
        <div>
            <h4 class="mb-3 text-lg font-bold">Support</h4>
            <ul class="space-y-2 text-sm opacity-90">
                <li><a href="{{ route('contact') }}" class="hover:text-primary">Help Center</a></li>
                <li><a href="#" class="hover:text-primary">FAQs</a></li>
                <li><a href="#" class="hover:text-primary">Terms & Conditions</a></li>
                <li><a href="#" class="hover:text-primary">Privacy Policy</a></li>
            </ul>
        </div>

        <!-- Contact -->
        <div>
            <h4 class="mb-3 text-lg font-bold">Contact</h4>
            <p class="text-sm opacity-90">Kathmandu, Nepal</p>
            <p class="mt-1 text-sm opacity-90">support@eventhub.com</p>
            <p class="mt-1 text-sm opacity-90">+977-9800000000</p>

            <div class="flex mt-4 space-x-4 text-xl">
                <a href="#" class="hover:text-primary"><i class="fab fa-facebook"></i></a>
                <a href="#" class="hover:text-primary"><i class="fab fa-instagram"></i></a>
                <a href="#" class="hover:text-primary"><i class="fab fa-twitter"></i></a>
            </div>
        </div>

    </div>

    <p class="mt-10 text-sm text-center opacity-70">© 2026 EventHUB — All Rights Reserved.</p>
</footer>