<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EventHUB</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;600;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { raleway: ["Raleway", "sans-serif"] },
                    colors: {
                        primary: "#FF7A28",  /* Orange */
                        darkBlue: "#063970" /* Blue */
                    },
                }
            }
        }
    </script>

    <style>
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>

<body class="font-raleway bg-gray-50">

    <!-- NAVBAR -->
    <nav class="sticky top-0 z-50 bg-white shadow-md">
        <div class="max-w-7xl mx-auto flex items-center justify-between py-4 px-6">

            <!-- Logo -->
            <a href="/" class="flex items-center">
                <div class="w-12 h-12 bg-darkBlue rounded-full flex justify-center items-center text-white text-xl font-bold">
                    E
                </div>
                <span class="ml-3 text-3xl font-extrabold text-darkBlue tracking-tight">EventHUB</span>
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
                    <a href="{{ route('login') }}" class="bg-darkBlue px-6 py-2 rounded-lg text-white font-semibold hover:bg-primary transition">
                        Login
                    </a>
                @else
                    <!-- User Profile Dropdown -->
                    <div class="relative group">
                        <button class="flex items-center space-x-3 text-gray-700 focus:outline-none">
                            <div class="w-10 h-10 bg-darkBlue rounded-full flex items-center justify-center text-white text-lg font-bold">
                                <i class="fas fa-user"></i>
                            </div>
                            <span class="hidden lg:block font-medium">{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down text-sm text-gray-500 group-hover:text-primary transition"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <a href="{{ route('user.profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-primary transition">My Profile</a>
                            <a href="{{ route('user.profile.history') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-primary transition">My Event</a>
                            <hr class="my-1 border-gray-200">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-primary transition">
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
            <a href="#" class="block py-2 hover:text-primary transition">Categories</a>
            <a href="{{ route('organizer.apply') }}" class="block py-2 hover:text-primary transition">Become an Organizer</a>
            <a href="#" class="block py-2 hover:text-primary transition">About Us</a>
            <a href="#" class="block py-2 hover:text-primary transition">Contact</a>

            @guest
                <a href="{{ route('login') }}" class="block mt-4 bg-darkBlue px-6 py-2 rounded-lg text-white font-semibold text-center hover:bg-primary transition">
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
                    <a href="#" class="block py-2 hover:text-primary transition">My Profile</a>
                    <a href="#" class="block py-2 hover:text-primary transition">My Events</a>
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
            // Toggle between bars and x icon
            mobileToggle.querySelector('i').classList.toggle('fa-bars');
            mobileToggle.querySelector('i').classList.toggle('fa-xmark');
        });
    </script>

</body>
</html>
