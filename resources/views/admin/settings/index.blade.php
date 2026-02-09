<x-admin.admin-layout>
    <x-slot:title>
        Application Settings
    </x-slot:title>

    <div class="p-6 max-w-5xl mx-auto">

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-darkBlue font-raleway">
                Application Settings
            </h1>
            <p class="mt-2 text-gray-600">
                Control global feature toggles for algorithms and other behaviors.
            </p>
        </div>

        <!-- Success / Error Messages -->
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

        <!-- Main Settings Card -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">

            <div class="px-8 py-6 border-b border-gray-200 bg-gray-50">
                <h2 class="text-xl font-semibold text-darkBlue font-raleway">
                    Algorithm Controls
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Enable or disable recommendation/personalization features globally.
                </p>
            </div>

            <form method="POST" action="{{ route('admin.settings.update') }}" class="p-8">
                @csrf
                @method('PATCH')

                <div class="space-y-8">

                    <!-- User Algorithm -->
                    <div class="flex items-start justify-between gap-6">
                        <div class="flex-1">
                            <label class="text-lg font-medium text-gray-900 block">
                                User Algorithm
                            </label>
                            <p class="text-sm text-gray-500 mt-1.5 leading-relaxed">
                                When enabled: personalized event recommendations based on interests & booking history.<br>
                                When disabled: shows only the 3 most recently created upcoming events (no personalization).
                            </p>
                        </div>

                        <label class="relative inline-flex items-center cursor-pointer mt-1">
                            <input type="hidden" name="user_algorithm" value="0">
                            <input type="checkbox"
                                   name="user_algorithm"
                                   value="1"
                                   class="sr-only peer"
                                   {{ old('user_algorithm', $settings->user_algorithm ?? true) ? 'checked' : '' }}>
                            <div class="w-14 h-7 bg-gray-200 rounded-full peer
                                        peer-focus:outline-none peer-focus:ring-4
                                        peer-focus:ring-primary/30
                                        peer-checked:bg-primary
                                        peer-checked:after:translate-x-7
                                        after:content-[''] after:absolute after:top-0.5 after:left-[4px]
                                        after:bg-white after:border after:border-gray-300
                                        after:rounded-full after:h-6 after:w-6 after:transition-all">
                            </div>
                        </label>
                    </div>

                    <hr class="border-gray-200 my-2">

                    <!-- Organizer Algorithm -->
                    <div class="flex items-start justify-between gap-6">
                        <div class="flex-1">
                            <label class="text-lg font-medium text-gray-900 block">
                                Organizer Algorithm
                            </label>
                            <p class="text-sm text-gray-500 mt-1.5 leading-relaxed">
                                Enable/disable organizer-side smart features
                                (currently placeholder — will be used for organizer dashboard recommendations, analytics, etc. in future).
                            </p>
                        </div>

                        <label class="relative inline-flex items-center cursor-pointer mt-1">
                            <input type="hidden" name="organizer_algorithm" value="0">
                            <input type="checkbox"
                                   name="organizer_algorithm"
                                   value="1"
                                   class="sr-only peer"
                                   {{ old('organizer_algorithm', $settings->organizer_algorithm ?? true) ? 'checked' : '' }}>
                            <div class="w-14 h-7 bg-gray-200 rounded-full peer
                                        peer-focus:outline-none peer-focus:ring-4
                                        peer-focus:ring-primary/30
                                        peer-checked:bg-primary
                                        peer-checked:after:translate-x-7
                                        after:content-[''] after:absolute after:top-0.5 after:left-[4px]
                                        after:bg-white after:border after:border-gray-300
                                        after:rounded-full after:h-6 after:w-6 after:transition-all">
                            </div>
                        </label>
                    </div>

                </div>

                <!-- Actions -->
                <div class="mt-10 flex justify-end gap-4">
                    <button type="submit"
                            class="px-8 py-3 bg-primary text-white font-medium rounded-lg
                                   shadow hover:bg-orange-600 focus:outline-none focus:ring-2
                                   focus:ring-primary focus:ring-offset-2 transition">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-admin.admin-layout>
