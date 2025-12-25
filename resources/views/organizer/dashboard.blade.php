<x-organizer.organizer-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">

        <!-- Welcome Header -->
        <div class="text-center mb-10 bg-white rounded-2xl p-6 shadow">
            <h1 class="text-4xl lg:text-5xl font-extrabold text-darkBlue mb-3">
                Welcome back, {{ $organizer->contact_person ?? 'Organizer' }}!
            </h1>
            <p class="text-lg text-gray-600">Manage your profile from here</p>
        </div>

        <!-- TOP STATUS GRID (ONLY TWO CARDS) -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">

            <!-- Status Card -->
            <div class="bg-white rounded-2xl shadow-xl p-8 text-center border border-gray-100">
                <div class="mx-auto w-24 h-24 rounded-full flex items-center justify-center mb-6 bg-gray-100">
                    @if($organizer->is_frozen)
                        <svg class="w-12 h-12 text-darkBlue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    @else
                        <svg class="w-12 h-12 text-darkBlue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    @endif
                </div>

                <h3 class="text-2xl font-bold text-darkBlue mb-2">
                    {{ $organizer->is_frozen ? 'Account Approved' : 'Pending Approval' }}
                </h3>
                <p class="text-gray-600 mb-8">
                    {{ $organizer->is_frozen
                        ? 'Your account is verified.'
                        : 'Your KYC is under admin review.' }}
                </p>

                <div class="space-y-3">
                    @if(!$organizer->is_frozen)
                        <a href="{{ route('org.profile.edit') }}"
                           class="block w-full py-4 rounded-xl bg-darkBlue text-white font-bold transition">
                            Edit Profile (KYC)
                        </a>
                    @endif
                    <a href="{{ route('org.profile.show') }}"
                       class="block w-full py-4 rounded-xl border-2 border-darkBlue text-darkBlue font-bold transition">
                        View Full Profile
                    </a>
                </div>
            </div>

            <!-- Quick Info Card -->
            <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                <h3 class="text-xl font-bold text-darkBlue mb-6">
                    Organization Overview
                </h3>

                <div class="space-y-5">
                    <div class="flex justify-between border-b pb-3">
                        <span class="text-gray-600">Organization</span>
                        <span class="font-semibold text-darkBlue">{{ $organizer->organization_name }}</span>
                    </div>
                    <div class="flex justify-between border-b pb-3">
                        <span class="text-gray-600">Contact</span>
                        <span class="font-semibold">{{ $organizer->contact_person }}</span>
                    </div>
                    <div class="flex justify-between border-b pb-3">
                        <span class="text-gray-600">Email</span>
                        <span class="font-semibold">{{ $organizer->email }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Type</span>
                        <span class="font-semibold capitalize">
                            {{ str_replace('_', ' ', $organizer->company_type) }}
                        </span>
                    </div>
                </div>
            </div>

        </div>

        <!-- PROFILE DETAILS -->
        <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
            <h2 class="text-2xl font-bold text-darkBlue mb-8">
                Submitted Profile Details
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-gray-700">

                <div class="space-y-6">
                    <div>
                        <p class="text-sm text-gray-500">Organization Name</p>
                        <p class="text-lg font-semibold">{{ $organizer->organization_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Contact Person</p>
                        <p class="text-lg font-semibold">{{ $organizer->contact_person }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Phone</p>
                        <p class="text-lg font-semibold">{{ $organizer->phone }}</p>
                    </div>
                    @if($organizer->website)
                        <div>
                            <p class="text-sm text-gray-500">Website</p>
                            <a href="{{ $organizer->website }}" target="_blank"
                               class="text-lg font-semibold text-darkBlue underline">
                                {{ $organizer->website }}
                            </a>
                        </div>
                    @endif
                </div>

                <div class="space-y-6">
                    <div>
                        <p class="text-sm text-gray-500">Address</p>
                        <p class="text-lg bg-gray-50 p-4 rounded-xl">{{ $organizer->address }}</p>
                    </div>

                    @if($organizer->description)
                        <div>
                            <p class="text-sm text-gray-500">About Organization</p>
                            <p class="text-lg bg-gray-50 p-4 rounded-xl whitespace-pre-wrap">
                                {{ $organizer->description }}
                            </p>
                        </div>
                    @endif

                    @if($organizer->registration_document)
                        <div>
                            <a href="{{ Storage::disk('public')->url($organizer->registration_document) }}"
                               target="_blank"
                               class="inline-block px-6 py-4 bg-darkBlue text-white font-bold rounded-xl">
                                View Registration Document
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-10 pt-8 border-t text-center text-gray-600">
                {{ $organizer->is_frozen
                    ? 'Your profile is verified and locked.'
                    : 'You can edit your profile until approval.' }}
            </div>
        </div>

    </div>
</x-organizer.organizer-layout>
