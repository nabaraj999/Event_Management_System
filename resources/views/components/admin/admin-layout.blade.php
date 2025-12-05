<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventHub - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { raleway: ["Raleway", "sans-serif"] },
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
            background: rgba(255, 122, 40, 0.18) !important;
            border-left: 4px solid #FF7A28 !important;
            color: #FF7A28 !important;
            font-weight: 700 !important;
        }
        .sidebar-link:hover { background: rgba(255, 255, 255, 0.12); }
    </style>
</head>
<body class="bg-gray-100">

<div class="flex h-screen overflow-hidden">

    <!-- Mobile Overlay -->
    <div id="overlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden"></div>

    <!-- SIDEBAR - FINAL VERSION -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 w-64 bg-darkBlue text-white z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 flex flex-col">
        <!-- Logo -->
        <div class="p-6 border-b border-white/10 flex items-center space-x-3">
            <div class="w-12 h-12 rounded-lg bg-primary flex items-center justify-center text-white text-xl font-bold shadow-lg">
                EH
            </div>
            <div>
                <h2 class="text-xl font-bold">EventHub</h2>
                <p class="text-xs opacity-80">Admin Panel</p>
            </div>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
            <a href="{{ route('admin.dashboard') }}"
               class="sidebar-link flex items-center px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.dashboard') ? 'sidebar-active' : '' }}">
                <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h3a1 1 0 001-1v-3a1 1 0 011-1h2a1 1 0 011 1v3a1 1 0 001 1h3a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                </svg>
                <span>Dashboard</span>
            </a>

            <a href="#" class="sidebar-link flex items-center px-4 py-3 rounded-lg transition">
                <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M4 4a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-4l-2-2H4z"/>
                </svg>
                <span>Company Info</span>
            </a>

            <a href="#" class="sidebar-link flex items-center px-4 py-3 rounded-lg transition">
                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3M5 11h14M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span>Events</span>
            </a>

            <a href="#" class="sidebar-link flex items-center px-4 py-3 rounded-lg transition">
                <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M3 3h6v6H3V3zm8 0h6v6h-6V3zm-8 8h6v6H3v-6zm8 0h6v6h-6v-6z"/>
                </svg>
                <span>Categories</span>
            </a>

            <a href="#" class="sidebar-link flex items-center px-4 py-3 rounded-lg transition">
                <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Organizers</span>
            </a>

            <a href="#" class="sidebar-link flex items-center px-4 py-3 rounded-lg transition">
                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span>Bookings</span>
            </a>

            <a href="#" class="sidebar-link flex items-center px-4 py-3 rounded-lg transition">
                <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <span>Users</span>
            </a>

            <a href="#" class="sidebar-link flex items-center px-4 py-3 rounded-lg transition">
                <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M3 3h3v18H3V3zm5 7h3v11H8v-11zm5-5h3v16h-3V5zm5 9h3v7h-3v-7z"/>
                </svg>
                <span>Reports</span>
            </a>

            <a href="#" class="sidebar-link flex items-center px-4 py-3 rounded-lg transition">
                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9"/>
                </svg>
                <span>SEO</span>
            </a>

            <a href="#" class="sidebar-link flex items-center px-4 py-3 rounded-lg transition">
                <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                </svg>
                <span>Profile</span>
            </a>
        </nav>

        <!-- Logout -->
        <div class="p-4 border-t border-white/10">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center space-x-3 px-4 py-3 rounded-lg bg-red-600 hover:bg-red-700 transition font-semibold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-6 0v-1"/>
                    </svg>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="flex-1 flex flex-col lg:ml-64">

        <!-- FIXED TOP BAR -->
        <header class="fixed top-0 left-0 lg:left-64 right-0 bg-white shadow-lg border-b border-gray-200 z-40 h-16 lg:h-20 flex items-center">
            <div class="w-full flex items-center justify-between px-6">
                <button id="openSidebar" class="lg:hidden text-darkBlue hover:text-primary">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <div class="flex-1 text-center lg:text-left">
                    <h1 class="text-2xl font-bold text-darkBlue">EventHub Admin</h1>
                    <p class="text-sm text-gray-600 hidden lg:block">
                        Welcome back, <span class="font-semibold">{{ Auth::guard('admin')->user()->name ?? 'Admin' }}</span>
                    </p>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="hidden lg:block text-right">
                        <p class="text-sm font-bold text-darkBlue">{{ Auth::guard('admin')->user()->name ?? 'Admin' }}</p>
                        <p class="text-xs text-gray-500">Administrator</p>
                    </div>
                    <div class="relative">
                        <div class="w-12 h-12 rounded-full bg-primary text-white flex items-center justify-center text-xl font-bold ring-4 ring-primary/20 shadow-lg">
                            {{ strtoupper(substr(Auth::guard('admin')->user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <span class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-green-500 border-2 border-white rounded-full"></span>
                    </div>
                </div>
            </div>
        </header>

        <!-- PAGE CONTENT -->
        <main class="flex-1 overflow-y-auto pt-16 lg:pt-20 p-6 lg:p-8">
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

