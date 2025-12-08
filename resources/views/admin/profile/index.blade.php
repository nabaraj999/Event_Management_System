<x-admin.admin-layout>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">

            <!-- Solid Dark Blue Header -->
            <div class="bg-darkBlue px-6 py-8 sm:px-10 text-white">
                <h1 class="text-2xl sm:text-3xl font-bold">My Profile</h1>
                <p class="mt-2 text-blue-100">Manage your account information</p>
            </div>

            <div class="p-6 sm:p-8 lg:p-10">
                <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <!-- Personal Information -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                            <input type="text" name="name" value="{{ old('name', $admin->name) }}" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent transition">
                            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                            <input type="email" name="email" value="{{ old('email', $admin->email) }}" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent transition">
                            @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Phone (Optional)</label>
                            <input type="text" name="phone" value="{{ old('phone', $admin->phone) }}" placeholder="+1234567890"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent transition">
                            @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Account Status</label>
                            <div class="flex items-center h-12 px-4 bg-gray-50 rounded-xl">
                                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-medium
                                    {{ $admin->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($admin->status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Password Section -->
                    <div class="border-t pt-8">
                        <h3 class="text-lg font-bold text-darkBlue mb-6">Change Password (Leave blank to keep current)</h3>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">

                            <!-- Current Password -->
                            <div class="relative">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Current Password</label>
                                <input type="password" name="current_password" id="current_password" autocomplete="off"
                                       class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                                <button type="button" onclick="togglePassword('current_password')"
                                        class="absolute inset-y-0 right-0 flex items-center pr-4 pt-8 text-gray-500 hover:text-primary">
                                    <i class="fas fa-eye text-lg" id="current_icon"></i>
                                </button>
                                @error('current_password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <!-- New Password -->
                            <div class="relative">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">New Password</label>
                                <input type="password" name="new_password" id="new_password" autocomplete="off"
                                       class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                                <button type="button" onclick="togglePassword('new')"
                                        class="absolute inset-y-0 right-0 flex items-center pr-4 pt-8 text-gray-500 hover:text-primary">
                                    <i class="fas fa-eye text-lg" id="new_icon"></i>
                                </button>
                                @error('new_password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <!-- Confirm New Password -->
                            <div class="relative">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Confirm New Password</label>
                                <input type="password" name="new_password_confirmation" id="confirm_password" autocomplete="off"
                                       class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                                <button type="button" onclick="togglePassword('confirm')"
                                        class="absolute inset-y-0 right-0 flex items-center pr-4 pt-8 text-gray-500 hover:text-primary">
                                    <i class="fas fa-eye text-lg" id="confirm_icon"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-end pt-8">
                        <button type="button" onclick="history.back()"
                                class="w-full sm:w-auto px-8 py-3 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-100 font-medium transition">
                            Cancel
                        </button>
                        <button type="submit"
                                class="w-full sm:w-auto px-10 py-3 bg-primary text-white font-bold rounded-xl hover:bg-orange-600 transition shadow-lg">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Font Awesome CDN (Eye Icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
          integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBn3SRdU" crossorigin="anonymous" />

    <!-- Scripts Stack -->
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Toggle Password Function (clean & reliable)
        function togglePassword(type) {
            const fields = {
                'current': 'current_password',
                'new': 'new_password',
                'confirm': 'new_password_confirmation'
            };

            const field = document.getElementById(fields[type]);
            const icon = document.getElementById(type + '_icon');

            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        // Success Alert
        @if(session('swal_success'))
            Swal.fire({
                icon: 'success',
                title: 'Updated!',
                text: '{{ session('swal_success') }}',
                confirmButtonColor: '#FF7A28',
                timer: 4000,
                timerProgressBar: true,
                toast: false,
                position: 'top-end',
                showConfirmButton: false
            });
        @endif

        // Error Alert
        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: `
                    @foreach($errors->all() as $error)
                        <div class="text-left mb-2 text-sm">• {{ $error }}</div>
                    @endforeach
                `,
                confirmButtonColor: '#FF7A28'
            });
        @endif
    </script>
    @endpush

</x-admin.admin-layout>
