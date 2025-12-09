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

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-darkBlue to-primary/60 px-4 py-10">
    <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-2xl border border-gray-100">

        <!-- Title -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-darkBlue">Create an Account</h1>
            <p class="text-gray-600 mt-1 text-sm">Join and begin your journey</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" class="text-darkBlue font-semibold" />

                <div class="relative mt-1">
                    <x-text-input
                        id="name"
                        class="block w-full rounded-lg border border-gray-300 px-4 py-3 shadow-sm focus:border-primary focus:ring-primary"
                        type="text"
                        name="name"
                        :value="old('name')"
                        required autofocus autocomplete="name"
                    />
                </div>

                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" class="text-darkBlue font-semibold" />
                <div class="relative mt-1">
                    <x-text-input
                        id="email"
                        class="block w-full rounded-lg border border-gray-300 px-4 py-3 shadow-sm focus:border-primary focus:ring-primary"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required autocomplete="username"
                    />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" class="text-darkBlue font-semibold" />

                <div class="relative mt-1">
                    <x-text-input
                        id="password"
                        class="block w-full rounded-lg border border-gray-300 px-4 py-3 shadow-sm focus:border-primary focus:ring-primary pr-12"
                        type="password"
                        name="password"
                        required autocomplete="new-password"
                    />

                    <!-- Eye Toggle -->
                    <button type="button"
                        onclick="togglePassword('password', 'eye1', 'eye2')"
                        class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-primary">
                        <svg id="eye1" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 block"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>

                        <svg id="eye2" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3 3l18 18M9.88 9.88A3 3 0 0114.12 14.12M6.23 6.23C4.24 7.57 2.92 9.64 2.46 12c.98 4.06 4.77 7 9.54 7 1.47 0 2.88-.32 4.14-.9M17.77 17.77c1.99-1.34 3.31-3.41 3.77-5.77-.98-4.06-4.77-7-9.54-7-.88 0-1.73.12-2.54.35" />
                        </svg>
                    </button>
                </div>

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-darkBlue font-semibold" />

                <div class="relative mt-1">
                    <x-text-input
                        id="password_confirmation"
                        class="block w-full rounded-lg border border-gray-300 px-4 py-3 shadow-sm focus:border-primary focus:ring-primary pr-12"
                        type="password"
                        name="password_confirmation"
                        required autocomplete="new-password"
                    />

                    <!-- Eye Toggle -->
                    <button type="button"
                        onclick="togglePassword('password_confirmation', 'eye3', 'eye4')"
                        class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-primary">
                        <svg id="eye3" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 block"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>

                        <svg id="eye4" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3 3l18 18M9.88 9.88A3 3 0 0114.12 14.12M6.23 6.23C4.24 7.57 2.92 9.64 2.46 12c.98 4.06 4.77 7 9.54 7 1.47 0 2.88-.32 4.14-.9M17.77 17.77c1.99-1.34 3.31-3.41 3.77-5.77-.98-4.06-4.77-7-9.54-7-.88 0-1.73.12-2.54.35" />
                        </svg>
                    </button>
                </div>

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Footer -->
            <div class="flex items-center justify-between mt-6">
                <a href="{{ route('login') }}" class="text-sm font-medium text-primary hover:underline">
                    Already registered?
                </a>

                <button class="bg-primary text-white px-6 py-3 rounded-lg font-semibold shadow-md text-lg hover:bg-orange-600 transition duration-200">
                    Register
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function togglePassword(inputId, eyeOpenId, eyeCloseId) {
        const input = document.getElementById(inputId);
        const open = document.getElementById(eyeOpenId);
        const close = document.getElementById(eyeCloseId);

        if (input.type === "password") {
            input.type = "text";
            open.classList.add("hidden");
            close.classList.remove("hidden");
        } else {
            input.type = "password";
            open.classList.remove("hidden");
            close.classList.add("hidden");
        }
    }
</script>
