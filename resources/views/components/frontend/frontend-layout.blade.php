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
@php
  $route = request()->route()->getName();
@endphp

<nav class="sticky top-0 z-50 bg-white shadow-md">
  <div class="max-w-7xl mx-auto flex items-center justify-between py-4 px-6">

    <!-- Logo -->
    <a href="{{ route('home') }}" class="inline-block p-2">
      @if ($company && $company->logo)
        <img src="{{ asset('storage/' . $company->logo) }}" class="w-8 h-8 object-contain">
      @else
        <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white font-bold text-xl">
          {{ strtoupper(substr($company->name ?? 'EventHUB', 0, 1)) }}
        </div>
      @endif
    </a>

    <!-- Desktop Menu -->
    <div class="hidden md:flex items-center space-x-8 font-medium">
      <a href="{{ route('home') }}" class="{{ $route==='home'?'text-primary font-bold border-b-2 border-primary':'hover:text-primary' }}">Home</a>
      <a href="{{ route('events.index') }}" class="{{ $route==='events.index'?'text-primary font-bold border-b-2 border-primary':'hover:text-primary' }}">Events</a>
      <a href="{{ route('event-categories.index') }}" class="{{ $route==='event-categories.index'?'text-primary font-bold border-b-2 border-primary':'hover:text-primary' }}">Categories</a>
      <a href="{{ route('organizer.apply') }}" class="{{ $route==='organizer.apply.form'?'text-primary font-bold border-b-2 border-primary':'hover:text-primary' }}">Become an Organizer</a>
      <a href="{{ route('about') }}" class="{{ $route==='about'?'text-primary font-bold border-b-2 border-primary':'hover:text-primary' }}">About</a>
      <a href="{{ route('contact') }}" class="{{ $route==='contact'?'text-primary font-bold border-b-2 border-primary':'hover:text-primary' }}">Contact</a>
    </div>

    <!-- Right Side -->
    <div class="flex items-center space-x-4">
      @guest
        <a href="{{ route('login') }}" class="hidden md:inline bg-darkBlue text-white px-6 py-2 rounded-lg hover:bg-primary transition">Login</a>
      @else
        <!-- Fixed Click-Based Dropdown -->
        <div class="hidden md:block relative">
          <button id="user-menu-button" class="flex items-center space-x-2 focus:outline-none">
            <div class="w-9 h-9 bg-darkBlue text-white rounded-full flex items-center justify-center">
              <i class="fas fa-user"></i>
            </div>
            <span class="font-medium">{{ Auth::user()->name }}</span>
            <i class="fas fa-chevron-down text-xs ml-1 transition-transform duration-200"></i>
          </button>

          <!-- Dropdown Menu -->
          <div id="user-dropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg opacity-0 invisible transition-all duration-200 origin-top-right transform scale-95 z-50">
            <a href="{{ route('user.profile.edit') }}" class="block px-4 py-3 hover:bg-gray-100 rounded-t-xl transition">Profile</a>
            <a href="{{ route('user.profile.history') }}" class="block px-4 py-3 hover:bg-gray-100 transition">My Events</a>
            <form method="POST" action="{{ route('logout') }}" class="block">
              @csrf
              <button type="submit" class="w-full text-left px-4 py-3 text-red-600 hover:bg-gray-100 rounded-b-xl transition">
                Logout
              </button>
            </form>
          </div>
        </div>
      @endguest

      <button id="mobile-toggle" class="md:hidden text-2xl"><i class="fas fa-bars"></i></button>
    </div>
  </div>
</nav>

