<!-- resources/views/organizer/profile/show.blade.php -->

<x-organizer.organizer-layout>
    <div class="p-8 max-w-5xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-darkBlue">Organizer Profile</h1>

            <div class="flex gap-4">
                @if(!$organizer->is_frozen)
                    <span class="px-6 py-3 bg-orange-500 text-white font-bold rounded-xl">
                        Pending Admin Approval
                    </span>
                    <a href="{{ route('org.profile.edit') }}"
                       class="px-6 py-3 bg-primary hover:bg-blue-700 text-white font-bold rounded-xl transition">
                        Edit Full Profile
                    </a>
                @else
                    <span class="px-6 py-3 bg-green-600 text-white font-bold rounded-xl">
                        Approved & Active ✓
                    </span>
                @endif

                <!-- Always allow changing email/password -->
                <a href="{{ route('org.profile.settings') }}"
                   class="px-6 py-3 bg-gray-700 hover:bg-gray-800 text-white font-bold rounded-xl transition">
                    Change Email / Password
                </a>
            </div>
        </div>

        <!-- Rest of your beautiful read-only profile display (same as before) -->
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <!-- Profile Image, Name, Contact, etc. (keep your previous design) -->
            <!-- ... your existing display code ... -->
        </div>
    </div>
</x-organizer.organizer-layout>
