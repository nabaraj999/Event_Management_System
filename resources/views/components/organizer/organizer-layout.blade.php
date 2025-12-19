<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventHub – Organizer Panel</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
        body { font-family: "Raleway", sans-serif; }

        .sidebar-active {
            background: rgba(255, 122, 40, 0.18);
            border-left: 4px solid #FF7A28;
            color: #FF7A28;
            font-weight: 700;
        }

        .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.12);
        }
    </style>
</head>

<body class="bg-gray-100">

<div class="flex h-screen overflow-hidden">

    <!-- Mobile Overlay -->
    <div id="overlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden"></div>

    <!-- SIDEBAR -->
    <aside id="sidebar"
        class="fixed inset-y-0 left-0 w-64 bg-darkBlue text-white z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 flex flex-col">

        <!-- Logo -->
        <div class="p-6 border-b border-white/10 flex items-center gap-3">
            <div class="w-12 h-12 rounded-lg bg-primary flex items-center justify-center text-xl font-bold shadow-lg">
                EH
            </div>
            <div>
                <h2 class="text-xl font-bold">EventHub</h2>
                <p class="text-xs opacity-80">Organizer Panel</p>
            </div>
        </div>

        <!-- NAV -->
        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">

            <a href="{{ route('org.dashboard') }}"
               class="sidebar-link flex items-center px-4 py-3 rounded-lg
               {{ request()->routeIs('org.dashboard') ? 'sidebar-active' : '' }}">
                <i class="fa-solid fa-house mr-3 text-lg"></i>
                Dashboard
            </a>

            <a href="#"
               class="sidebar-link flex items-center px-4 py-3 rounded-lg
               {{ request()->routeIs('organizer.events.*') ? 'sidebar-active' : '' }}">
                <i class="fa-solid fa-calendar-days mr-3 text-lg"></i>
                Events
            </a>

            <a href="{{ route('org.categories.index') }}"
               class="sidebar-link flex items-center px-4 py-3 rounded-lg
               {{ request()->routeIs('organizer.categories.*') ? 'sidebar-active' : '' }}">
                <i class="fa-solid fa-layer-group mr-3 text-lg"></i>
                Categories
            </a>

            <a href="#"
               class="sidebar-link flex items-center px-4 py-3 rounded-lg
               {{ request()->routeIs('organizer.bookings.*') ? 'sidebar-active' : '' }}">
                <i class="fa-solid fa-ticket mr-3 text-lg"></i>
                Bookings
            </a>

            <a href="{{ route('org.profile.settings') }}"
               class="sidebar-link flex items-center px-4 py-3 rounded-lg
               {{ request()->routeIs('org.settings') ? 'sidebar-active' : '' }}">
                <i class="fa-solid fa-gear mr-3 text-lg"></i>
                Settings
            </a>

            <a href="{{ route('org.profile.edit') }}"
               class="sidebar-link flex items-center px-4 py-3 rounded-lg
               {{ request()->routeIs('org.profile') ? 'sidebar-active' : '' }}">
                <i class="fa-solid fa-user mr-3 text-lg"></i>
                Profile
            </a>

        </nav>

        <!-- LOGOUT -->
        <div class="p-4 border-t border-white/10">
            <form method="POST" action="{{ route('org.logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center justify-center gap-3 px-4 py-3 rounded-lg bg-red-600 hover:bg-red-700 font-semibold">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Logout
                </button>
            </form>
        </div>

    </aside>

    <!-- MAIN -->
    <div class="flex-1 flex flex-col lg:ml-64">

        <!-- TOP BAR -->
        <header
            class="fixed top-0 left-0 lg:left-64 right-0 h-16 lg:h-20 bg-white shadow border-b z-40 flex items-center px-6">

            <button id="openSidebar" class="lg:hidden text-darkBlue">
                <i class="fa-solid fa-bars text-2xl"></i>
            </button>

            <div class="flex-1 ml-4">
                <h1 class="text-xl font-bold text-darkBlue">Organizer Dashboard</h1>
                <p class="text-sm text-gray-600 hidden lg:block">
                    Welcome, {{ Auth::guard('organizer')->user()->name ?? 'Organizer' }}
                </p>
            </div>

            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold">
                    {{ strtoupper(substr(Auth::guard('organizer')->user()->name ?? 'O',0,1)) }}
                </div>
            </div>
        </header>

        <!-- CONTENT -->
        <main class="flex-1 overflow-y-auto pt-16 lg:pt-20 p-6">
            {{ $slot }}
        </main>
    </div>
</div>

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
</script>

</body>
</html>
