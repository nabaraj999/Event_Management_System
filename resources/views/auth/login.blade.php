<script src="https://cdn.tailwindcss.com"></script>
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

<div class="min-h-screen flex flex-col lg:flex-row">

    <!-- LEFT IMAGE SECTION -->
    <div class="hidden lg:flex lg:w-1/2 relative">
        <img
            src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=1600"
            alt="User login"
            class="w-full h-full object-cover"
        >
        <div class="absolute inset-0 bg-darkBlue/75 flex items-center justify-center">
            <div class="text-white text-center px-10">
                <h1 class="text-4xl font-extrabold mb-4">
                    Welcome to EventHub
                </h1>
                <p class="text-lg opacity-90">
                    Discover events, book tickets, and enjoy experiences
                </p>
            </div>
        </div>
    </div>

    <!-- RIGHT LOGIN FORM -->
    <div class="w-full lg:w-1/2 flex items-center justify-center px-4 py-12 bg-gray-100">
        <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-2xl border border-gray-100">

            <!-- Title -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-darkBlue">Welcome Back</h1>
                <p class="text-gray-600 mt-1 text-sm">
                    Login to continue your journey
                </p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-darkBlue font-semibold" />
                    <x-text-input
                        id="email"
                        class="mt-1 block w-full rounded-lg border-gray-300 px-4 py-3 focus:border-primary focus:ring-primary"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required autofocus
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" class="text-darkBlue font-semibold" />

                    <div class="relative mt-1">
                        <x-text-input
                            id="password"
                            class="block w-full rounded-lg border-gray-300 px-4 py-3 pr-12 focus:border-primary focus:ring-primary"
                            type="password"
                            name="password"
                            required
                        />

                        <!-- Eye Toggle -->
                        <button type="button"
                            onclick="togglePassword()"
                            class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-primary">

                            <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>

                            <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M3 3l18 18M9.88 9.88A3 3 0 0114.12 14.12" />
                            </svg>
                        </button>
                    </div>

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember + Forgot -->
                <div class="flex items-center justify-between mt-4">
                    <label class="flex items-center text-sm text-gray-700">
                        <input type="checkbox" name="remember"
                            class="rounded border-gray-300 text-primary focus:ring-primary">
                        <span class="ml-2">Remember me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                            class="text-sm font-medium text-primary hover:underline">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <!-- Submit -->
                <div class="mt-6">
                    <button
                        class="w-full bg-primary text-white py-3 rounded-lg font-semibold text-lg shadow-md hover:bg-orange-600 transition">
                        Log In
                    </button>
                </div>
            </form>

            <p class="text-center text-gray-600 mt-6 text-sm">
                New here?
                <a href="{{ route('register') }}" class="text-primary font-semibold hover:underline">
                    Create an account
                </a>
            </p>

        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const input = document.getElementById("password");
        const open = document.getElementById("eyeOpen");
        const closed = document.getElementById("eyeClosed");

        if (input.type === "password") {
            input.type = "text";
            open.classList.add("hidden");
            closed.classList.remove("hidden");
        } else {
            input.type = "password";
            open.classList.remove("hidden");
            closed.classList.add("hidden");
        }
    }
</script>
