<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'EventFlow' }}</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'deep-blue': '#063970',
                        'orange': '#FF8C32',
                    },
                    fontFamily: {
                        raleway: ['Raleway', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Raleway', sans-serif; }
        .gradient-text {
            background: linear-gradient(to right, #FF8C32, #FFB74D);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 900;
        }
        .bg-gradient-hero {
            background: linear-gradient(to right, #FF8C32, #FF6B00);
        }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-50">

    <!-- Navbar -->
    <nav class="sticky top-0 z-50 bg-white shadow-lg">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-deep-blue flex items-center justify-center mr-2">
                        <span class="text-white font-bold text-xl">E</span>
                    </div>
                    <span class="text-deep-blue font-bold text-2xl">EventFlow</span>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-8">
                    <a href="/" class="text-gray-700 hover:text-orange transition font-medium">Home</a>
                    <a href="#" class="text-gray-700 hover:text-orange transition font-medium">Events</a>
                    <a href="#" class="text-gray-700 hover:text-orange transition font-medium">Categories</a>
                    <a href="#" class="text-gray-700 hover:text-orange transition font-medium">Pricing</a>
                    <a href="#" class="text-gray-700 hover:text-orange transition font-medium">Contact</a>
                </div>

                <!-- Login + Mobile Menu Button -->
                <div class="flex items-center space-x-4">
                    <a href="#" class="bg-deep-blue text-white px-6 py-2 rounded-lg hover:bg-orange transition font-medium">
                        Login
                    </a>
                    <button id="mobile-menu-btn" class="md:hidden text-gray-700">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden py-4 border-t border-gray-200">
                <div class="flex flex-col space-y-4">
                    <a href="#" class="text-gray-700 hover:text-orange font-medium">Home</a>
                    <a href="#" class="text-gray-700 hover:text-orange font-medium">Events</a>
                    <a href="#" class="text-gray-700 hover:text-orange font-medium">Categories</a>
                    <a href="#" class="text-gray-700 hover:text-orange font-medium">Pricing</a>
                    <a href="#" class="text-gray-700 hover:text-orange font-medium">Contact</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    {{ $slot }}

    @stack('scripts')
    <script>
        document.getElementById('mobile-menu-btn').addEventListener('click', function () {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>
</body>
</html>
