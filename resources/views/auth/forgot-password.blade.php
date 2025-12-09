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
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-darkBlue">Reset Password</h1>
            <p class="text-gray-600 mt-1 text-sm">
                Forgot your password? No problem.
                Enter your email and we’ll send you the reset link.
            </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-darkBlue font-semibold" />
                <div class="relative mt-1">
                    <x-text-input
                        id="email"
                        class="block w-full rounded-lg border border-gray-300 px-4 py-3 shadow-sm
                        focus:border-primary focus:ring-primary"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required autofocus
                    />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Submit Button -->
            <div class="mt-6">
                <button
                    class="w-full bg-primary text-white py-3 rounded-lg font-semibold text-lg shadow-md hover:bg-orange-600 transition duration-200">
                    Email Password Reset Link
                </button>
            </div>

            <!-- Back to Login -->
            <p class="mt-6 text-center text-sm text-gray-600">
                Remember your password?
                <a href="{{ route('login') }}" class="text-primary font-semibold hover:underline">Go back to login</a>
            </p>
        </form>
    </div>
</div>
