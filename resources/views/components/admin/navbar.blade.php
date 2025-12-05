<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Panel</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { raleway: ["Raleway", "sans-serif"] },
                    colors: {
                        primary: "#FF7A28",
                        darkBlue: "#063970",
                    },
                }
            }
        }
    </script>

    <style>
        body { font-family: "Raleway", sans-serif; }

        .sidebar-active {
            background: rgba(255, 122, 40, 0.18);
            border-left: 4px solid #FF7A28;
            color: #FF7A28 !important;
            font-weight: 700;
        }

        .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.14);
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-800">

<div class="flex h-screen overflow-hidden">

    <!-- MOBILE OVERLAY (changed from black → blue transparent) -->
    <div id="sidebarOverlay"
         class="fixed inset-0 bg-darkBlue/60 z-40 hidden lg:hidden"></div>

    <!-- SIDEBAR -->
    <aside id="sidebar"
           class="fixed inset-y-0 left-0 w-64 bg-darkBlue text-white z-50 transform
                  -translate-x-full lg:translate-x-0 transition-all duration-300 ease-in-out flex flex-col">

        <!-- LOGO -->
        <div class="p-6 border-b border-white/20 flex items-center space-x-3">
            <div class="w-12 h-12 rounded-lg bg-primary flex items-center justify-center text-white text-xl font-bold shadow-md">
                EH
            </div>
            <div>
                <h2 class="text-xl font-bold">EventHub</h2>
                <p class="text-xs text-gray-300">Admin Panel</p>
            </div>
        </div>

        <!-- NAVIGATION -->
        <nav class="flex-1 overflow-y-auto p-4 space-y-2 font-semibold">

            <!-- DASHBOARD -->
            <a href="#" class="sidebar-link sidebar-active flex items-center p-3 rounded-lg transition font-semibold">
                <!-- Heroicon Home -->
                <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M11.47 3.84a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 0 1-1.06 1.06L12 5.06 3.84 13.59a.75.75 0 1 1-1.06-1.06l8.69-8.69Z"/>
                    <path d="M12 7.5L20.598 16.098A1.5 1.5 0 0 1 19.69 18h-3.19v3.25H7.5V18H4.31a1.5 1.5 0 0 1-1.09-2.598L12 7.5Z"/>
                </svg>
                Dashboard
            </a>

            <!-- COMPANY INFO -->
            <a href="#" class="sidebar-link flex items-center p-3 rounded-lg transition font-semibold">
                <!-- Building Icon -->
                <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M3 21V3h7v18H3zm11 0V8h7v13h-7z"/>
                </svg>
                Company Info
            </a>

            <!-- EVENTS -->
            <a href="#" class="sidebar-link flex items-center p-3 rounded-lg transition font-semibold">
                <!-- Calendar Icon -->
                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M8 7V3m8 4V3M5 11h14M5 21h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2z"/>
                </svg>
                Events
            </a>

            <!-- CATEGORIES -->
            <a href="#" class="sidebar-link flex items-center p-3 rounded-lg transition font-semibold">
                <!-- Squares Icon -->
                <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M3 3h8v8H3V3zm10 0h8v8h-8V3zM3 13h8v8H3v-8zm10 0h8v8h-8v-8z"/>
                </svg>
                Categories
            </a>

            <!-- ORGANIZERS -->
            <a href="#" class="sidebar-link flex items-center p-3 rounded-lg transition font-semibold">
                <!-- Users Icon -->
                <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0z"/>
                    <path d="M12 14c-4 0-8 2-8 6h16c0-4-4-6-8-6z"/>
                </svg>
                Organizers
            </a>

            <!-- BOOKING -->
            <a href="#" class="sidebar-link flex items-center p-3 rounded-lg transition font-semibold">
                <!-- Document Icon -->
                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414A1 1 0 0 1 18 9.414V19a2 2 0 0 1-2 2z"/>
                </svg>
                Booking
            </a>

            <!-- USERS -->
            <a href="#" class="sidebar-link flex items-center p-3 rounded-lg transition font-semibold">
                <!-- User Icon -->
                <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5z"/>
                    <path d="M4 21a8 8 0 0 1 16 0H4z"/>
                </svg>
                Users
            </a>

            <!-- REPORTS -->
            <a href="#" class="sidebar-link flex items-center p-3 rounded-lg transition font-semibold">
                <!-- Chart Icon -->
                <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M3 3h3v18H3zm5 7h3v11H8zm5-5h3v16h-3zm5 9h3v7h-3z"/>
                </svg>
                Reports
            </a>

            <!-- SEO -->
            <a href="#" class="sidebar-link flex items-center p-3 rounded-lg transition font-semibold">
                <!-- Globe Icon -->
                <svg class="w-6 h-6 mr-3" fill="none" stroke-width="2" stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 21a9 9 0 1 0-9-9 9 9 0 0 0 9 9zm0-18v18m9-9H3"/>
                </svg>
                SEO
            </a>

            <!-- PROFILE -->
            <a href="#" class="sidebar-link flex items-center p-3 rounded-lg transition font-semibold">
                <!-- User Circle Icon -->
                <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5z"/>
                    <path d="M4 21a8 8 0 0 1 16 0H4z"/>
                </svg>
                Profile
            </a>

        </nav>

        <!-- LOGOUT -->
        <div class="p-4 border-t border-white/10">
            <button class="w-full flex items-center justify-center space-x-3 p-3 rounded-lg bg-red-600 hover:bg-red-700 transition text-white font-semibold">
                <!-- Logout Icon -->
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M15.75 3.75h-6A3.75 3.75 0 0 0 6 7.5v9a3.75 3.75 0 0 0 3.75 3.75h6A3.75 3.75 0 0 0 19.5 16.5V15h-1.5v1.5A2.25 2.25 0 0 1 15.75 18h-6A2.25 2.25 0 0 1 7.5 16.5v-9A2.25 2.25 0 0 1 9.75 5.25h6A2.25 2.25 0 0 1 18 7.5v1.5h1.5V7.5a3.75 3.75 0 0 0-3.75-3.75z"/>
                    <path d="M21 12l-4.5-3v6l4.5-3z"/>
                </svg>
                Logout
            </button>
        </div>

    </aside>

    <!-- MAIN CONTENT -->
    <div class="flex-1 flex flex-col overflow-hidden">

      <!-- TOP BAR -->
