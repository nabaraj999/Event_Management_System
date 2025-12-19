<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Organizer Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2563eb',
                        darkBlue: '#063970',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-100">

<div class="min-h-screen flex flex-col lg:flex-row">

    <!-- IMAGE SECTION (HIDDEN ON MOBILE) -->
    <div class="hidden lg:flex lg:w-1/2 relative">
        <img
            src="https://images.unsplash.com/photo-1505238680356-667803448bb6?q=80&w=1200"
            class="w-full h-full object-cover"
            alt="Event management"
        >
        <div class="absolute inset-0 bg-darkBlue/70 flex items-center justify-center">
            <div class="text-white text-center px-10">
                <h1 class="text-4xl font-bold mb-4">Organizer Dashboard</h1>
                <p class="text-lg opacity-90">
                    Manage events, tickets, and attendees easily.
                </p>
            </div>
        </div>
    </div>

    <!-- LOGIN SECTION -->
    <div class="flex w-full lg:w-1/2 items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">

            <div class="bg-white rounded-2xl shadow-2xl p-8">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-darkBlue">Organizer Login</h2>
                    <p class="mt-2 text-gray-600">Access your organizer account</p>
                </div>

                <!-- FORM -->
                <form method="POST" action="{{ route('org.login') }}" class="space-y-6">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-primary focus:border-primary"
                            placeholder="your@email.com"
                        >
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password with toggle -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Password</label>
                        <div class="relative mt-1">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-primary focus:border-primary pr-12"
                                placeholder="••••••••"
                            >
                            <button
                                type="button"
                                onclick="togglePassword()"
                                class="absolute inset-y-0 right-3 flex items-center text-gray-500 text-sm font-medium"
                            >
                                <span id="toggleText">Show</span>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- General Error Message (e.g. invalid credentials, frozen, not approved) -->
                    @if ($errors->has('email') && !str_contains($errors->first('email'), 'password'))
                        <p class="text-center text-sm text-red-600">
                            {{ $errors->first('email') }}
                        </p>
                    @endif

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="w-full py-4 bg-primary hover:bg-blue-700 text-white font-bold rounded-xl transition shadow-lg text-lg"
                    >
                        Log In
                    </button>

                    <!-- Back to Home -->
                    <div class="text-center">
                        <a href="/" class="text-primary hover:underline text-sm">
                            ← Back to Home
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- Password Toggle Script -->
<script>
    function togglePassword() {
        const password = document.getElementById('password');
        const toggleText = document.getElementById('toggleText');

        if (password.type === 'password') {
            password.type = 'text';
            toggleText.innerText = 'Hide';
        } else {
            password.type = 'password';
            toggleText.innerText = 'Show';
        }
    }
</script>

</body>
</html>
