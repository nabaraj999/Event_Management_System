<x-organizer.organizer-layout>
    <div class="p-8 max-w-5xl mx-auto">

        <h1 class="text-3xl font-bold text-darkBlue">
            Welcome, {{ $organizer->contact_person ?? $organizer->organization_name }}!
        </h1>

        <p class="mt-4 text-lg text-gray-700">
            You are now logged in as an organizer. Start creating amazing events!
        </p>

        <!-- Profile Completion Warning -->
        @if(is_null($organizer->profile_completed_at))
            <div class="mt-8 p-6 bg-red-50 border-l-4 border-red-600 rounded-r-xl shadow-lg">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-red-800">Action Required: Complete Your Profile</h3>
                        <p class="mt-2 text-red-700">
                            You must <strong>fully update your organizer profile</strong> (including profile image, registration document, and all details)
                            <strong>within 24 hours</strong> of approval.
                        </p>
                        <p class="mt-2 text-red-700 font-semibold">
                            If not completed in time, your account will be <strong>frozen</strong> and you will be <strong>unable to create or manage events</strong>.
                        </p>
                        <div class="mt-4">
                            <a href="#"
                               class="inline-flex items-center px-5 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl shadow transition">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                </svg>
                                Update Profile Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Optional: Success message if profile is complete -->
            <div class="mt-8 p-6 bg-green-50 border-l-4 border-green-600 rounded-r-xl">
                <div class="flex items-center">
                    <svg class="h-8 w-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <p class="ml-3 text-green-800 font-semibold">
                        ✓ Your profile is complete. You can now create and manage events!
                    </p>
                </div>
            </div>
        @endif

        <!-- Logout Button -->
        <div class="mt-12">
            <a href="{{ route('org.logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="inline-flex items-center px-8 py-4 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl shadow-lg transition text-lg">
                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Logout
            </a>
        </div>

        <!-- Hidden Logout Form -->
        <form id="logout-form" action="{{ route('org.logout') }}" method="POST" class="hidden">
            @csrf
        </form>

    </div>
</x-organizer.organizer-layout>
