<!-- resources/views/organizer/profile/settings.blade.php -->

<x-organizer.organizer-layout>
    <div class="p-8 max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-darkBlue mb-8">Account Settings</h1>

        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <form method="POST" action="{{ route('org.profile.settings.update') }}">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Current Email</label>
                        <input type="email" name="email" value="{{ old('email', $organizer->email) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-primary focus:border-primary" required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div></div> <!-- Spacer -->

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">New Password (leave blank to keep current)</label>
                        <input type="password" name="password"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-primary focus:border-primary">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                        <input type="password" name="password_confirmation"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-primary focus:border-primary">
                    </div>
                </div>

                <div class="mt-10 flex justify-end gap-4">
                    <a href="{{ route('org.profile.show') }}"
                       class="px-8 py-4 bg-gray-600 hover:bg-gray-700 text-white font-bold rounded-xl transition">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-10 py-4 bg-primary hover:bg-blue-700 text-white font-bold rounded-xl transition shadow-lg text-lg">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-organizer.organizer-layout>
