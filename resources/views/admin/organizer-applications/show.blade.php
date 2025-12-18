<x-admin.admin-layout title="Application: {{ $application->organization_name }}">

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
        <div class="bg-white shadow-2xl rounded-2xl overflow-hidden">

            <!-- Header -->
            <div class="bg-darkBlue text-white px-6 sm:px-8 py-6 sm:py-8">
                <h1 class="text-2xl sm:text-3xl font-bold break-words">
                    {{ $application->organization_name }}
                </h1>
                <p class="mt-2 text-sm sm:text-lg opacity-90">
                    Applied on
                    @if($application->applied_at)
                        {{ $application->applied_at->format('d F Y, h:i A') }}
                    @else
                        <span class="italic text-gray-300">Date not available</span>
                    @endif
                </p>
            </div>

            <div class="p-6 sm:p-8 lg:p-12">

                <!-- Status Badge -->
                <div class="mb-8 text-center">
                    @switch($application->status)
                        @case('pending')
                            <span class="px-4 sm:px-6 py-2 sm:py-3 rounded-full text-sm sm:text-lg font-bold bg-yellow-100 text-yellow-800">
                                PENDING REVIEW
                            </span>
                            @break
                        @case('approved')
                            <span class="px-4 sm:px-6 py-2 sm:py-3 rounded-full text-sm sm:text-lg font-bold bg-green-100 text-green-800">
                                APPROVED
                            </span>
                            @break
                        @case('rejected')
                            <span class="px-4 sm:px-6 py-2 sm:py-3 rounded-full text-sm sm:text-lg font-bold bg-red-100 text-red-800">
                                REJECTED
                            </span>
                            @break
                    @endswitch
                </div>

                <!-- Details Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8 text-sm sm:text-base">
                    <div>
                        <p class="text-gray-500 mb-1">Contact Person</p>
                        <p class="font-semibold text-darkBlue">
                            {{ $application->contact_person ?? 'Not provided' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-500 mb-1">Email</p>
                        <p class="font-medium break-all">{{ $application->email }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500 mb-1">Phone</p>
                        <p class="font-medium">{{ $application->phone }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500 mb-1">Company Type</p>
                        <p class="font-medium capitalize">
                            {{ str_replace('_', ' ', $application->company_type) }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-500 mb-1">Website</p>
                        @if($application->website)
                            <a href="{{ $application->website }}"
                               target="_blank"
                               class="text-primary hover:underline break-all">
                                {{ $application->website }}
                            </a>
                        @else
                            <span class="text-gray-400">Not provided</span>
                        @endif
                    </div>

                    <div class="md:col-span-2">
                        <p class="text-gray-500 mb-1">Address</p>
                        <p class="font-medium">{{ $application->address }}</p>
                    </div>

                    <div class="md:col-span-2">
                        <p class="text-gray-500 mb-1">About Organization</p>
                        <p class="text-gray-700 leading-relaxed">
                            {{ $application->description ?? 'No description provided.' }}
                        </p>
                    </div>
                </div>

                <!-- Action Buttons (Only if Pending) -->
                @if($application->status === 'pending')
                    <div class="mt-12 flex flex-col sm:flex-row justify-center gap-4 sm:gap-6">
                        <form action="{{ route('admin.organizer-applications.approve', $application) }}" method="POST">
                            @csrf
                            <button type="submit"
                                    onclick="return confirm('Approve this organizer?\nThey will be able to create events.')"
                                    class="w-full sm:w-auto px-6 sm:px-10 py-3 sm:py-4 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition shadow-lg text-base sm:text-xl">
                                Approve Application
                            </button>
                        </form>

                        <form action="{{ route('admin.organizer-applications.reject', $application) }}" method="POST">
                            @csrf
                            <button type="submit"
                                    onclick="return confirm('Reject this application?')"
                                    class="w-full sm:w-auto px-6 sm:px-10 py-3 sm:py-4 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition shadow-lg text-base sm:text-xl">
                                Reject Application
                            </button>
                        </form>
                    </div>
                @endif

                <!-- Back Button -->
                <div class="mt-10 text-center">
                    <a href="{{ route('admin.organizer-applications.index') }}"
                       class="inline-flex items-center gap-2 px-6 sm:px-8 py-3 sm:py-4 bg-darkBlue hover:bg-[#052e5c] text-white font-bold rounded-xl transition shadow-lg text-base sm:text-lg">
                        ← Back to Applications
                    </a>
                </div>

            </div>
        </div>
    </div>

</x-admin.admin-layout>