<!-- MOBILE OVERLAY -->
<div id="mobile-overlay" class="fixed inset-0 z-[999] hidden">
  <div id="mobile-backdrop" class="absolute inset-0 bg-black/40"></div>

  <div class="absolute right-0 top-0 h-full w-[85%] max-w-sm bg-white shadow-2xl p-6 overflow-y-auto">
    <div class="flex items-center justify-between mb-6">
      <span class="text-xl font-extrabold text-darkBlue">Menu</span>
      <button id="mobile-close" type="button" class="text-2xl text-gray-700">
        <i class="fas fa-xmark"></i>
      </button>
    </div>

    <div class="space-y-4 text-gray-800 font-semibold">
      <a href="{{ route('home') }}" class="block hover:text-primary">Home</a>
      <a href="{{ route('events.index') }}" class="block hover:text-primary">Events</a>
      <a href="{{ route('event-categories.index') }}" class="block hover:text-primary">Categories</a>
      <a href="{{ route('organizer.apply') }}" class="block hover:text-primary">Become an Organizer</a>
      <a href="{{ route('about') }}" class="block hover:text-primary">About Us</a>
      <a href="{{ route('contact') }}" class="block hover:text-primary">Contact</a>

      <div class="pt-5 border-t border-gray-200">
        @guest
          <a href="{{ route('login') }}"
             class="block text-center bg-darkBlue text-white py-3 rounded-xl hover:bg-primary transition">
            Login
          </a>
        @else
          <div class="mb-3 text-sm text-gray-500">Signed in as <span class="font-bold">{{ Auth::user()->name }}</span></div>
          <a href="{{ route('user.profile.edit') }}" class="block py-2 hover:text-primary">My Profile</a>
          <a href="{{ route('user.profile.history') }}" class="block py-2 hover:text-primary">My Events</a>
          <form action="{{ route('logout') }}" method="POST" class="mt-2">
            @csrf
            <button type="submit" class="w-full text-left py-2 text-red-600">
              Logout
            </button>
          </form>
        @endguest
      </div>
    </div>
  </div>
</div>

<!-- JavaScript for Mobile Menu & User Dropdown -->
<script>
document.addEventListener("DOMContentLoaded", () => {
  // Mobile Menu
  const mobileToggle = document.getElementById("mobile-toggle");
  const mobileOverlay = document.getElementById("mobile-overlay");
  const mobileClose = document.getElementById("mobile-close");
  const mobileBackdrop = document.getElementById("mobile-backdrop");

  const openMobileMenu = () => {
    mobileOverlay.classList.remove("hidden");
    document.body.classList.add("overflow-hidden");
  };

  const closeMobileMenu = () => {
    mobileOverlay.classList.add("hidden");
    document.body.classList.remove("overflow-hidden");
  };

  mobileToggle?.addEventListener("click", openMobileMenu);
  mobileClose?.addEventListener("click", closeMobileMenu);
  mobileBackdrop?.addEventListener("click", closeMobileMenu);
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") closeMobileMenu();
  });

  // User Dropdown (Desktop)
  const userButton = document.getElementById("user-menu-button");
  const userDropdown = document.getElementById("user-dropdown");
  const chevron = userButton?.querySelector("i.fa-chevron-down");

  if (userButton && userDropdown) {
    userButton.addEventListener("click", (e) => {
      e.stopPropagation();

      const isHidden = userDropdown.classList.contains("opacity-0");

      // Reset state
      userDropdown.classList.add("opacity-0", "invisible", "scale-95");
      userDropdown.classList.remove("opacity-100", "visible", "scale-100");
      if (chevron) chevron.classList.remove("rotate-180");

      // Open if was hidden
      if (isHidden) {
        userDropdown.classList.remove("opacity-0", "invisible", "scale-95");
        userDropdown.classList.add("opacity-100", "visible", "scale-100");
        if (chevron) chevron.classList.add("rotate-180");
      }
    });

    // Close when clicking outside
    document.addEventListener("click", () => {
      userDropdown.classList.add("opacity-0", "invisible", "scale-95");
      userDropdown.classList.remove("opacity-100", "visible", "scale-100");
      if (chevron) chevron.classList.remove("rotate-180");
    });

    // Prevent closing when clicking inside dropdown
    userDropdown.addEventListener("click", (e) => e.stopPropagation());
  }
});
</script>

    <!-- Main Content Slot -->
    @yield('content')

</body>

</html>
