<x-frontend.frontend-layout />

    <div class="py-12 lg:py-20 bg-gradient-to-b from-gray-50 to-gray-100 min-h-screen">
        <div class="max-w-5xl mx-auto px-6 lg:px-8">

            <!-- Page Title -->
            <div class="text-center mb-12">
                <h1 class="text-5xl lg:text-6xl font-extrabold text-darkBlue tracking-tight">
                    My Profile
                </h1>
                <p class="mt-4 text-lg text-gray-600 font-medium">
                    Manage your account settings and personal information
                </p>
            </div>

            <div class="grid lg:grid-cols-3 gap-10">

                <!-- Main Sections -->
                <div class="lg:col-span-2 space-y-10">

                    <!-- Profile Information -->
                    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-200">
                        <div class="bg-gradient-to-r from-darkBlue to-blue-900 text-white px-10 py-8">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="text-3xl font-bold">Profile Information</h2>
                                    <p class="mt-2 text-blue-100 opacity-90">
                                        Keep your personal details up to date
                                    </p>
                                </div>
                                <i class="fas fa-user-circle text-5xl opacity-50"></i>
                            </div>
                        </div>
                        <div class="p-10">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    <!-- Security / Password -->
                    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-200">
                        <div class="bg-gradient-to-r from-darkBlue to-blue-900 text-white px-10 py-8">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="text-3xl font-bold">Security</h2>
                                    <p class="mt-2 text-blue-100 opacity-90">
                                        Update your password regularly for better protection
                                    </p>
                                </div>
                                <i class="fas fa-shield-alt text-5xl opacity-50"></i>
                            </div>
                        </div>
                        <div class="p-10">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>

                    <!-- Danger Zone -->
                    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-200">
                        <div class="bg-gradient-to-r from-red-700 to-red-900 text-white px-10 py-8">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="text-3xl font-bold">Danger Zone</h2>
                                    <p class="mt-2 text-red-100 opacity-90">
                                        Permanently delete your account
                                    </p>
                                </div>
                                <i class="fas fa-exclamation-triangle text-5xl opacity-50"></i>
                            </div>
                        </div>
                        <div class="p-10">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>

                </div>

                <!-- User Summary Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-3xl shadow-xl border border-gray-200 overflow-hidden sticky top-28">
                        <div class="bg-gradient-to-b from-primary to-orange-600 text-white px-8 py-10 text-center">
                            <div class="w-32 h-32 mx-auto bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                                <i class="fas fa-user text-6xl text-white"></i>
                            </div>
                            <h3 class="mt-6 text-2xl font-bold">{{ Auth::user()->name }}</h3>
                            <p class="mt-2 text-orange-100">{{ Auth::user()->email }}</p>
                        </div>

                        <div class="p-8 space-y-6 text-gray-700">
                            <div class="flex items-center space-x-4">
                                <i class="fas fa-calendar-check text-primary text-xl"></i>
                                <div>
                                    <p class="font-semibold">Member Since</p>
                                    <p class="text-sm text-gray-500">{{ Auth::user()->created_at->format('M Y') }}</p>
                                </div>
                            </div>

                            <div class="flex items-center space-x-4">
                                <i class="fas fa-envelope text-primary text-xl"></i>
                                <div>
                                    <p class="font-semibold">Email Status</p>
                                    <p class="text-sm {{ $user->hasVerifiedEmail() ? 'text-green-600' : 'text-orange-600' }}">
                                        {{ $user->hasVerifiedEmail() ? 'Verified' : 'Unverified' }}
                                    </p>
                                </div>
                            </div>

                            <hr class="border-gray-200">

                            <p class="text-center text-sm text-gray-500">
                                Need help? <a href="#" class="text-primary font-medium hover:underline">Contact Support</a>
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


