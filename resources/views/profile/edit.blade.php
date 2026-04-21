<x-frontend.frontend-layout />

<!-- Page Header -->
<div class="bg-gradient-to-br from-darkBlue via-[#0a4f9e] to-darkBlue pt-28 pb-16 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-96 h-96 bg-primary/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-300/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="relative max-w-5xl mx-auto px-4 sm:px-6 text-white">
        <p class="text-primary font-bold text-xs mb-2 uppercase tracking-widest">Account</p>
        <h1 class="font-raleway text-4xl sm:text-5xl font-black mb-2">My Profile</h1>
        <p class="text-white/60 text-base">Manage your personal information and account settings</p>
    </div>
</div>

<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6">
        <div class="grid lg:grid-cols-3 gap-8">

            <!-- Sidebar -->
            <aside class="lg:col-span-1 lg:sticky lg:top-20 lg:self-start">
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <!-- Avatar Header -->
                    <div class="bg-gradient-to-br from-primary to-orange-500 px-6 py-10 text-center">
                        <div class="w-24 h-24 mx-auto bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center border-4 border-white/40 mb-4">
                            <span class="font-raleway font-black text-4xl text-white">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                        </div>
                        <h3 class="font-raleway font-black text-xl text-white">{{ Auth::user()->name }}</h3>
                        <p class="text-white/75 text-sm mt-1 truncate px-2">{{ Auth::user()->email }}</p>
                    </div>

                    <!-- Meta Info -->
                    <div class="p-6 space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-orange-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-calendar-check text-primary text-sm"></i>
                            </div>
                            <div>
                                <p class="text-xs font-black text-gray-500 uppercase tracking-wider">Member Since</p>
                                <p class="text-sm font-bold text-darkBlue">{{ Auth::user()->created_at->format('F Y') }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-orange-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-envelope text-primary text-sm"></i>
                            </div>
                            <div>
                                <p class="text-xs font-black text-gray-500 uppercase tracking-wider">Email Status</p>
                                <p class="text-sm font-bold {{ $user->hasVerifiedEmail() ? 'text-green-600' : 'text-orange-500' }} flex items-center gap-1.5">
                                    <i class="fas {{ $user->hasVerifiedEmail() ? 'fa-check-circle' : 'fa-exclamation-circle' }} text-xs"></i>
                                    {{ $user->hasVerifiedEmail() ? 'Verified' : 'Unverified' }}
                                </p>
                            </div>
                        </div>

                        <div class="h-px bg-gray-100"></div>

                        <!-- Quick Nav -->
                        <div class="space-y-1">
                            <a href="{{ route('user.profile.history') }}"
                               class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-orange-50 text-gray-700 hover:text-primary transition-colors font-semibold text-sm">
                                <i class="fas fa-ticket w-4 text-center text-gray-400"></i> My Bookings
                            </a>
                            <a href="{{ route('events.index') }}"
                               class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-orange-50 text-gray-700 hover:text-primary transition-colors font-semibold text-sm">
                                <i class="fas fa-calendar-alt w-4 text-center text-gray-400"></i> Browse Events
                            </a>
                            <a href="{{ route('contact') }}"
                               class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-orange-50 text-gray-700 hover:text-primary transition-colors font-semibold text-sm">
                                <i class="fas fa-headset w-4 text-center text-gray-400"></i> Contact Support
                            </a>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Profile Information -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-7 py-5 border-b border-gray-100 bg-gray-50/50 flex items-center gap-3">
                        <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-user text-primary"></i>
                        </div>
                        <div>
                            <h2 class="font-raleway font-black text-darkBlue">Profile Information</h2>
                            <p class="text-xs text-gray-500 mt-0.5">Keep your personal details up to date</p>
                        </div>
                    </div>
                    <div class="p-7">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Security -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-7 py-5 border-b border-gray-100 bg-gray-50/50 flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-shield-alt text-darkBlue"></i>
                        </div>
                        <div>
                            <h2 class="font-raleway font-black text-darkBlue">Security</h2>
                            <p class="text-xs text-gray-500 mt-0.5">Update your password regularly for better protection</p>
                        </div>
                    </div>
                    <div class="p-7">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Danger Zone -->
                <div class="bg-white rounded-3xl shadow-sm border border-red-100 overflow-hidden">
                    <div class="px-7 py-5 border-b border-red-100 bg-red-50/50 flex items-center gap-3">
                        <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-red-500"></i>
                        </div>
                        <div>
                            <h2 class="font-raleway font-black text-red-700">Danger Zone</h2>
                            <p class="text-xs text-red-400 mt-0.5">Permanently delete your account and all data</p>
                        </div>
                    </div>
                    <div class="p-7">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
