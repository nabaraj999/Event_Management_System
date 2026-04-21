<section>
    <form method="post" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <!-- Current Password -->
            <div>
                <label for="current_password" class="block text-xs font-black text-gray-600 uppercase tracking-wider mb-2">
                    {{ __('Current Password') }}
                </label>
                <div class="relative">
                    <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                    <input id="current_password" name="current_password" type="password"
                        required autocomplete="current-password"
                        placeholder="••••••••"
                        class="w-full pl-11 pr-4 py-3.5 border {{ $errors->updatePassword->has('current_password') ? 'border-red-400' : 'border-gray-200' }} rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-medium" />
                </div>
                @if ($errors->updatePassword->has('current_password'))
                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i> {{ $errors->updatePassword->first('current_password') }}
                    </p>
                @endif
            </div>

            <!-- New Password -->
            <div>
                <label for="password" class="block text-xs font-black text-gray-600 uppercase tracking-wider mb-2">
                    {{ __('New Password') }}
                </label>
                <div class="relative">
                    <i class="fas fa-key absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                    <input id="password" name="password" type="password"
                        required autocomplete="new-password"
                        placeholder="••••••••"
                        class="w-full pl-11 pr-4 py-3.5 border {{ $errors->updatePassword->has('password') ? 'border-red-400' : 'border-gray-200' }} rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-medium" />
                </div>
                @if ($errors->updatePassword->has('password'))
                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i> {{ $errors->updatePassword->first('password') }}
                    </p>
                @endif
            </div>

            <!-- Confirm Password -->
            <div class="sm:col-span-2">
                <label for="password_confirmation" class="block text-xs font-black text-gray-600 uppercase tracking-wider mb-2">
                    {{ __('Confirm New Password') }}
                </label>
                <div class="relative">
                    <i class="fas fa-check-double absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                    <input id="password_confirmation" name="password_confirmation" type="password"
                        required autocomplete="new-password"
                        placeholder="••••••••"
                        class="w-full pl-11 pr-4 py-3.5 border {{ $errors->updatePassword->has('password_confirmation') ? 'border-red-400' : 'border-gray-200' }} rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-medium" />
                </div>
                @if ($errors->updatePassword->has('password_confirmation'))
                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i> {{ $errors->updatePassword->first('password_confirmation') }}
                    </p>
                @endif
            </div>
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit"
                class="inline-flex items-center gap-2 px-7 py-3 bg-darkBlue text-white font-bold rounded-xl shadow-md hover:bg-primary transition-colors text-sm">
                <i class="fas fa-shield-alt"></i> {{ __('Update Password') }}
            </button>
            @if (session('status') === 'password-updated')
                <div x-data="{ show: true }" x-show="show" x-transition.opacity
                     x-init="setTimeout(() => show = false, 3000)"
                     class="flex items-center gap-1.5 text-sm font-bold text-green-600 bg-green-50 px-4 py-2 rounded-xl border border-green-200">
                    <i class="fas fa-check-circle text-xs"></i> {{ __('Password updated!') }}
                </div>
            @endif
        </div>
    </form>
</section>
