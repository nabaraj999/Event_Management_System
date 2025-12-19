<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Login – EventHub</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;600;700;800&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { raleway: ["Raleway", "sans-serif"] },
                    colors: {
                        primary: "#4F46E5",
                        darkBlue: "#0F172A",
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-100 font-raleway">

<div class="min-h-screen flex flex-col lg:flex-row">

    <!-- LEFT IMAGE -->
    <div class="hidden lg:flex lg:w-1/2 relative">
        <img
            src="https://images.unsplash.com/photo-1553877522-43269d4ea984?q=80&w=1600"
            class="w-full h-full object-cover"
            alt="Admin Panel"
        >
        <div class="absolute inset-0 bg-darkBlue/80 flex items-center justify-center">
            <div class="text-center text-white px-12">
                <h1 class="text-4xl font-extrabold mb-4">EventHub Admin</h1>
                <p class="text-lg opacity-90">
                    Secure access to manage platform operations
                </p>
            </div>
        </div>
    </div>

    <!-- RIGHT FORM -->
    <div class="w-full lg:w-1/2 flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-2xl border border-gray-100">

            <h2 class="text-3xl font-extrabold text-center text-gray-900 mb-8">
                Admin Login
            </h2>

            <!-- Laravel Errors -->
            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6 text-sm font-medium border border-red-300">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login') }}" id="loginForm">
                @csrf

                <!-- EMAIL -->
                <div class="mb-5">
                    <label class="block text-gray-700 font-semibold mb-2">Email</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="admin@email.com"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:outline-none"
                        required
                    />
                </div>

                <!-- PASSWORD -->
                <div class="mb-5">
                    <label class="block text-gray-700 font-semibold mb-2">Password</label>
                    <div class="relative">
                        <input
                            type="password"
                            name="password"
                            id="password"
                            placeholder="••••••••"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:outline-none pr-12"
                            required
                        />

                        <!-- TOGGLE -->
                        <button type="button" id="togglePassword"
                            class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-primary">

                            <!-- Eye Open -->
                            <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>

                            <!-- Eye Closed -->
                            <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M3 3l18 18M9.88 9.88A3 3 0 0114.12 14.12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- REMEMBER -->
                <div class="flex items-center mb-6">
                    <input type="checkbox" name="remember" class="rounded text-primary focus:ring-primary">
                    <span class="ml-2 text-gray-700 text-sm">Remember me</span>
                </div>

                <!-- SUBMIT -->
                <button
                    type="submit"
                    class="w-full bg-primary text-white py-3 rounded-xl font-semibold text-lg hover:bg-indigo-700 transition shadow-md">
                    Login
                </button>

            </form>
        </div>
    </div>

</div>

<script>
    const toggleBtn = document.getElementById("togglePassword");
    const password = document.getElementById("password");
    const eyeOpen = document.getElementById("eyeOpen");
    const eyeClosed = document.getElementById("eyeClosed");

    toggleBtn.addEventListener("click", () => {
        const show = password.type === "password";
        password.type = show ? "text" : "password";
        eyeOpen.classList.toggle("hidden", !show);
        eyeClosed.classList.toggle("hidden", show);
    });
</script>

</body>
</html>
