<section>
    <form method="post" action="{{ route('password.update') }}" class="space-y-8">
        @csrf
        @method('put')

        <!-- Password Fields -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <!-- Current Password -->
            <div>
                <label for="current_password" class="block text-lg font-semibold text-darkBlue mb-2">
                    {{ __('Current Password') }}
                </label>
                <input
                    id="current_password"
                    name="current_password"
                    type="password"
                    required
                    autocomplete="current-password"
                    class="w-full px-5 py-4 text-gray-800 bg-white border-2 border-gray-300 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/20 focus:outline-none transition"
                />
                @if ($errors->updatePassword->has('current_password'))
                    <p class="mt-2 text-sm text-red-600 font-medium">
                        {{ $errors->updatePassword->first('current_password') }}
                    </p>
                @endif
            </div>

            <!-- New Password -->
            <div>
                <label for="password" class="block text-lg font-semibold text-darkBlue mb-2">
                    {{ __('New Password') }}
                </label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    required
                    autocomplete="new-password"
                    class="w-full px-5 py-4 text-gray-800 bg-white border-2 border-gray-300 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/20 focus:outline-none transition"
                />
                @if ($errors->updatePassword->has('password'))
                    <p class="mt-2 text-sm text-red-600 font-medium">
                        {{ $errors->updatePassword->first('password') }}
                    </p>
                @endif
            </div>

            <!-- Confirm New Password (full width on mobile) -->
            <div class="md:col-span-2">
                <label for="password_confirmation" class="block text-lg font-semibold text-darkBlue mb-2">
                    {{ __('Confirm New Password') }}
                </label>
                <input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    required
                    autocomplete="new-password"
                    class="w-full px-5 py-4 text-gray-800 bg-white border-2 border-gray-300 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/20 focus:outline-none transition"
                />
                @if ($errors->updatePassword->has('password_confirmation'))
                    <p class="mt-2 text-sm text-red-600 font-medium">
                        {{ $errors->updatePassword->first('password_confirmation') }}
                    </p>
                @endif
            </div>

        </div>

        <!-- Submit Button & Success Message -->
        <div class="flex items-center gap-6 pt-6">
            <button
                type="submit"
                class="px-10 py-4 bg-primary hover:bg-orange-600 text-white font-bold text-lg rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-200"
            >
                {{ __('Update Password') }}
            </button>

            @if (session('status') === 'password-updated')
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition.opacity
                    x-init="setTimeout(() => show = false, 4000)"
                    class="text-xl font-bold text-green-600 bg-green-50 px-6 py-3 rounded-lg"
                >
                    {{ __('Password updated successfully!') }}
                </div>
            @endif
        </div>
    </form>
</section>
