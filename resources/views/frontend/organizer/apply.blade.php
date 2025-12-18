<x-frontend.frontend-layout />

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { raleway: ["Raleway", "sans-serif"] },
                    colors: {
                        primary: "#FF7A28",  /* Orange */
                        darkBlue: "#063970" /* Blue */
                    },
                }
            }
        }
    </script>

    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">

            <!-- Header Section -->
            <div class="text-center mb-12">
                <h1 class="text-4xl lg:text-5xl font-bold text-darkBlue">
                    Become an Event Organizer
                </h1>
                <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">
                    Join our platform and start creating amazing events. Fill in your organization details below to get started.
                </p>
            </div>

            <!-- Form Card -->
            <div class="bg-white shadow-2xl rounded-2xl overflow-hidden">
                <div class="bg-darkBlue text-white px-8 py-10 text-center">
                    <h2 class="text-2xl lg:text-3xl font-bold">Organizer Registration Form</h2>
                    <p class="mt-2 opacity-90">All fields marked with <span class="text-primary">*</span> are required</p>
                </div>

                <div class="p-8 lg:p-12">
                    <form id="organizer-form" action="{{ route('organizer.apply') }}" method="POST" class="space-y-8">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                            <!-- Organization Name -->
                            <div>
                                <label for="organization_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Organization Name <span class="text-primary">*</span>
                                </label>
                                <input type="text" name="organization_name" id="organization_name" value="{{ old('organization_name') }}" required
                                       class="w-full px-5 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-gray-800"
                                       placeholder="e.g. Nepal Events Pvt. Ltd." />
                                @error('organization_name')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Contact Person Name -->
                            <div>
                                <label for="contact_person" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Contact Person Name <span class="text-primary">*</span>
                                </label>
                                <input type="text" name="contact_person" id="contact_person" value="{{ old('contact_person') }}" required
                                       class="w-full px-5 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                       placeholder="Full name of the main contact" />
                                @error('contact_person')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Email Address <span class="text-primary">*</span>
                                </label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                       class="w-full px-5 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                       placeholder="organizer@example.com" />
                                @error('email')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Phone Number <span class="text-primary">*</span>
                                </label>
                                <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required
                                       class="w-full px-5 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                       placeholder="+977 98XXXXXXXX" />
                                @error('phone')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Company Type -->
                            <div>
                                <label for="company_type" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Company Type <span class="text-primary">*</span>
                                </label>
                                <select name="company_type" id="company_type" required
                                        class="w-full px-5 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                    <option value="" disabled {{ old('company_type') ? '' : 'selected' }}>Select type</option>
                                    <option value="private_limited" {{ old('company_type') == 'private_limited' ? 'selected' : '' }}>Private Limited Company</option>
                                    <option value="public_limited" {{ old('company_type') == 'public_limited' ? 'selected' : '' }}>Public Limited Company</option>
                                    <option value="ngo" {{ old('company_type') == 'ngo' ? 'selected' : '' }}>NGO / Non-Profit</option>
                                    <option value="partnership" {{ old('company_type') == 'partnership' ? 'selected' : '' }}>Partnership Firm</option>
                                    <option value="sole_proprietorship" {{ old('company_type') == 'sole_proprietorship' ? 'selected' : '' }}>Sole Proprietorship</option>
                                    <option value="event_agency" {{ old('company_type') == 'event_agency' ? 'selected' : '' }}>Event Management Agency</option>
                                    <option value="other" {{ old('company_type') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('company_type')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Website (Optional) -->
                            <div>
                                <label for="website" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Website (Optional)
                                </label>
                                <input type="url" name="website" id="website" value="{{ old('website') }}"
                                       class="w-full px-5 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                       placeholder="https://yourwebsite.com" />
                                @error('website')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Address -->
                        <div>
                            <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">
                                Organization Address <span class="text-primary">*</span>
                            </label>
                            <textarea name="address" id="address" rows="4" required
                                      class="w-full px-5 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                      placeholder="Full office address (Street, City, Province, Nepal)">{{ old('address') }}</textarea>
                            @error('address')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                                About Your Organization (Optional)
                            </label>
                            <textarea name="description" id="description" rows="5"
                                      class="w-full px-5 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                      placeholder="Tell us about your experience in event management, types of events you organize, etc.">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center pt-6">
                            <button type="submit"
                                    class="px-12 py-5 bg-primary text-white font-bold text-xl rounded-xl hover:bg-orange-600 transition shadow-lg transform hover:scale-105">
                                Submit Application
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Application Submitted!',
                html: '<p class="text-gray-700 mt-4">{{ session('success') }}</p>',
                confirmButtonText: 'Great, Thanks!',
                confirmButtonColor: '#FF7A28',
                customClass: {
                    popup: 'rounded-2xl',
                    title: 'text-darkBlue',
                    confirmButton: 'px-8 py-3 text-lg font-bold'
                }
            }).then(() => {
                document.getElementById('organizer-form').reset();
            });
        @endif

        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Please Fix Errors',
                html: `
                    <ul class="text-left list-disc pl-6 mt-4 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                `,
                confirmButtonColor: '#FF7A28',
                customClass: {
                    popup: 'rounded-2xl'
                }
            });
        @endif
    </script>

    <x-frontend.footer-card />

