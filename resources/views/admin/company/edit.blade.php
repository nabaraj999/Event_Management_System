{{-- resources/views/admin/company/edit.blade.php --}}
<x-admin.admin-layout title="Company Information Settings">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white shadow-2xl rounded-xl overflow-hidden">

            <!-- Header - Solid Brand Color -->
            <div class="bg-[#FF7A28] text-white px-8 py-6">
                <h1 class="text-3xl font-bold">Company Information Settings</h1>
                <p class="opacity-90 mt-1">Manage your company profile, branding, contact, and legal details</p>
            </div>

            <!-- Form -->
            <form action="{{ route('admin.company.update') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-12">
                @csrf
                @method('PUT')

                <!-- 1. Basic Information -->
                <div class="border-b border-gray-200 pb-10">
                    <h2 class="text-2xl font-bold text-[#063970] mb-8">Basic Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Company Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $company->name) }}" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF7A28] focus:border-[#FF7A28] transition">
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tagline</label>
                            <input type="text" name="tagline" value="{{ old('tagline', $company->tagline) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF7A28] focus:border-[#FF7A28]">
                            @error('tagline') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email', $company->email) }}" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF7A28] focus:border-[#FF7A28]">
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone', $company->phone) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF7A28] focus:border-[#FF7A28]">
                            @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Website</label>
                            <input type="url" name="website" value="{{ old('website', $company->website) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF7A28] focus:border-[#FF7A28]">
                            @error('website') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Location / City</label>
                            <input type="text" name="location" value="{{ old('location', $company->location) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF7A28] focus:border-[#FF7A28]">
                            @error('location') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- 2. Media & Branding -->
                <div class="border-b border-gray-200 pb-10">
                    <h2 class="text-2xl font-bold text-[#063970] mb-8">Media & Branding</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                        @foreach(['logo' => 'Logo', 'favicon' => 'Favicon', 'bg_image' => 'Hero Image', 'about_us_image' => 'About Us Image'] as $field => $label)
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">{{ $label }}</label>
                                @if($company->{"{$field}_url"})
                                    <img src="{{ $company->{"{$field}_url"} }}" alt="{{ $label }}"
                                         class="h-24 w-full object-contain border-2 border-gray-200 rounded-lg mb-3">
                                @endif
                                <input type="file" name="{{ $field }}" accept="image/*"
                                       class="block w-full text-sm text-gray-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:bg-[#FF7A28] file:text-white hover:file:bg-[#e65100] cursor-pointer transition">
                                @error($field) <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- 3. Social Media Links -->
                <div class="border-b border-gray-200 pb-10">
                    <h2 class="text-2xl font-bold text-gray-800 mb-8">Social Media Links</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach(['facebook', 'instagram', 'youtube', 'linkedin', 'twitter', 'tiktok'] as $social)
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2 capitalize">{{ ucfirst($social) }}</label>
                                <input type="url" name="{{ $social }}" value="{{ old($social, $company->{$social}) }}"
                                       placeholder="https://{{ $social }}.com/yourprofile"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                @error($social) <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- 4. About Us Section -->
                <div class="border-b border-gray-200 pb-10">
                    <h2 class="text-2xl font-bold text-gray-800 mb-8">About Us Section</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Title</label>
                            <input type="text" name="about_us_title" value="{{ old('about_us_title', $company->about_us_title) }}" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                            <textarea name="about_us_description" rows="6" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">{{ old('about_us_description', $company->about_us_description) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- 5. Legal & Stats -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10 border-b border-gray-200 pb-10">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Legal & Registration</h2>
                        <div class="space-y-5">
                            <input type="text" name="reg_no" value="{{ old('reg_no', $company->reg_no) }}" placeholder="Company Registration No." class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                            <input type="text" name="pan_no" value="{{ old('pan_no', $company->pan_no) }}" placeholder="PAN / Tax ID" class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                            <input type="text" name="gst_no" value="{{ old('gst_no', $company->gst_no) }}" placeholder="GST No." class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                            <input type="number" name="company_start" value="{{ old('company_start', $company->company_start) }}" placeholder="Year Established" class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                        </div>
                    </div>

                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Company Stats</h2>
                        <div class="space-y-5">
                            <input type="number" name="total_employees" value="{{ old('total_employees', $company->total_employees) }}" placeholder="Total Employees" required class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                            <input type="number" name="total_events" value="{{ old('total_events', $company->total_events) }}" placeholder="Total Events" required class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                            <input type="number" name="satisfied_clients" value="{{ old('satisfied_clients', $company->satisfied_clients) }}" placeholder="Satisfied Clients" required class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                            <input type="text" name="net_worth" value="{{ old('net_worth', $company->net_worth) }}" placeholder="e.g. $50M+, ₹500 Crore+" class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                        </div>
                    </div>
                </div>

                <!-- 6. Advanced Fields -->
                <div class="space-y-8">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Full Address</label>
                        <textarea name="address_full" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg">{{ old('address_full', $company->address_full) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Google Maps Link</label>
                        <input type="url" name="map_link" value="{{ old('map_link', $company->map_link) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Working Hours (JSON)</label>
                            <textarea name="working_hours" rows="6" class="font-mono text-xs w-full px-4 py-3 border border-gray-300 rounded-lg" placeholder='{ "mon-fri": "9AM-6PM", "sat": "10AM-4PM", "sun": "Closed" }'>{{ old('working_hours', $company->working_hours ? json_encode($company->working_hours, JSON_PRETTY_PRINT) : '') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Extra Links (JSON)</label>
                            <textarea name="extra_links" rows="6" class="font-mono text-xs w-full px-4 py-3 border border-gray-300 rounded-lg" placeholder='{ "Careers": "/careers", "Blog": "/blog" }'>{{ old('extra_links', $company->extra_links ? json_encode($company->extra_links, JSON_PRETTY_PRINT) : '') }}</textarea>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3 pt-6">
                        <input type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $company->is_active) ? 'checked' : '' }} class="h-6 w-6 text-indigo-600 rounded focus:ring-indigo-500">
                        <label for="is_active" class="text-lg font-medium text-gray-700">Company is Active</label>
                    </div>
                </div>
                
                <!-- Submit Button -->
                <div class="flex justify-end pt-10 border-t border-gray-200">
                    <button type="submit"
                            class="px-12 py-4 bg-[#FF7A28] hover:bg-[#e65100] text-white font-bold text-lg rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-300">
                        Save All Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- SweetAlert2 - Success shows for 5 seconds only -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true,
                    background: '#FFF4E5',
                    color: '#D35400',
                    customClass: {
                        popup: 'animate__animated animate__fadeInRight'
                    }
                });
            @endif

            @if($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    html: `<ul class="text-left text-sm mt-3 space-y-1">
                        @foreach($errors->all() as $error)<li>• {{ $error }}</li>@endforeach
                    </ul>`,
                    confirmButtonText: 'Okay',
                    confirmButtonColor: '#dc2626',
                    customClass: { popup: 'animate__animated animate__shakeX' }
                });
            @endif
        });
    </script>
</x-admin.admin-layout>
