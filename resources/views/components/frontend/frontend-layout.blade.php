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

            <div class="hidden md:flex items-center space-x-8 text-gray-700 font-medium">
                <a href="#" class="hover:text-primary">Home</a>
                <a href="#" class="hover:text-primary">Events</a>
                <a href="#" class="hover:text-primary">Categories</a>
                <a href="#" class="hover:text-primary">About Us</a>
                <a href="#" class="hover:text-primary">Contact</a>
            </div>

            <div class="flex items-center space-x-4">
                <a href="{{ route('login') }}" class="bg-darkBlue px-6 py-2 rounded-lg text-white font-semibold hover:bg-primary transition">
                    Login
                </a>
                <button id="mobile-toggle" class="md:hidden text-gray-700 text-2xl">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>

        <!-- Mobile -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-200 px-6 py-4">
            <a href="#" class="block py-2 hover:text-primary">Home</a>
            <a href="#" class="block py-2 hover:text-primary">Events</a>
            <a href="#" class="block py-2 hover:text-primary">Categories</a>
            <a href="#" class="block py-2 hover:text-primary">About Us</a>
            <a href="#" class="block py-2 hover:text-primary">Contact</a>
        </div>
    </nav>
