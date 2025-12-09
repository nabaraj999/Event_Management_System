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
            <h1 class="text-3xl font-bold text-darkBlue">Verify Your Email</h1>
        </div>

        <!-- Message -->
        <p class="text-gray-700 text-sm leading-relaxed mb-4">
            Thanks for signing up! Before getting started, please verify your email address
            by clicking the link we just emailed to you.
            If you didn’t receive the email, we will send you another.
        </p>

        <!-- Status -->
        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 text-sm font-semibold text-green-600 bg-green-50 border border-green-200 px-4 py-2 rounded-lg">
                A new verification link has been sent to your email address.
            </div>
        @endif

        <!-- Buttons -->
        <div class="mt-6 flex items-center justify-between">

            <!-- Resend Button -->
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button
                    class="bg-primary text-white px-5 py-3 rounded-lg font-semibold text-sm shadow-md hover:bg-orange-600 transition">
                    Resend Verification Email
                </button>
            </form>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button
                    type="submit"
                    class="underline text-sm text-gray-700 hover:text-primary transition">
                    Log Out
                </button>
            </form>
        </div>

    </div>
</div>
