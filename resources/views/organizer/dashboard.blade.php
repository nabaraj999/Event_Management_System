<x-organizer.organizer-layout>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Page Heading -->
        <h1 class="text-3xl sm:text-4xl font-bold text-darkBlue mb-8">
            Welcome, {{ $organizer->contact_person ?? 'Organizer' }}
        </h1>

        <!-- TOP GRID -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">

            <!-- STATUS CARD -->
            <div class="bg-white rounded-xl shadow-md p-6 text-center">
                @if(!$organizer->is_frozen)
                    <div class="mx-auto w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-darkBlue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-darkBlue">Pending Approval</h3>
                    <p class="text-gray-600 text-sm mt-2">
                        Your profile is under admin review.
                    </p>
                @else
                    <div class="mx-auto w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-darkBlue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-darkBlue">Approved</h3>
                    <p class="text-gray-600 text-sm mt-2">
                        You can create and manage events.
                    </p>
                @endif

                <div class="mt-6 space-y-3">
                    @if(!$organizer->is_frozen)
                        <a href="{{ route('org.profile.edit') }}"
                           class="block w-full py-3 rounded-lg bg-darkBlue text-white font-semibold text-sm">
                            Edit Profile (KYC)
                        </a>
                    @endif
                    <a href="{{ route('org.profile.show') }}"
                       class="block w-full py-3 rounded-lg border border-darkBlue text-darkBlue font-semibold text-sm">
                        View Profile
                    </a>
                </div>
            </div>

            <!-- QUICK INFO -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-semibold text-darkBlue mb-4">
                    Organization Info
                </h3>

                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Organization</span>
                        <span class="font-medium">{{ $organizer->organization_name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Email</span>
                        <span class="font-medium">{{ $organizer->email }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Phone</span>
                        <span class="font-medium">{{ $organizer->phone }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Type</span>
                        <span class="font-medium capitalize">
                            {{ str_replace('_',' ',$organizer->company_type) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- PRIMARY ACTION -->
            <div class="bg-darkBlue rounded-xl shadow-md p-6 text-white text-center flex flex-col justify-center">
                <h3 class="text-xl font-bold mb-4">
                    Event Actions
                </h3>

                @if($organizer->is_frozen)
                    <p class="text-sm mb-6 opacity-90">
                        Your account is active.
                    </p>
                    <a href="{{ route('org.events.create') }}"
                       class="bg-white text-darkBlue py-3 rounded-lg font-semibold">
                        Create New Event
                    </a>
                @else
                    <p class="text-sm mb-6 opacity-90">
                        Complete KYC to unlock event creation.
                    </p>
                    <a href="{{ route('org.profile.edit') }}"
                       class="bg-white text-darkBlue py-3 rounded-lg font-semibold">
                        Complete Profile
                    </a>
                @endif
            </div>
        </div>

        <!-- PROFILE DETAILS -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-xl font-bold text-darkBlue mb-6">
                Submitted Profile Details
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">

                <!-- LEFT -->
                <div class="space-y-4">
                    <div>
                        <p class="text-gray-500">Organization Name</p>
                        <p class="font-medium">{{ $organizer->organization_name }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Contact Person</p>
                        <p class="font-medium">{{ $organizer->contact_person }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Email</p>
                        <p class="font-medium">{{ $organizer->email }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Phone</p>
                        <p class="font-medium">{{ $organizer->phone }}</p>
                    </div>

                    @if($organizer->website)
                        <div>
                            <p class="text-gray-500">Website</p>
                            <a href="{{ $organizer->website }}" target="_blank"
                               class="font-medium text-darkBlue underline">
                                {{ $organizer->website }}
                            </a>
                        </div>
                    @endif
                </div>

                <!-- RIGHT -->
                <div class="space-y-4">
                    <div>
                        <p class="text-gray-500">Address</p>
                        <p class="font-medium bg-gray-50 p-3 rounded-lg">
                            {{ $organizer->address }}
                        </p>
                    </div>

                    @if($organizer->description)
                        <div>
                            <p class="text-gray-500">About</p>
                            <p class="font-medium bg-gray-50 p-3 rounded-lg whitespace-pre-wrap">
                                {{ $organizer->description }}
                            </p>
                        </div>
                    @endif

                    @if($organizer->registration_document)
                        <div>
                            <a href="{{ Storage::disk('public')->url($organizer->registration_document) }}"
                               target="_blank"
                               class="inline-block mt-2 px-5 py-3 rounded-lg bg-darkBlue text-white font-semibold text-sm">
                                View Registration Document
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- FOOTER NOTE -->
            <div class="mt-8 pt-6 border-t text-center text-sm text-gray-500">
                @if(!$organizer->is_frozen)
                    Profile is editable until approval.
                @else
                    Profile is locked after verification.
                @endif
            </div>
        </div>
    </div>
</x-organizer.organizer-layout>
