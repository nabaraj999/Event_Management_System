<section>
    <form method="post" action="{{ route('user.profile.update') }}" class="space-y-8">
        @csrf
        @method('patch')

        <!-- Name and Email Fields -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Name Field -->
            <div>
                <label for="name" class="block text-lg font-semibold text-darkBlue mb-2">
                    {{ __('Name') }}
                </label>
                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name', $user->name) }}"
                    required
                    autofocus
                    autocomplete="name"
                    class="w-full px-5 py-4 text-gray-800 bg-white border-2 border-gray-300 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/20 focus:outline-none transition"
                />
                @if ($errors->has('name'))
                    <p class="mt-2 text-sm text-red-600 font-medium">
                        {{ $errors->first('name') }}
                    </p>
                @endif
            </div>

            <!-- Email Field -->
            <div>
                <label for="email" class="block text-lg font-semibold text-darkBlue mb-2">
                    {{ __('Email Address') }}
                </label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email', $user->email) }}"
                    required
                    autocomplete="username"
                    class="w-full px-5 py-4 text-gray-800 bg-white border-2 border-gray-300 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/20 focus:outline-none transition"
                />
                @if ($errors->has('email'))
                    <p class="mt-2 text-sm text-red-600 font-medium">
                        {{ $errors->first('email') }}
                    </p>
                @endif

                <!-- Email Verification Status -->
                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-4 p-4 bg-orange-50 border border-orange-200 rounded-lg">
                        <p class="text-sm text-orange-800 font-medium">
                            {{ __('Your email address is unverified.') }}
                        </p>
                        <button
                            form="send-verification"
                            type="submit"
                            class="mt-2 text-sm font-semibold text-primary hover:text-orange-700 underline"
                        >
                            {{ __('Click here to re-send the verification email') }}
                        </button>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-3 text-sm font-bold text-green-600">
                                {{ __('A new verification link has been sent to your email.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <!-- Submit Button & Success Message -->
        <div class="flex items-center gap-6 pt-6">
            <button
                type="submit"
                class="px-10 py-4 bg-primary hover:bg-orange-600 text-white font-bold text-lg rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-200"
            >
                {{ __('Save Changes') }}
            </button>

            @if (session('status') === 'profile-updated')
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition.opacity
                    x-init="setTimeout(() => show = false, 4000)"
                    class="text-xl font-bold text-green-600 bg-green-50 px-6 py-3 rounded-lg"
                >
                    {{ __('Saved successfully!') }}
                </div>
            @endif
        </div>
    </form>

    <!-- Hidden form for resending verification -->
    <form id="send-verification" method="post" action="{{ route('verification.send') }}" class="hidden">
        @csrf
    </form>
</section>