<header class="bg-white shadow-md border-b border-gray-200 z-10">
    <div class="flex items-center justify-between px-6 py-4">

        <!-- Mobile Menu Button -->
        <button id="openSidebar" class="lg:hidden text-darkBlue hover:text-primary transition">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <!-- Page Title - Centered on Mobile, Left on Desktop -->
        <div class="flex-1 text-center lg:text-left">
            <h1 class="text-2xl font-bold text-darkBlue">EventHub Admin</h1>
            <p class="text-sm text-gray-600 hidden lg:block">
                Welcome back, <span class="font-semibold">{{ Auth::guard('admin')->user()->name ?? 'Admin' }}</span>
            </p>
        </div>

        <!-- Admin Info + Avatar (Right Side) -->
        <div class="flex items-center space-x-4">
            <!-- Admin Name (Visible on Desktop) -->
            <div class="hidden lg:block text-right">
                <p class="text-sm font-bold text-darkBlue">{{ Auth::guard('admin')->user()->name ?? 'Admin' }}</p>
                <p class="text-xs text-gray-500">Administrator</p>
            </div>

            <!-- Avatar -->
            <div class="relative">
                <div class="w-12 h-12 rounded-full bg-primary text-white flex items-center justify-center text-xl font-bold shadow-lg ring-4 ring-primary/20">
                    {{ strtoupper(substr(Auth::guard('admin')->user()->name ?? 'A', 0, 1)) }}
                </div>
                <!-- Optional Online Indicator -->
                <span class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-green-500 border-2 border-white rounded-full"></span>
            </div>
        </div>
    </div>
</header>

        <main class="flex-1 overflow-y-auto p-6">
            {{ $slot ?? '' }}
        </main>
    </div>
</div>

<script>
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("sidebarOverlay");
    const openBtn = document.getElementById("openSidebar");

    openBtn?.addEventListener("click", () => {
        sidebar.classList.remove("-translate-x-full");
        overlay.classList.remove("hidden");
    });

    overlay?.addEventListener("click", () => {
        sidebar.classList.add("-translate-x-full");
        overlay.classList.add("hidden");
    });
</script>

</body>
</html>
