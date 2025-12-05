<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <div class="bg-white p-10 rounded-3xl shadow-[0_10px_40px_rgba(0,0,0,0.1)] w-full max-w-lg">
    <h2 class="text-4xl font-extrabold text-center mb-10 text-gray-900">Admin Login</h2>

    <!-- Error Box -->
    <div id="errorBox" class="hidden bg-red-100 text-red-700 p-4 rounded-xl mb-6 text-sm font-medium border border-red-300"></div>

    <form method="POST" action="{{ route('admin.login') }}" id="loginForm">
    @csrf   <!-- THIS IS REQUIRED! -->

    <!-- Error Box (Laravel + JS) -->
    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-6 text-sm font-medium border border-red-300">
            {{ $errors->first() }}
        </div>
    @endif

    <div id="errorBox" class="hidden bg-red-100 text-red-700 p-4 rounded-xl mb-6 text-sm font-medium border border-red-300"></div>

    <!-- EMAIL FIELD -->
    <div class="mb-6">
        <label class="block text-gray-800 font-semibold mb-2">Email</label>
        <input
            type="email"
            name="email"
            id="email"
            value="{{ old('email') }}"
            placeholder="Enter your email"
            class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-500 shadow-sm"
            required
        />
    </div>

    <!-- PASSWORD FIELD -->
    <div class="mb-6">
        <label class="block text-gray-800 font-semibold mb-2">Password</label>
        <div class="relative">
            <input
                type="password"
                name="password"
                id="password"
                placeholder="Enter your password"
                class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-500 shadow-sm"
                required
            />

            <!-- Eye Toggle Button -->
            <button
                type="button"
                id="togglePassword"
                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700"
            >
                <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.964 7.178... (same as yours)" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 hidden">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18M9.88 9.88A3 3 0 0114.12 14.12..." />
                </svg>
            </button>
        </div>
    </div>

    <!-- Remember Me -->
    <div class="flex items-center mb-8">
        <input type="checkbox" name="remember" id="remember" class="mr-2">
        <label for="remember" class="text-gray-800">Remember me</label>
    </div>

    <!-- Submit Button -->
    <button
        type="submit"
        class="w-full bg-indigo-600 text-white py-3 rounded-2xl font-semibold text-lg hover:bg-indigo-700 transition shadow-md"
    >
        Login
    </button>
</form>
  </div>

<script>
  const form = document.getElementById("loginForm");
  const email = document.getElementById("email");
  const password = document.getElementById("password");
  const errorBox = document.getElementById("errorBox");

  const toggleBtn = document.getElementById("togglePassword");
  const eyeOpen = document.getElementById("eyeOpen");
  const eyeClosed = document.getElementById("eyeClosed");

  // TOGGLE PASSWORD
  toggleBtn.addEventListener("click", () => {
    const isHidden = password.type === "password";
    password.type = isHidden ? "text" : "password";

    eyeOpen.classList.toggle("hidden", !isHidden);
    eyeClosed.classList.toggle("hidden", isHidden);
  });

  // VALIDATION + ERROR
  function showError(msg) {
    errorBox.textContent = msg;
    errorBox.classList.remove("hidden");
  }

  function clearError() {
    errorBox.classList.add("hidden");
  }

  function validate() {
    clearError();

    if (!email.value.trim()) return showError("Email is required.");
    if (!/\S+@\S+\.\S+/.test(email.value)) return showError("Enter a valid email address.");
    if (!password.value.trim()) return showError("Password is required.");
    if (password.value.length < 6) return showError("Password must be at least 6 characters.");

    return true;
  }

  // Live Validation
  email.addEventListener("input", validate);
  password.addEventListener("input", validate);

  // Submit Handler
  form.addEventListener("submit", (e) => {
    if (!validate()) e.preventDefault();
  });
</script>

</body>
</html>
