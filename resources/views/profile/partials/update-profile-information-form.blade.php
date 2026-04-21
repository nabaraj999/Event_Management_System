<section>
    <form method="post" action="{{ route('user.profile.update') }}" class="space-y-5">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <!-- Name -->
            <div>
                <label for="name" class="block text-xs font-black text-gray-600 uppercase tracking-wider mb-2">
                    {{ __('Full Name') }}
                </label>
                <div class="relative">
                    <i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                    <input id="name" name="name" type="text"
                        value="{{ old('name', $user->name) }}"
                        required autofocus autocomplete="name"
                        class="w-full pl-11 pr-4 py-3.5 border {{ $errors->has('name') ? 'border-red-400' : 'border-gray-200' }} rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-medium" />
                </div>
                @if ($errors->has('name'))
                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i> {{ $errors->first('name') }}
                    </p>
                @endif
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-xs font-black text-gray-600 uppercase tracking-wider mb-2">
                    {{ __('Email Address') }}
                </label>
                <div class="relative">
                    <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                    <input id="email" name="email" type="email"
                        value="{{ old('email', $user->email) }}"
                        required autocomplete="username"
                        class="w-full pl-11 pr-4 py-3.5 border {{ $errors->has('email') ? 'border-red-400' : 'border-gray-200' }} rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-medium" />
                </div>
                @if ($errors->has('email'))
                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i> {{ $errors->first('email') }}
                    </p>
                @endif

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-3 p-3.5 bg-orange-50 border border-orange-200 rounded-xl flex items-start gap-2.5">
                        <i class="fas fa-exclamation-circle text-orange-500 text-sm mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="text-xs text-orange-700 font-semibold">Email not verified</p>
                            <button form="send-verification" type="submit"
                                class="text-xs font-bold text-primary hover:underline mt-0.5">
                                Re-send verification email →
                            </button>
                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-1.5 text-xs font-bold text-green-600">Verification link sent!</p>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit"
                class="btn-primary inline-flex items-center gap-2 px-7 py-3 text-white font-bold rounded-xl shadow-md text-sm">
                <i class="fas fa-save"></i> {{ __('Save Changes') }}
            </button>
            @if (session('status') === 'profile-updated')
                <div x-data="{ show: true }" x-show="show" x-transition.opacity
                     x-init="setTimeout(() => show = false, 3000)"
                     class="flex items-center gap-1.5 text-sm font-bold text-green-600 bg-green-50 px-4 py-2 rounded-xl border border-green-200">
                    <i class="fas fa-check-circle text-xs"></i> {{ __('Saved!') }}
                </div>
            @endif
        </div>
    </form>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}" class="hidden">
        @csrf
    </form>
</section>
