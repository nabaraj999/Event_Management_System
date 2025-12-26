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
      <a href="{{ route('organizer.apply') }}" class="{{ $route==='organizer.apply'?'text-primary font-bold border-b-2 border-primary':'hover:text-primary' }}">Become an Organizer</a>
      <a href="{{ route('about') }}" class="{{ $route==='about'?'text-primary font-bold border-b-2 border-primary':'hover:text-primary' }}">About</a>
      <a href="{{ route('contact') }}" class="{{ $route==='contact'?'text-primary font-bold border-b-2 border-primary':'hover:text-primary' }}">Contact</a>
    </div>

    <!-- Right -->
    <div class="flex items-center space-x-4">
      @guest
        <a href="{{ route('login') }}" class="hidden md:inline bg-darkBlue text-white px-6 py-2 rounded-lg hover:bg-primary">Login</a>
      @else
        <div class="hidden md:block relative group">
          <button class="flex items-center space-x-2">
            <div class="w-9 h-9 bg-darkBlue text-white rounded-full flex items-center justify-center">
              <i class="fas fa-user"></i>
            </div>
            <span>{{ Auth::user()->name }}</span>
          </button>
          <div class="absolute right-0 mt-2 w-44 bg-white rounded-xl shadow-lg opacity-0 group-hover:opacity-100 invisible group-hover:visible transition">
            <a href="{{ route('user.profile.edit') }}" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
            <a href="{{ route('user.profile.history') }}" class="block px-4 py-2 hover:bg-gray-100">My Events</a>
            <form method="POST" action="{{ route('logout') }}">@csrf
              <button class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">Logout</button>
            </form>
          </div>
        </div>
      @endguest

      <button id="mobile-toggle" class="md:hidden text-2xl"><i class="fas fa-bars"></i></button>
    </div>
  </div>
</nav>

<!-- MOBILE OVERLAY (outside nav) -->
<div id="mobile-overlay" class="fixed inset-0 z-[999] hidden">
  <!-- Backdrop -->
  <div id="mobile-backdrop" class="absolute inset-0 bg-black/40"></div>

  <!-- Panel -->
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

<script>
document.addEventListener("DOMContentLoaded", () => {
  const toggleBtn = document.getElementById("mobile-toggle");
  const overlay = document.getElementById("mobile-overlay");
  const closeBtn = document.getElementById("mobile-close");
  const backdrop = document.getElementById("mobile-backdrop");

  if (!toggleBtn || !overlay || !closeBtn || !backdrop) return;

  const openMenu = () => {
    overlay.classList.remove("hidden");
    document.body.classList.add("overflow-hidden");
  };

  const closeMenu = () => {
    overlay.classList.add("hidden");
    document.body.classList.remove("overflow-hidden");
  };

  toggleBtn.addEventListener("click", openMenu);
  closeBtn.addEventListener("click", closeMenu);
  backdrop.addEventListener("click", closeMenu);

  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") closeMenu();
  });
});
</script>



    <!-- Main Content Slot -->
    @yield('content')

</body>

</html>
