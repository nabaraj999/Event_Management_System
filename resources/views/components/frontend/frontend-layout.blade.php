<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    @php
        // Safety fallback: Ensure $pageSeo is always defined
        if (!isset($pageSeo)) {
            $routeName = request()->route()?->getName() ?? 'home';
            $pageSeo = \App\Models\SeoPage::getForPage($routeName);
        }
    @endphp

    <!-- ==================== DYNAMIC SEO TAGS ==================== -->
    <title>{{ $pageSeo?->meta_title ?? config('app.name', 'EventHUB') . ' | Discover Amazing Events' }}</title>

    @if($pageSeo?->meta_description)
        <meta name="description" content="{{ $pageSeo->meta_description }}">
    @endif

    @if($pageSeo?->meta_keywords)
        <meta name="keywords" content="{{ $pageSeo->meta_keywords }}">
    @endif

    <meta name="robots" content="{{ $pageSeo?->robots ?? 'index,follow' }}">

    @if($pageSeo?->canonical_url)
        <link rel="canonical" href="{{ $pageSeo->canonical_url }}">
    @else
        <link rel="canonical" href="{{ request()->fullUrl() }}">
    @endif

    <!-- Open Graph -->
    <meta property="og:title" content="{{ $pageSeo?->og_title ?? $pageSeo?->meta_title ?? config('app.name') }}">
    <meta property="og:description" content="{{ $pageSeo?->og_description ?? $pageSeo?->meta_description ?? 'Discover and book amazing events on EventHUB.' }}">
    <meta property="og:url" content="{{ request()->fullUrl() }}">
    <meta property="og:site_name" content="{{ config('app.name', 'EventHUB') }}">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="en_US">

    @if($pageSeo?->og_image)
        <meta property="og:image" content="{{ Storage::url($pageSeo->og_image) }}">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">
        <meta property="og:image:alt" content="{{ $pageSeo?->og_title ?? $pageSeo?->meta_title }}">
    @else
        <meta property="og:image" content="{{ asset('images/default-og.jpg') }}">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">
    @endif

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $pageSeo?->og_title ?? $pageSeo?->meta_title ?? config('app.name') }}">
    <meta name="twitter:description" content="{{ $pageSeo?->og_description ?? $pageSeo?->meta_description ?? 'Discover events on EventHUB.' }}">
    @if($pageSeo?->og_image)
        <meta name="twitter:image" content="{{ Storage::url($pageSeo->og_image) }}">
    @else
        <meta name="twitter:image" content="{{ asset('images/default-og.jpg') }}">
    @endif

    <!-- Favicon, Fonts, etc. -->
    <link rel="icon" href="{{ asset('storage/' . $company->favicon) }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;600;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { raleway: ["Raleway", "sans-serif"] },
                    colors: { primary: "#FF7A28", darkBlue: "#063970" },
                }
            }
        }
    </script>

    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
    </style>
</head> 

<body class="font-raleway bg-gray-50">

    <!-- NAVBAR -->
    <nav class="sticky top-0 z-50 bg-white shadow-md">
        <div class="max-w-7xl mx-auto flex items-center justify-between py-4 px-6">

            <!-- Logo -->
            <a href="{{ route('home') }}" class="inline-block p-2">
                @if ($company && $company->logo)
                    <img src="{{ asset('storage/' . $company->logo) }}" alt="{{ $company->name ?? 'EventHUB' }} Logo"
                        class="w-8 h-8 object-contain">
                @else
                    <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white font-bold text-xl">
                        {{ strtoupper(substr($company->name ?? 'EventHUB', 0, 1)) }}
                    </div>
                @endif
            </a>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-8 text-gray-700 font-medium">
                <a href="{{ route('home') }}" class="hover:text-primary transition">Home</a>
                <a href="{{ route('events.index') }}" class="hover:text-primary transition">Events</a>
                <a href="{{ route('event-categories.index') }}" class="hover:text-primary transition">Categories</a>
                <a href="{{ route('organizer.apply') }}" class="hover:text-primary transition">Become an Organizer</a>
                <a href="{{ route('about') }}" class="hover:text-primary transition">About Us</a>
                <a href="{{ route('contact') }}" class="hover:text-primary transition">Contact</a>
            </div>

            <!-- Right Section: Auth Buttons / Profile -->
            <div class="flex items-center space-x-4">
                @guest
                    <a href="{{ route('login') }}"
                        class="bg-darkBlue px-6 py-2 rounded-lg text-white font-semibold hover:bg-primary transition">
                        Login
                    </a>
                @else
                    <div class="relative group">
                        <button class="flex items-center space-x-3 text-gray-700 focus:outline-none">
                            <div class="w-10 h-10 bg-darkBlue rounded-full flex items-center justify-center text-white text-lg font-bold">
                                <i class="fas fa-user"></i>
                            </div>
                            <span class="hidden lg:block font-medium">{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down text-sm text-gray-500 group-hover:text-primary transition"></i>
                        </button>

                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <a href="{{ route('user.profile.edit') }}"
                                class="block px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-primary transition">My Profile</a>
                            <a href="{{ route('user.profile.history') }}"
                                class="block px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-primary transition">My Events</a>
                            <hr class="my-1 border-gray-200">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-primary transition">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @endguest

                <!-- Mobile Menu Toggle -->
                <button id="mobile-toggle" class="md:hidden text-gray-700 text-2xl focus:outline-none">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-200 px-6 py-4">
            <a href="{{ route('home') }}" class="block py-2 hover:text-primary transition">Home</a>
            <a href="{{ route('events.index') }}" class="block py-2 hover:text-primary transition">Events</a>
            <a href="{{ route('event-categories.index') }}" class="block py-2 hover:text-primary transition">Categories</a>
            <a href="{{ route('organizer.apply') }}" class="block py-2 hover:text-primary transition">Become an Organizer</a>
            <a href="{{ route('about') }}" class="block py-2 hover:text-primary transition">About Us</a>
            <a href="{{ route('contact') }}" class="block py-2 hover:text-primary transition">Contact</a>

            @guest
                <a href="{{ route('login') }}"
                    class="block mt-4 bg-darkBlue px-6 py-2 rounded-lg text-white font-semibold text-center hover:bg-primary transition">
                    Login
                </a>
            @else
                <div class="mt-4 border-t border-gray-200 pt-4">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-darkBlue rounded-full flex items-center justify-center text-white text-lg font-bold">
                            <i class="fas fa-user"></i>
                        </div>
                        <span class="font-medium">{{ Auth::user()->name }}</span>
                    </div>
                    <a href="{{ route('user.profile.edit') }}" class="block py-2 hover:text-primary transition">My Profile</a>
                    <a href="{{ route('user.profile.history') }}" class="block py-2 hover:text-primary transition">My Events</a>
                    <form action="{{ route('logout') }}" method="POST" class="mt-2">
                        @csrf
                        <button type="submit" class="block w-full text-left py-2 hover:text-primary transition">
                            Logout
                        </button>
                    </form>
                </div>
            @endguest
        </div>
    </nav>

    <!-- Mobile Menu Script -->
    <script>
        const mobileToggle = document.getElementById('mobile-toggle');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            const icon = mobileToggle.querySelector('i');
            icon.classList.toggle('fa-bars');
            icon.classList.toggle('fa-xmark');
        });
    </script>

    <!-- Main Content Slot -->
    @yield('content')

</body>

</html>
