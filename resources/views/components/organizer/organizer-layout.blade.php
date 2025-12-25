<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventHub – Organizer Panel</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('storage/' . ($company->favicon ?? 'favicon.ico')) }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        raleway: ["Raleway", "sans-serif"]
                    },
                    colors: {
                        primary: "#FF7A28",
                        darkBlue: "#063970",
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: "Raleway", sans-serif;
        }

        .sidebar-active {
            background: rgba(255, 122, 40, 0.18);
            border-left: 4px solid #FF7A28;
            color: #FF7A28 !important;
            font-weight: 700;
        }

        .sidebar-link {
            color: #e2e8f0;
            transition: all 0.3s;
        }

        .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.12);
            color: white;
        }
    </style>
</head>

<body class="bg-gray-100">

    <div class="flex h-screen overflow-hidden">

        <!-- Mobile Overlay -->
        <div id="overlay" class="fixed inset-0 bg-black/60 z-40 hidden lg:hidden"></div>

        <!-- SIDEBAR -->
        <aside id="sidebar"
            class="fixed inset-y-0 left-0 w-64 bg-darkBlue text-white z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out flex flex-col overflow-hidden">

            <!-- Logo -->
            <div class="p-6 border-b border-white/10 flex items-center gap-4">
                <a href="{{ route('org.dashboard') }}" class="flex items-center gap-4">
                    @if ($company && $company->logo)
                        <img src="{{ asset('storage/' . $company->logo) }}"
                            alt="{{ $company->name ?? 'EventHub' }} Logo"
                            class="w-12 h-12 rounded-lg object-contain shadow-lg bg-white" />
                    @else
                        <div
                            class="w-12 h-12 rounded-lg bg-white flex items-center justify-center text-xl font-bold shadow-lg">
                            {{ strtoupper(substr($company->name ?? 'EventHub', 0, 2)) }}
                        </div>
                    @endif
                    <div>
                        <h2 class="text-xl font-bold">EventHub</h2>
                        <p class="text-xs opacity-80">Organizer Panel</p>
                    </div>
                </a>
            </div>

            <!-- NAVIGATION -->
            <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-2">

                <a href="{{ route('org.dashboard') }}"
                    class="sidebar-link flex items-center px-5 py-3 rounded-xl {{ request()->routeIs('org.dashboard') ? 'sidebar-active' : '' }}">
                    <i class="fa-solid fa-house w-6 text-center mr-4"></i>
                    Dashboard
                </a>

                <a href="{{ route('org.events.index') }}"
                    class="sidebar-link flex items-center px-5 py-3 rounded-xl {{ request()->routeIs('org.events.*') ? 'sidebar-active' : '' }}">
                    <i class="fa-solid fa-calendar-days w-6 text-center mr-4"></i>
                    Events
                </a>

                <a href="{{ route('org.categories.index') }}"
                    class="sidebar-link flex items-center px-5 py-3 rounded-xl {{ request()->routeIs('org.categories.*') ? 'sidebar-active' : '' }}">
                    <i class="fa-solid fa-layer-group w-6 text-center mr-4"></i>
                    Categories
                </a>

                <a href="{{ route('org.event-tickets.index') }}"
                    class="sidebar-link flex items-center px-5 py-3 rounded-xl {{ request()->routeIs('org.event-tickets.*') ? 'sidebar-active' : '' }}">
                    <i class="fa-solid fa-ticket w-6 text-center mr-4"></i>
                    Tickets
                </a>

                <a href="{{ route('org.bookings.index') }}"
                    class="sidebar-link flex items-center px-5 py-3 rounded-xl {{ request()->routeIs('org.bookings.*') ? 'sidebar-active' : '' }}">
                    <i class="fa-solid fa-receipt w-6 text-center mr-4"></i>
                    Bookings
                </a>

                <a href="{{ route('org.support.index') }}"
                    class="sidebar-link flex items-center px-5 py-3 rounded-xl {{ request()->routeIs('org.support.*') ? 'sidebar-active' : '' }}">
                    <i class="fa-solid fa-headset w-6 text-center mr-4"></i>
                    Help & Support
                </a>

                <a href="{{ route('org.settlements.index') }}"
                    class="sidebar-link flex items-center px-5 py-3 rounded-xl {{ request()->routeIs('org.settlements.*') ? 'sidebar-active' : '' }}">
                    <i class="fa-solid fa-hand-holding-dollar w-6 text-center mr-4"></i>
                    Settlements
                </a>
                <a href="{{ route('org.insights') }}"
                    class="sidebar-link flex items-center px-5 py-3 rounded-xl {{ request()->routeIs('org.insights') ? 'sidebar-active' : '' }}">
                    <i class="fa-solid fa-chart-line w-6 text-center mr-4"></i>
                    Insights
                </a>

                <a href="{{ route('org.profile.settings') }}"
                    class="sidebar-link flex items-center px-5 py-3 rounded-xl {{ request()->routeIs('org.profile.settings') ? 'sidebar-active' : '' }}">
                    <i class="fa-solid fa-gear w-6 text-center mr-4"></i>
                    Settings
                </a>

                <a href="{{ route('org.profile.edit') }}"
                    class="sidebar-link flex items-center px-5 py-3 rounded-xl {{ request()->routeIs('org.profile.edit') ? 'sidebar-active' : '' }}">
                    <i class="fa-solid fa-user w-6 text-center mr-4"></i>
                    Profile
                </a>

            </nav>

            <!-- LOGOUT -->
            <div class="p-6 border-t border-white/10">
                <form method="POST" action="{{ route('org.logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-3 px-5 py-4 rounded-xl bg-red-600 hover:bg-red-700 font-bold transition shadow-lg">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <div class="flex-1 flex flex-col lg:ml-64">

            <!-- TOP BAR -->
            <header
                class="fixed top-0 left-0 lg:left-64 right-0 h-16 lg:h-20 bg-white shadow-lg border-b z-40 flex items-center px-6">
                <button id="openSidebar" class="lg:hidden text-darkBlue text-2xl">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <div class="flex-1 ml-6">
                    <h1 class="text-2xl font-bold text-darkBlue">Organizer Dashboard</h1>
                    <p class="text-sm text-gray-600 hidden sm:block">
                        Welcome back,
                        <strong>{{ Auth::guard('organizer')->user()->contact_person ?? (Auth::guard('organizer')->user()->name ?? 'Organizer') }}</strong>
                    </p>
                </div>

                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-full bg-primary text-white flex items-center justify-center text-xl font-bold shadow-lg">
                        {{ strtoupper(substr(Auth::guard('organizer')->user()->contact_person ?? (Auth::guard('organizer')->user()->name ?? 'O'), 0, 1)) }}
                    </div>
                </div>
            </header>

            <!-- PAGE CONTENT -->
            <main class="flex-1 overflow-y-auto pt-20 lg:pt-24 p-6 lg:p-8">
                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- Mobile Sidebar Script -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const openBtn = document.getElementById('openSidebar');

        openBtn?.addEventListener('click', () => {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        });

        overlay?.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });

        // Close sidebar on link click (mobile)
        document.querySelectorAll('#sidebar a').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 1024) {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                }
            });
        });
    </script>

</body>

</html>
