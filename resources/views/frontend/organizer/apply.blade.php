<x-frontend.frontend-layout />

<!-- Page Hero -->
<div class="bg-gradient-to-br from-darkBlue via-[#0a4f9e] to-darkBlue pt-28 pb-16 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-96 h-96 bg-primary/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-300/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 text-center text-white">
        <div class="w-16 h-16 bg-primary/20 border border-primary/30 rounded-2xl flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-rocket text-primary text-2xl"></i>
        </div>
        <p class="text-primary font-bold text-xs mb-3 uppercase tracking-widest">Join EventHUB</p>
        <h1 class="font-raleway text-4xl sm:text-5xl font-black mb-4">Become an Organizer</h1>
        <p class="text-white/65 text-lg max-w-xl mx-auto">
            Join our platform and start creating amazing events. Fill in your organization details to get started.
        </p>
        <div class="flex flex-wrap justify-center gap-4 mt-8">
            @foreach(['Free to join', 'Reach thousands', 'Instant QR tickets', 'Easy payouts'] as $perk)
                <div class="flex items-center gap-2 bg-white/10 border border-white/15 px-4 py-2 rounded-full text-sm font-semibold backdrop-blur-sm">
                    <i class="fas fa-check text-green-400 text-xs"></i> {{ $perk }}
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Form Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-3xl mx-auto px-4 sm:px-6">

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50 flex items-center gap-3">
                <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-file-alt text-primary"></i>
                </div>
                <div>
                    <h2 class="font-raleway font-black text-darkBlue text-lg">Organizer Registration Form</h2>
                    <p class="text-xs text-gray-500 mt-0.5">Fields marked with <span class="text-primary font-bold">*</span> are required</p>
                </div>
            </div>

            <div class="p-8">
                <form id="organizer-form" action="{{ route('organizer.apply') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                        <!-- Organization Name -->
                        <div>
                            <label for="organization_name" class="block text-xs font-black text-gray-600 uppercase tracking-wider mb-2">
                                Organization Name <span class="text-primary">*</span>
                            </label>
                            <div class="relative">
                                <i class="fas fa-building absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                                <input type="text" name="organization_name" id="organization_name"
                                    value="{{ old('organization_name') }}" required
                                    placeholder="Nepal Events Pvt. Ltd."
                                    class="w-full pl-11 pr-4 py-3.5 border {{ $errors->has('organization_name') ? 'border-red-400' : 'border-gray-200' }} rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-medium" />
                            </div>
                            @error('organization_name')
                                <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Contact Person -->
                        <div>
                            <label for="contact_person" class="block text-xs font-black text-gray-600 uppercase tracking-wider mb-2">
                                Contact Person <span class="text-primary">*</span>
                            </label>
                            <div class="relative">
                                <i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                                <input type="text" name="contact_person" id="contact_person"
                                    value="{{ old('contact_person') }}" required
                                    placeholder="Full name of main contact"
                                    class="w-full pl-11 pr-4 py-3.5 border {{ $errors->has('contact_person') ? 'border-red-400' : 'border-gray-200' }} rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-medium" />
                            </div>
                            @error('contact_person')
                                <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-xs font-black text-gray-600 uppercase tracking-wider mb-2">
                                Email Address <span class="text-primary">*</span>
                            </label>
                            <div class="relative">
                                <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                                <input type="email" name="email" id="email"
                                    value="{{ old('email') }}" required
                                    placeholder="organizer@example.com"
                                    class="w-full pl-11 pr-4 py-3.5 border {{ $errors->has('email') ? 'border-red-400' : 'border-gray-200' }} rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-medium" />
                            </div>
                            @error('email')
                                <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-xs font-black text-gray-600 uppercase tracking-wider mb-2">
                                Phone Number <span class="text-primary">*</span>
                            </label>
                            <div class="relative">
                                <i class="fas fa-phone absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                                <input type="tel" name="phone" id="phone"
                                    value="{{ old('phone') }}" required
                                    placeholder="+977 98XXXXXXXX"
                                    class="w-full pl-11 pr-4 py-3.5 border {{ $errors->has('phone') ? 'border-red-400' : 'border-gray-200' }} rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-medium" />
                            </div>
                            @error('phone')
                                <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Company Type -->
                        <div>
                            <label for="company_type" class="block text-xs font-black text-gray-600 uppercase tracking-wider mb-2">
                                Company Type <span class="text-primary">*</span>
                            </label>
                            <div class="relative">
                                <i class="fas fa-briefcase absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                                <select name="company_type" id="company_type" required
                                    class="w-full pl-11 pr-4 py-3.5 border {{ $errors->has('company_type') ? 'border-red-400' : 'border-gray-200' }} rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-medium bg-white appearance-none">
                                    <option value="" disabled {{ old('company_type') ? '' : 'selected' }}>Select type</option>
                                    <option value="private_limited"     {{ old('company_type') == 'private_limited'     ? 'selected' : '' }}>Private Limited Company</option>
                                    <option value="public_limited"      {{ old('company_type') == 'public_limited'      ? 'selected' : '' }}>Public Limited Company</option>
                                    <option value="ngo"                 {{ old('company_type') == 'ngo'                 ? 'selected' : '' }}>NGO / Non-Profit</option>
                                    <option value="partnership"         {{ old('company_type') == 'partnership'         ? 'selected' : '' }}>Partnership Firm</option>
                                    <option value="sole_proprietorship" {{ old('company_type') == 'sole_proprietorship' ? 'selected' : '' }}>Sole Proprietorship</option>
                                    <option value="event_agency"        {{ old('company_type') == 'event_agency'        ? 'selected' : '' }}>Event Management Agency</option>
                                    <option value="other"               {{ old('company_type') == 'other'               ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            @error('company_type')
                                <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Website -->
                        <div>
                            <label for="website" class="block text-xs font-black text-gray-600 uppercase tracking-wider mb-2">
                                Website <span class="text-gray-400 font-normal normal-case">(Optional)</span>
                            </label>
                            <div class="relative">
                                <i class="fas fa-globe absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                                <input type="url" name="website" id="website"
                                    value="{{ old('website') }}"
                                    placeholder="https://yourwebsite.com"
                                    class="w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-medium" />
                            </div>
                            @error('website')
                                <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Address -->
                    <div>
                        <label for="address" class="block text-xs font-black text-gray-600 uppercase tracking-wider mb-2">
                            Organization Address <span class="text-primary">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-map-marker-alt absolute left-4 top-4 text-gray-400 text-sm pointer-events-none"></i>
                            <textarea name="address" id="address" rows="3" required
                                placeholder="Full office address (Street, City, Province, Nepal)"
                                class="w-full pl-11 pr-4 py-3.5 border {{ $errors->has('address') ? 'border-red-400' : 'border-gray-200' }} rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-medium resize-none">{{ old('address') }}</textarea>
                        </div>
                        @error('address')
                            <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-xs font-black text-gray-600 uppercase tracking-wider mb-2">
                            About Your Organization <span class="text-gray-400 font-normal normal-case">(Optional)</span>
                        </label>
                        <textarea name="description" id="description" rows="4"
                            placeholder="Tell us about your experience in event management, types of events you organize, etc."
                            class="w-full px-4 py-3.5 border border-gray-200 rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-medium resize-none">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit -->
                    <div class="pt-2">
                        <button type="submit"
                            class="btn-primary w-full py-4 text-white font-black text-base rounded-xl shadow-lg flex items-center justify-center gap-3">
                            <i class="fas fa-paper-plane"></i>
                            Submit Application
                        </button>
                        <p class="text-center text-xs text-gray-400 mt-3">By submitting, you agree to our Terms &amp; Conditions</p>
                    </div>
                </form>
            </div>
        </div>

    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Application Submitted!',
            html: '<p class="text-gray-700 mt-2">{{ session('success') }}</p>',
            confirmButtonText: 'Great, Thanks!',
            confirmButtonColor: '#FF7A28',
            customClass: { popup: 'rounded-2xl' }
        }).then(() => { document.getElementById('organizer-form').reset(); });
    @endif

    @if ($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Please Fix Errors',
            html: `<ul class="text-left list-disc pl-6 mt-3 space-y-1 text-sm">
                @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>`,
            confirmButtonColor: '#FF7A28',
            customClass: { popup: 'rounded-2xl' }
        });
    @endif
</script>

<x-frontend.footer-card />
