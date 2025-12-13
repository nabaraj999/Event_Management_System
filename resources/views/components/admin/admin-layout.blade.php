<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventHub - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
            background: rgba(255, 122, 40, 0.18) !important;
            border-left: 4px solid #FF7A28 !important;
            color: #FF7A28 !important;
            font-weight: 700 !important;
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

        <!-- SIDEBAR - FINAL VERSION -->
        <aside id="sidebar"
            class="fixed inset-y-0 left-0 w-64 bg-darkBlue text-white z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 flex flex-col">
            <!-- Logo -->
            <div class="p-6 border-b border-white/10 flex items-center space-x-3">
                <div
                    class="w-12 h-12 rounded-lg bg-primary flex items-center justify-center text-white text-xl font-bold shadow-lg">
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
                    class="sidebar-link flex items-center px-4 py-3 rounded-lg transition
       {{ request()->routeIs('admin.dashboard') ? 'sidebar-active' : '' }}">
                    <i class="fa-solid fa-house w-6 h-6 mr-3 text-lg"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.company.edit') }}"
                    class="sidebar-link flex items-center px-4 py-3 rounded-lg transition
       {{ request()->routeIs('admin.company.edit') ? 'sidebar-active' : '' }}">
                    <i class="fa-solid fa-building w-6 h-6 mr-3 text-lg"></i>
                    <span>Company Info</span>
                </a>

                <a href="{{ route('admin.events.index') }}"
                    class="sidebar-link flex items-center px-4 py-3 rounded-lg transition
       {{ request()->routeIs('admin.events.*') ? 'sidebar-active' : '' }}">
                    <i class="fa-solid fa-calendar-days w-6 h-6 mr-3 text-lg"></i>
                    <span>Events</span>
                </a>

                <a href="{{ route('admin.event-tickets.index') }}"
                    class="sidebar-link flex items-center px-4 py-3 rounded-lg transition
   {{ request()->routeIs('admin.event-tickets.*') ? 'sidebar-active' : '' }}">
                    <i class="fa-solid fa-ticket w-6 h-6 mr-3 text-lg"></i>
                    <span>Tickets</span>
                </a>

                <a href="{{ route('admin.categories.index') }}"
                    class="sidebar-link flex items-center px-4 py-3 rounded-lg transition
       {{ request()->routeIs('admin.categories.*') ? 'sidebar-active' : '' }}">
                    <i class="fa-solid fa-table-cells-large w-6 h-6 mr-3 text-lg"></i>
                    <span>Categories</span>
                </a>

                <a href="#"
                    class="sidebar-link flex items-center px-4 py-3 rounded-lg transition
       {{ request()->routeIs('admin.organizers.*') ? 'sidebar-active' : '' }}">
                    <i class="fa-solid fa-user-tie w-6 h-6 mr-3 text-lg"></i>
                    <span>Organizers</span>
                </a>

                <a href="#"
                    class="sidebar-link flex items-center px-4 py-3 rounded-lg transition
       {{ request()->routeIs('admin.bookings.*') ? 'sidebar-active' : '' }}">
                    <i class="fa-solid fa-file-invoice w-6 h-6 mr-3 text-lg"></i>
                    <span>Bookings</span>
                </a>

                <a href="{{ route('admin.users.index') }}"
                    class="sidebar-link flex items-center px-4 py-3 rounded-lg transition
       {{ request()->routeIs('admin.users.*') ? 'sidebar-active' : '' }}">
                    <i class="fa-solid fa-users w-6 h-6 mr-3 text-lg"></i>
                    <span>Users</span>
                </a>

                <a href="#"
                    class="sidebar-link flex items-center px-4 py-3 rounded-lg transition
       {{ request()->routeIs('admin.reports.*') ? 'sidebar-active' : '' }}">
                    <i class="fa-solid fa-chart-column w-6 h-6 mr-3 text-lg"></i>
                    <span>Reports</span>
                </a>

                <a href="#"
                    class="sidebar-link flex items-center px-4 py-3 rounded-lg transition
       {{ request()->routeIs('admin.seo.*') ? 'sidebar-active' : '' }}">
                    <i class="fa-solid fa-globe w-6 h-6 mr-3 text-lg"></i>
                    <span>SEO</span>
                </a>

                <a href="{{ route('admin.profile') }}"
                    class="sidebar-link flex items-center px-4 py-3 rounded-lg transition
       {{ request()->routeIs('admin.profile') ? 'sidebar-active' : '' }}">
                    <i class="fa-solid fa-user w-6 h-6 mr-3 text-lg"></i>
                    <span>Profile</span>
                </a>

            </nav>



            <!-- Logout -->
            <div class="p-4 border-t border-white/10">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center space-x-3 px-4 py-3 rounded-lg bg-red-600 hover:bg-red-700 transition font-semibold">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-6 0v-1" />
                        </svg>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <div class="flex-1 flex flex-col lg:ml-64">

            <!-- FIXED TOP BAR -->
            <header
                class="fixed top-0 left-0 lg:left-64 right-0 bg-white shadow-lg border-b border-gray-200 z-40 h-16 lg:h-20 flex items-center">
                <div class="w-full flex items-center justify-between px-6">
                    <button id="openSidebar" class="lg:hidden text-darkBlue hover:text-primary">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <div class="flex-1 text-center lg:text-left">
                        <h1 class="text-2xl font-bold text-darkBlue">EventHub Admin</h1>
                        <p class="text-sm text-gray-600 hidden lg:block">
                            Welcome back, <span
                                class="font-semibold">{{ Auth::guard('admin')->user()->name ?? 'Admin' }}</span>
                        </p>
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="hidden lg:block text-right">
                            <p class="text-sm font-bold text-darkBlue">
                                {{ Auth::guard('admin')->user()->name ?? 'Admin' }}</p>
                            <p class="text-xs text-gray-500">Administrator</p>
                        </div>
                        <div class="relative">
                            <div
                                class="w-12 h-12 rounded-full bg-primary text-white flex items-center justify-center text-xl font-bold ring-4 ring-primary/20 shadow-lg">
                                {{ strtoupper(substr(Auth::guard('admin')->user()->name ?? 'A', 0, 1)) }}
                            </div>
                            <span
                                class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-green-500 border-2 border-white rounded-full"></span>
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
