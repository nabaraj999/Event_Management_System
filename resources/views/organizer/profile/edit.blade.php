<x-organizer.organizer-layout>
    <div class="p-8 max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-darkBlue mb-8">Edit Organizer Profile</h1>

        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <form method="POST" action="{{ route('org.profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Organization Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Organization Name *</label>
                        <input type="text" name="organization_name" value="{{ old('organization_name', $organizer->organization_name) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-primary focus:border-primary" required>
                        @error('organization_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Contact Person -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Contact Person *</label>
                        <input type="text" name="contact_person" value="{{ old('contact_person', $organizer->contact_person) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-primary focus:border-primary" required>
                        @error('contact_person')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email (Read-only) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" value="{{ $organizer->email }}" disabled
                               class="w-full px-4 py-3 bg-gray-100 border border-gray-300 rounded-xl">
                    </div>

                    <!-- Phone -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone *</label>
                        <input type="text" name="phone" value="{{ old('phone', $organizer->phone) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-primary focus:border-primary" required>
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Company Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Company Type *</label>
                        <select name="company_type" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-primary focus:border-primary" required>
                            <option value="">Select Type</option>
                            <option value="private_limited" {{ old('company_type', $organizer->company_type) == 'private_limited' ? 'selected' : '' }}>Private Limited</option>
                            <option value="public_limited" {{ old('company_type', $organizer->company_type) == 'public_limited' ? 'selected' : '' }}>Public Limited</option>
                            <option value="ngo" {{ old('company_type', $organizer->company_type) == 'ngo' ? 'selected' : '' }}>NGO</option>
                            <option value="non_profit" {{ old('company_type', $organizer->company_type) == 'non_profit' ? 'selected' : '' }}>Non-Profit</option>
                            <option value="sole_proprietorship" {{ old('company_type', $organizer->company_type) == 'sole_proprietorship' ? 'selected' : '' }}>Sole Proprietorship</option>
                        </select>
                        @error('company_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Website -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Website</label>
                        <input type="url" name="website" value="{{ old('website', $organizer->website) }}"
                               placeholder="https://example.com"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-primary focus:border-primary">
                        @error('website')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Profile Image -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Profile Image</label>
                        @if($organizer->profile_image)
                            <img src="{{ Storage::disk('public')->url($organizer->profile_image) }}"
                                 class="h-32 w-32 object-cover rounded-xl mb-3 border">
                        @endif
                        <input type="file" name="profile_image" accept="image/*"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl">
                        @error('profile_image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Registration Document -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Registration Document (PDF/Image)</label>
                        @if($organizer->registration_document)
                            <a href="{{ Storage::disk('public')->url($organizer->registration_document) }}" target="_blank"
                               class="text-primary hover:underline text-sm">View Current Document</a>
                        @endif
                        <input type="file" name="registration_document" accept=".pdf,.jpeg,.jpg,.png"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl mt-2">
                        @error('registration_document')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Address *</label>
                        <textarea name="address" rows="3"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-primary focus:border-primary" required>{{ old('address', $organizer->address) }}</textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">About Organization</label>
                        <textarea name="description" rows="5"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-primary focus:border-primary"
                                  placeholder="Tell us about your organization...">{{ old('description', $organizer->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-10 flex justify-end gap-4">
                    <a href="{{ route('org.dashboard') }}"
                       class="px-8 py-4 bg-gray-600 hover:bg-gray-700 text-white font-bold rounded-xl transition">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-10 py-4 bg-primary hover:bg-blue-700 text-white font-bold rounded-xl transition shadow-lg text-lg">
                        Save Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-organizer.organizer-layout>
