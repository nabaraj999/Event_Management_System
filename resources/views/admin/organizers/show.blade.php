<x-admin.admin-layout title="Review Organizer Application">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
          integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8">
        <div class="bg-white shadow-2xl rounded-2xl overflow-hidden">

            <!-- Header -->
            <div class="bg-[#063970] text-white px-6 py-5 lg:px-8 lg:py-6">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <h1 class="text-2xl lg:text-3xl font-bold">Organizer Application Review</h1>
                        <p class="opacity-90 text-sm lg:text-base mt-1">
                            {{ $organizer->organization_name }}
                            <span class="text-orange-300">• Applied on {{ $organizer->applied_at->format('d M Y') }}</span>
                        </p>
                    </div>

                    <!-- Status Toggle Button -->
                    <div class="flex flex-col sm:flex-row gap-3">
                        <form action="{{ route('admin.organizers.toggle', $organizer->id) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="px-8 py-4 text-white font-bold rounded-lg transition shadow-lg text-lg
                                           {{ $organizer->is_frozen
                                              ? 'bg-red-600 hover:bg-red-700'
                                              : 'bg-green-600 hover:bg-green-700' }}">
                                <i class="fas {{ $organizer->is_frozen ? 'fa-ban' : 'fa-check-circle' }} mr-2"></i>
                                {{ $organizer->is_frozen ? 'Inactive' : 'Active' }}
                            </button>
                        </form>

                        <a href="{{ route('admin.organizers.index') }}"
                           class="px-8 py-4 bg-white text-[#063970] font-bold rounded-lg hover:bg-gray-100 transition shadow text-center">
                            <i class="fas fa-arrow-left mr-2"></i> Back
                        </a>
                    </div>
                </div>
            </div>

            <!-- Current Status Badge -->
            <div class="mx-6 lg:mx-8 mt-6">
                <span class="inline-block px-6 py-3 text-lg font-bold rounded-xl
                             {{ $organizer->is_frozen
                                ? 'bg-green-100 text-green-800'
                                : 'bg-orange-100 text-orange-800' }}">
                    <i class="fas {{ $organizer->is_frozen ? 'fa-check-circle' : 'fa-clock' }} mr-2"></i>
                    Current Status: {{ $organizer->is_frozen ? 'ACTIVE (Approved)' : 'INACTIVE (Pending Review)' }}
                </span>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="mx-6 lg:mx-8 mt-6 bg-orange-50 border-l-4 border-[#FF7A28] text-orange-800 px-5 py-4 rounded-r-lg text-sm lg:text-base">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Main Content Grid -->
            <div class="p-6 lg:p-8 grid grid-cols-1 lg:grid-cols-2 gap-8">

                <!-- Left Column: Basic Information -->
                <div class="space-y-6">
                    <div class="bg-gray-50 rounded-xl p-6 shadow-inner">
                        <h2 class="text-xl font-bold text-[#063970] mb-5 flex items-center">
                            <i class="fas fa-building mr-3 text-[#FF7A28]"></i> Organization Details
                        </h2>
                        <div class="space-y-4 text-gray-700">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Organization Name</p>
                                <p class="text-lg font-semibold">{{ $organizer->organization_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Contact Person</p>
                                <p class="text-lg font-semibold">{{ $organizer->contact_person }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Email Address</p>
                                <p class="text-lg">{{ $organizer->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Phone Number</p>
                                <p class="text-lg">{{ $organizer->phone }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Company Type</p>
                                <p class="text-lg capitalize">{{ str_replace('_', ' ', $organizer->company_type) }}</p>
                            </div>
                            @if($organizer->website)
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Website</p>
                                    <a href="{{ $organizer->website }}" target="_blank"
                                       class="text-[#FF7A28] hover:underline font-medium">
                                        <i class="fas fa-external-link-alt mr-1"></i> {{ $organizer->website }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="bg-gray-50 rounded-xl p-6 shadow-inner">
                        <h2 class="text-xl font-bold text-[#063970] mb-4 flex items-center">
                            <i class="fas fa-map-marker-alt mr-3 text-[#FF7A28]"></i> Address
                        </h2>
                        <p class="text-gray-700 leading-relaxed">{{ $organizer->address ?: 'Not provided' }}</p>
                    </div>
                </div>

                <!-- Right Column: Documents & Description -->
                <div class="space-y-6">
                    <!-- Profile Image -->
                    @if($organizer->profile_image)
                        <div class="bg-gray-50 rounded-xl p-6 shadow-inner text-center">
                            <h2 class="text-xl font-bold text-[#063970] mb-5 flex items-center justify-center">
                                <i class="fas fa-image mr-3 text-[#FF7A28]"></i> Profile Image
                            </h2>
                            <img src="{{ Storage::disk('public')->url($organizer->profile_image) }}"
                                 alt="Profile Image"
                                 class="mx-auto max-h-96 rounded-xl shadow-lg object-cover">
                        </div>
                    @else
                        <div class="bg-gray-50 rounded-xl p-6 shadow-inner text-center text-gray-500">
                            <i class="fas fa-image text-6xl mb-4 text-gray-300"></i>
                            <p>No profile image uploaded</p>
                        </div>
                    @endif

                    <!-- Registration Document -->
                    @if($organizer->registration_document)
                        <div class="bg-gray-50 rounded-xl p-6 shadow-inner">
                            <h2 class="text-xl font-bold text-[#063970] mb-5 flex items-center">
                                <i class="fas fa-file-alt mr-3 text-[#FF7A28]"></i> Registration Document
                            </h2>
                            <a href="{{ Storage::disk('public')->url($organizer->registration_document) }}" target="_blank"
                               class="inline-flex items-center px-6 py-4 bg-[#FF7A28] text-white font-bold rounded-lg hover:bg-orange-600 transition shadow">
                                <i class="fas fa-eye mr-3 text-lg"></i> View Document
                            </a>
                        </div>
                    @else
                        <div class="bg-gray-50 rounded-xl p-6 shadow-inner text-center text-gray-500">
                            <i class="fas fa-file-alt text-6xl mb-4 text-gray-300"></i>
                            <p>No registration document uploaded</p>
                        </div>
                    @endif

                    <!-- About Organization -->
                    @if($organizer->description)
                        <div class="bg-gray-50 rounded-xl p-6 shadow-inner">
                            <h2 class="text-xl font-bold text-[#063970] mb-4 flex items-center">
                                <i class="fas fa-info-circle mr-3 text-[#FF7A28]"></i> About Organization
                            </h2>
                            <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $organizer->description }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="bg-gray-50 px-6 py-5 lg:px-8 lg:py-6 border-t flex justify-center">
                <a href="{{ route('admin.organizers.index') }}"
                   class="px-8 py-4 bg-[#063970] text-white font-bold rounded-lg hover:bg-[#052e5c] transition shadow">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Organizers List
                </a>
            </div>
        </div>
    </div>
</x-admin.admin-layout>
