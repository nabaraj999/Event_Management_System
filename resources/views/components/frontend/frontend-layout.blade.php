<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    @php
        if (!isset($pageSeo)) {
            $routeName = request()->route()?->getName() ?? 'home';
            $pageSeo = \App\Models\SeoPage::getForPage($routeName);
        }
    @endphp

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
    @else
        <meta property="og:image" content="{{ asset('images/default-og.jpg') }}">
    @endif

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $pageSeo?->og_title ?? $pageSeo?->meta_title ?? config('app.name') }}">
    <meta name="twitter:description" content="{{ $pageSeo?->og_description ?? $pageSeo?->meta_description ?? 'Discover events on EventHUB.' }}">
    <meta name="twitter:image" content="{{ $pageSeo?->og_image ? Storage::url($pageSeo->og_image) : asset('images/default-og.jpg') }}">

    <link rel="icon" href="{{ $company->favicon ? asset('storage/' . $company->favicon) : asset('favicon.ico') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        raleway: ["Raleway", "sans-serif"],
                        inter: ["Inter", "sans-serif"]
                    },
                    colors: {
                        primary: "#FF7A28",
                        darkBlue: "#063970",
                        softGray: "#F8F9FA"
                    },
                }
            }
        }
    </script>

    <style>
        * { font-family: 'Inter', sans-serif; }
        .font-raleway { font-family: 'Raleway', sans-serif; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }

        .nav-link { position: relative; }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: #FF7A28;
            border-radius: 2px;
            transition: width 0.3s ease;
        }
        .nav-link:hover::after, .nav-link.active::after { width: 100%; }

        .mobile-panel { transform: translateX(100%); transition: transform 0.32s cubic-bezier(.4,0,.2,1); }
        .mobile-panel.open { transform: translateX(0); }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .float { animation: float 4s ease-in-out infinite; }

        @keyframes pulse-ring {
            0% { transform: scale(1); opacity: 1; }
            100% { transform: scale(1.5); opacity: 0; }
        }

        .gradient-text {
            background: linear-gradient(135deg, #FF7A28, #ff9a5a);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .card-hover {
            transition: transform 0.35s ease, box-shadow 0.35s ease;
        }
        .card-hover:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.12);
        }

        .btn-primary {
            background: linear-gradient(135deg, #FF7A28, #e86a18);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #e86a18, #063970);
            box-shadow: 0 8px 24px rgba(255,122,40,0.35);
            transform: translateY(-2px);
        }
    </style>
</head>

<body class="bg-gray-50 antialiased">
@php $route = request()->route()->getName(); @endphp

<!-- ========== NAVBAR ========== -->
<nav id="navbar" class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-lg border-b border-gray-100 transition-all duration-300">
    <div class="max-w-7xl mx-auto flex items-center justify-between h-16 px-4 sm:px-6">

        <!-- Logo -->
        <a href="{{ route('home') }}" class="flex items-center gap-3 group flex-shrink-0">
            @if ($company && $company->logo)
                <img src="{{ asset('storage/' . $company->logo) }}" class="w-9 h-9 object-contain transition-transform duration-300 group-hover:scale-110">
            @else
                <div class="w-9 h-9 bg-gradient-to-br from-primary to-orange-400 rounded-xl flex items-center justify-center text-white font-black text-lg shadow-md">
                    {{ strtoupper(substr($company->name ?? 'E', 0, 1)) }}
                </div>
            @endif
            <span class="font-raleway font-black text-xl text-darkBlue hidden sm:block tracking-tight">
                Event<span class="text-primary">HUB</span>
            </span>
        </a>

        <!-- Desktop Navigation -->
        <div class="hidden lg:flex items-center gap-1">
            <a href="{{ route('home') }}" class="nav-link px-4 py-2 text-sm font-semibold rounded-lg transition-colors {{ $route==='home' ? 'text-primary active' : 'text-gray-600 hover:text-primary hover:bg-orange-50' }}">Home</a>
            <a href="{{ route('events.index') }}" class="nav-link px-4 py-2 text-sm font-semibold rounded-lg transition-colors {{ $route==='events.index' ? 'text-primary active' : 'text-gray-600 hover:text-primary hover:bg-orange-50' }}">Events</a>
            <a href="{{ route('event-categories.index') }}" class="nav-link px-4 py-2 text-sm font-semibold rounded-lg transition-colors {{ $route==='event-categories.index' ? 'text-primary active' : 'text-gray-600 hover:text-primary hover:bg-orange-50' }}">Categories</a>
            <a href="{{ route('organizer.apply') }}" class="nav-link px-4 py-2 text-sm font-semibold rounded-lg transition-colors {{ $route==='organizer.apply.form' ? 'text-primary active' : 'text-gray-600 hover:text-primary hover:bg-orange-50' }}">Become Organizer</a>
            <a href="{{ route('about') }}" class="nav-link px-4 py-2 text-sm font-semibold rounded-lg transition-colors {{ $route==='about' ? 'text-primary active' : 'text-gray-600 hover:text-primary hover:bg-orange-50' }}">About</a>
            <a href="{{ route('contact') }}" class="nav-link px-4 py-2 text-sm font-semibold rounded-lg transition-colors {{ $route==='contact' ? 'text-primary active' : 'text-gray-600 hover:text-primary hover:bg-orange-50' }}">Contact</a>
        </div>

        <!-- Right Actions -->
        <div class="flex items-center gap-3">
            @guest
                <a href="{{ route('login') }}" class="hidden md:inline-flex items-center gap-2 px-5 py-2.5 bg-darkBlue text-white text-sm font-bold rounded-xl hover:bg-primary transition-all duration-300 shadow-md">
                    <i class="fas fa-sign-in-alt text-xs"></i> Login
                </a>
            @else
                <!-- User Dropdown -->
                <div class="hidden md:block relative">
                    <button id="user-menu-button" class="flex items-center gap-2.5 pl-2 pr-3 py-2 rounded-xl hover:bg-gray-100 transition-all duration-200 group">
                        <div class="w-8 h-8 bg-gradient-to-br from-darkBlue to-blue-500 text-white rounded-full flex items-center justify-center text-sm font-black shadow-sm flex-shrink-0">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <span class="font-semibold text-sm text-gray-700 max-w-[100px] truncate">{{ Auth::user()->name }}</span>
                        <i class="fas fa-chevron-down text-xs text-gray-400 transition-transform duration-200" id="chevron-icon"></i>
                    </button>

                    <div id="user-dropdown" class="absolute right-0 top-full mt-2 w-56 bg-white rounded-2xl shadow-xl border border-gray-100 opacity-0 invisible scale-95 transition-all duration-200 origin-top-right z-50">
                        <div class="px-4 py-3 border-b border-gray-100 bg-gray-50 rounded-t-2xl">
                            <p class="text-xs text-gray-500 font-medium">Signed in as</p>
                            <p class="font-bold text-darkBlue text-sm truncate">{{ Auth::user()->email }}</p>
                        </div>
                        <div class="py-1.5 px-2">
                            <a href="{{ route('user.profile.edit') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-orange-50 text-sm font-semibold text-gray-700 hover:text-primary transition-colors">
                                <div class="w-7 h-7 bg-orange-100 rounded-lg flex items-center justify-center"><i class="fas fa-user text-primary text-xs"></i></div>
                                My Profile
                            </a>
                            <a href="{{ route('user.profile.history') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-orange-50 text-sm font-semibold text-gray-700 hover:text-primary transition-colors">
                                <div class="w-7 h-7 bg-orange-100 rounded-lg flex items-center justify-center"><i class="fas fa-ticket text-primary text-xs"></i></div>
                                My Events
                            </a>
                        </div>
                        <div class="border-t border-gray-100 py-1.5 px-2">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-red-50 text-sm font-semibold text-red-600 transition-colors">
                                    <div class="w-7 h-7 bg-red-100 rounded-lg flex items-center justify-center"><i class="fas fa-sign-out-alt text-red-500 text-xs"></i></div>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endguest

            <!-- Mobile Toggle -->
            <button id="mobile-toggle" class="lg:hidden w-10 h-10 flex items-center justify-center rounded-xl border border-gray-200 hover:bg-gray-50 transition-colors">
                <i class="fas fa-bars text-gray-600"></i>
            </button>
        </div>
    </div>
</nav>

<!-- ========== MOBILE MENU ========== -->
<div id="mobile-overlay" class="fixed inset-0 z-[999] hidden">
    <div id="mobile-backdrop" class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
    <div id="mobile-panel" class="mobile-panel absolute right-0 top-0 h-full w-[85%] max-w-sm bg-white shadow-2xl overflow-y-auto">

        <!-- Panel Header -->
        <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-gradient-to-br from-primary to-orange-400 rounded-xl flex items-center justify-center text-white font-black text-sm">E</div>
                <span class="font-raleway font-black text-xl text-darkBlue">Event<span class="text-primary">HUB</span></span>
            </div>
            <button id="mobile-close" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 transition-colors">
                <i class="fas fa-xmark text-gray-600"></i>
            </button>
        </div>

        <!-- Nav Links -->
        <div class="px-4 py-3 space-y-1">
            <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-colors {{ $route==='home' ? 'bg-orange-50 text-primary' : 'text-gray-700 hover:bg-gray-50' }}">
                <i class="fas fa-home w-4 text-center {{ $route==='home' ? 'text-primary' : 'text-gray-400' }}"></i> Home
            </a>
            <a href="{{ route('events.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-colors {{ $route==='events.index' ? 'bg-orange-50 text-primary' : 'text-gray-700 hover:bg-gray-50' }}">
                <i class="fas fa-calendar-alt w-4 text-center {{ $route==='events.index' ? 'text-primary' : 'text-gray-400' }}"></i> Events
            </a>
            <a href="{{ route('event-categories.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-colors {{ $route==='event-categories.index' ? 'bg-orange-50 text-primary' : 'text-gray-700 hover:bg-gray-50' }}">
                <i class="fas fa-th-large w-4 text-center {{ $route==='event-categories.index' ? 'text-primary' : 'text-gray-400' }}"></i> Categories
            </a>
            <a href="{{ route('organizer.apply') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-colors {{ $route==='organizer.apply.form' ? 'bg-orange-50 text-primary' : 'text-gray-700 hover:bg-gray-50' }}">
                <i class="fas fa-star w-4 text-center {{ $route==='organizer.apply.form' ? 'text-primary' : 'text-gray-400' }}"></i> Become Organizer
            </a>
            <a href="{{ route('about') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-colors {{ $route==='about' ? 'bg-orange-50 text-primary' : 'text-gray-700 hover:bg-gray-50' }}">
                <i class="fas fa-info-circle w-4 text-center {{ $route==='about' ? 'text-primary' : 'text-gray-400' }}"></i> About
            </a>
            <a href="{{ route('contact') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-colors {{ $route==='contact' ? 'bg-orange-50 text-primary' : 'text-gray-700 hover:bg-gray-50' }}">
                <i class="fas fa-envelope w-4 text-center {{ $route==='contact' ? 'text-primary' : 'text-gray-400' }}"></i> Contact
            </a>
        </div>

        <!-- Auth Section -->
        <div class="px-4 py-4 border-t border-gray-100 mt-2">
            @guest
                <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 w-full py-3.5 bg-darkBlue text-white font-bold rounded-xl hover:bg-primary transition-colors shadow-md">
                    <i class="fas fa-sign-in-alt"></i> Login to Your Account
                </a>
            @else
                <div class="flex items-center gap-3 mb-4 px-2">
                    <div class="w-10 h-10 bg-gradient-to-br from-darkBlue to-blue-500 rounded-full flex items-center justify-center text-white font-black">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="font-bold text-darkBlue text-sm">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <div class="space-y-1">
                    <a href="{{ route('user.profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl hover:bg-gray-50 text-gray-700 font-semibold transition-colors">
                        <i class="fas fa-user text-primary text-sm w-4 text-center"></i> My Profile
                    </a>
                    <a href="{{ route('user.profile.history') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl hover:bg-gray-50 text-gray-700 font-semibold transition-colors">
                        <i class="fas fa-ticket text-primary text-sm w-4 text-center"></i> My Events
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl hover:bg-red-50 text-red-600 font-semibold transition-colors">
                            <i class="fas fa-sign-out-alt text-sm w-4 text-center"></i> Logout
                        </button>
                    </form>
                </div>
            @endguest
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    // Navbar scroll effect
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 30) {
            navbar.classList.add('shadow-md');
            navbar.classList.remove('border-gray-100');
        } else {
            navbar.classList.remove('shadow-md');
            navbar.classList.add('border-gray-100');
        }
    }, { passive: true });

    // Mobile Menu
    const mobileToggle = document.getElementById("mobile-toggle");
    const mobileOverlay = document.getElementById("mobile-overlay");
    const mobilePanel = document.getElementById("mobile-panel");
    const mobileClose = document.getElementById("mobile-close");
    const mobileBackdrop = document.getElementById("mobile-backdrop");

    const openMobileMenu = () => {
        mobileOverlay.classList.remove("hidden");
        document.body.style.overflow = "hidden";
        setTimeout(() => mobilePanel.classList.add("open"), 10);
    };
    const closeMobileMenu = () => {
        mobilePanel.classList.remove("open");
        setTimeout(() => {
            mobileOverlay.classList.add("hidden");
            document.body.style.overflow = "";
        }, 320);
    };

    mobileToggle?.addEventListener("click", openMobileMenu);
    mobileClose?.addEventListener("click", closeMobileMenu);
    mobileBackdrop?.addEventListener("click", closeMobileMenu);
    document.addEventListener("keydown", (e) => { if (e.key === "Escape") closeMobileMenu(); });

    // User Dropdown
    const userButton = document.getElementById("user-menu-button");
    const userDropdown = document.getElementById("user-dropdown");
    const chevronIcon = document.getElementById("chevron-icon");

    if (userButton && userDropdown) {
        userButton.addEventListener("click", (e) => {
            e.stopPropagation();
            const isHidden = userDropdown.classList.contains("opacity-0");
            if (isHidden) {
                userDropdown.classList.remove("opacity-0", "invisible", "scale-95");
                userDropdown.classList.add("opacity-100", "visible", "scale-100");
                chevronIcon?.classList.add("rotate-180");
            } else {
                userDropdown.classList.add("opacity-0", "invisible", "scale-95");
                userDropdown.classList.remove("opacity-100", "visible", "scale-100");
                chevronIcon?.classList.remove("rotate-180");
            }
        });
        document.addEventListener("click", () => {
            userDropdown.classList.add("opacity-0", "invisible", "scale-95");
            userDropdown.classList.remove("opacity-100", "visible", "scale-100");
            chevronIcon?.classList.remove("rotate-180");
        });
        userDropdown.addEventListener("click", (e) => e.stopPropagation());
    }
});
</script>

@yield('content')
</body>
</html>
