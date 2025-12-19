<x-organizer.organizer-layout>
    <div class="p-8 max-w-5xl mx-auto">
        <h1 class="text-3xl font-bold text-darkBlue mb-8">Edit Organizer Profile</h1>

        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <form method="POST" action="{{ route('org.profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Profile Image Section (Full width for better preview) -->
                <div class="mb-8 text-center">
                    <label class="block text-lg font-medium text-gray-700 mb-4">Profile Image</label>

                    <div class="inline-block relative">
                        @if($organizer->profile_image)
                            <img src="{{ Storage::disk('public')->url($organizer->profile_image) }}"
                                 alt="Current Profile Image"
                                 class="h-48 w-48 object-cover rounded-full border-4 border-gray-200 shadow-lg">
                        @else
                            <div class="h-48 w-48 bg-gray-200 border-4 border-dashed border-gray-400 rounded-full flex items-center justify-center">
                                <span class="text-gray-500 text-lg">No Image</span>
                            </div>
                        @endif
                    </div>

                    <div class="mt-6">
                        <input type="file" name="profile_image" accept="image/*"
                               class="block w-full text-sm text-gray-600 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-blue-700 cursor-pointer">
                        <p class="mt-2 text-sm text-gray-500">Upload a new image to replace the current one (JPG, PNG, max 2MB recommended)</p>
                    </div>

                    @error('profile_image')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Organization Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Organization Name <span class="text-red-600">*</span></label>
                        <input type="text" name="organization_name" value="{{ old('organization_name', $organizer->organization_name) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-primary focus:border-primary" required>
                        @error('organization_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Contact Person -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Contact Person <span class="text-red-600">*</span></label>
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
                               class="w-full px-4 py-3 bg-gray-100 border border-gray-300 rounded-xl cursor-not-allowed">
                    </div>

                    <!-- Phone -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone <span class="text-red-600">*</span></label>
                        <input type="text" name="phone" value="{{ old('phone', $organizer->phone) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-primary focus:border-primary" required>
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Company Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Company Type <span class="text-red-600">*</span></label>
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

                    <!-- Registration Document -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Registration Document (PDF/Image)</label>
                        @if($organizer->registration_document)
                            <div class="mb-3">
                                <a href="{{ Storage::disk('public')->url($organizer->registration_document) }}" target="_blank"
                                   class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-xl hover:bg-blue-700 transition">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    View Current Document
                                </a>
                            </div>
                        @endif
                        <input type="file" name="registration_document" accept=".pdf,.jpeg,.jpg,.png"
                               class="block w-full text-sm text-gray-600 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-gray-600 file:text-white hover:file:bg-gray-700 cursor-pointer">
                        @error('registration_document')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Address <span class="text-red-600">*</span></label>
                        <textarea name="address" rows="4"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-primary focus:border-primary" required>{{ old('address', $organizer->address) }}</textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">About Organization</label>
                        <textarea name="description" rows="6"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-primary focus:border-primary"
                                  placeholder="Tell us about your organization, its mission, and experience...">{{ old('description', $organizer->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Buttons -->
                <div class="mt-12 flex justify-end gap-6">
                    <a href="{{ route('org.dashboard') }}"
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
